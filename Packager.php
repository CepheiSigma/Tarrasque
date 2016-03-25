<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/16/16
 * Time: 5:30 PM
 */

require_once 'Trunk\Core\Core.php';

class Packager{
    public function packInstallPackage($dir){
        if(is_dir($dir)) {
            $fileList = [];
            $dependence = [];
            $id = md5(time());
            $trunks = \Trunk\Core\Core::getInstance()
                ->singletonMake("system-installer")
                ->getAllInstalledTrunks();
            $this->searchDir($dir, $fileList);
            foreach ($fileList as $name => $file) {
                if (strpos($name, ".php")) {
                    $content = file_get_contents($file);
                    if (preg_match_all("/Core::getInstance\(\)->singletonMake\(['\"](.*?)['\"]\)/", $content, $singleDependence)) {
                        foreach ($singleDependence[1] as $sdependence) {
                            if (!empty($trunks[$dependence])) {
                                $dependence[] = ["name" => $sdependence, "required" => $trunks[$dependence]["version"]];
                            }
                        }
                    }
                }
            }
            $install = [
                "id" => $id,
                "name" => "",
                "register" => "",
                "icon" => "",
                "enable" => 1,
                "tag" => "baidusign",
                "version" => 1.0,
                "description" => "",
                "manager_url" => "",
                "author" => "",
                "files" => $fileList,
                "dependence" => $dependence
            ];

        }
    }

    function searchDir($path,&$data){
        if(is_dir($path)){
            $dp=dir($path);
            while($file=$dp->read()){
                if($file!='.'&& $file!='..'){
                    $this->searchDir($path.'/'.$file,$data);
                }
            }
            $dp->close();
        }
        if(is_file($path)){
            $data[basename($path)]=$path;
        }
    }
}