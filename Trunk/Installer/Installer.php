<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/6/16
 * Time: 8:21 PM
 */

namespace Trunk\Installer;

use Trunk\Core\Core;

class Installer{
    private $dependenceRepo = "http://git.oschina.net/CepheiLab/Tarrasque_Trunk-Repo/raw/master/";
    private $modules=[];

    public function __construct()
    {
        $json = file_get_contents(ROOT_PATH . 'Storage/Core/Config/Trunks.json');
        $this->modules = json_decode($json, true);
    }

    public function installTrunk($filePath, $force=true)
    {
        $zipFile = zip_open($filePath);
        if ($zipFile) {
            $fileList = [];
            $installScript = '';
            while ($zipEntry = zip_read($zipFile)) {
                $fileName = zip_entry_name($zipEntry);
                if (strpos($fileName, ".install") !== false) {
                    while ($data = zip_entry_read($zipEntry)) {
                        $installScript .= $data;
                    }
                } else {
                    while ($data = zip_entry_read($zipEntry)) {
                        $fileList[$fileName] .= $data;
                    }
                }
            }
            zip_close($zipFile);
            $config = [];
            if ($installScript != "") {
                $installObject = json_decode($installScript, true);
                $config["id"] = $installObject["id"];
                $config["name"] = $installObject["name"];
                $config["register"] = $installObject["register"];
                $config["version"] = $installObject["version"];
                $config["icon"] = $installObject["icon"];
                $config["tag"] = $installObject["tag"];
                $config["description"] = $installObject["description"];
                $config["manager_url"] = $installObject["manager_url"];
                $config["author"] = $installObject["author"];
                $config["files"] = $installObject["files"];
                $config["enable"] = 1;
                if (isset($installObject["dependence"])) {
                    foreach ($installObject["dependence"] as $dependence) {
                        if (!(isset($this->modules[$dependence["name"]]) && $this->modules[$dependence["name"]]["version"] >= $dependence["required"])) {
                            $dependenceFile = $this->solveDependence($dependence["name"], $dependence["required"]);
                            if ($dependenceFile !== false) {
                                $this->installTrunk($dependenceFile);
                            } else {
                                exit(-1);
                            }
                        }
                    }
                }
            }

            foreach ($fileList as $key => $value) {
                $key = $config["files"][$key];
                $file = fopen($this->createPath($key), 'w');
                if($file!==false) {
                    fwrite($file, $value);
                    fclose($file);
                }
            }
            if ($config["register"]) {
                $instance = new $config["register"]();
                if($config["version"]>$this->modules[$config["name"]]){
                    if (method_exists($instance, 'update')) {
                        $instance->update();
                    }
                }else if(empty($this->modules[$config["name"]])||$force) {
                    if (method_exists($instance, 'install')) {
                        $instance->install();
                    }
                }
                if (method_exists($instance, 'register')) {
                    $instance->register($config["name"]);
                }
            }

            $this->addToModule($config);
            @unlink($filePath);
        }
    }

    public function uninstallTrunk($trunkName){
        if(!empty($trunk = $this->modules[$trunkName])){
            $register = new $trunk["register"]();
            if(method_exists($register,"uninstall"))
                $register->uninstall();
            foreach($trunk["files"] as $file)
                @unlink(ROOT_PATH.$file);
            $index = array_search(array_keys($this->modules),$this->modules);
            if($index!==false)
                array_splice($this->modules,$index,1);
            file_put_contents(ROOT_PATH . 'Storage/Core/Config/Trunks.json', json_encode($this->modules));
        }
    }

    public function getTrunkByTag($tag,$single=false){
        foreach($this->modules as $key=>$value){
            if($value["tag"]==$tag){
                if($single)
                    return Core::getInstance()->singletonMake($key);
                else
                    return Core::getInstance()->make($key);
            }
        }
        return false;
    }

    public function getTrunkNamesByTag($tag){
        $list = [];
        foreach($this->modules as $key=>$value){
            if($value["tag"]==$tag){
                $list[] = $key;
            }
        }
        return $list;
    }

    private function createPath($fileName)
    {
        $pathList = explode('/', $fileName);
        $path = ROOT_PATH;
        for ($i = 0; $i < count($pathList) - 1; $i++) {
            $path = $path . $pathList[$i].'/';
            if (!is_dir($path)) ;
                mkdir($path);
        }
        return $path.$pathList[count($pathList)-1];

    }

    public function addToModule($config)
    {
        $json = file_get_contents(ROOT_PATH . 'Storage/Core/Config/Trunks.json');
        $obj = json_decode($json, true);
        $config["install_time"] = time();
        $obj[$config["name"]] =$config;
        $json = json_encode($obj);
        file_put_contents(ROOT_PATH . 'Storage/Core/Config/Trunks.json', $json);

    }

    public function solveDependence($id,$version){
        if(array_key_exists("system-curl",$this->modules)) {
            $http = Core::getInstance()->make("system-curl");
            $response = $http->sendRequest("{$this->dependenceRepo}$id/$id.$version.zip");
            $this->createPath("Storage/Installer/Cache/");
            $fileName = "Storage/Installer/Cache/". md5(time()) . ".zip";
            file_put_contents($fileName, $response);
            return $fileName;
        }
        Core::getInstance()->make("log")->levelLog("Curl-Plugin is not exits can't install dependence [$id - $version] from network!","error","system-installer");
        return false;

    }

    public function getAllInstalledTrunks(){
        return $this->modules;
    }
}

