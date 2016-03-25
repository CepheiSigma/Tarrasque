<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 11/25/15
 * Time: 10:12 AM
 */

namespace Trunk\DataBase;

use PDO;
use Trunk\Core\Core;

class DataBase{
    private $db=null;
    private $config = [];

    public function __construct()
    {
        try {
            if (file_exists(ROOT_PATH . "Storage/DataBase/connection.conf")) {
                $this->config = parse_ini_file(ROOT_PATH . "Storage/DataBase/connection.conf");
                $this->initDB($this->config["address"], $this->config["username"], $this->config["password"], $this->config["database"], $this->config["type"], $this->config["charset"]);
            } else
                $this->initDB('127.0.0.1', 'root', 'root', 'jupiter');
        }catch(\PDOException $ex){
            Core::getInstance()->make("system-log")->levelLog("{$ex->getMessage()}","error","system-database");
        }
    }


    public function initDB($host,$userName,$passWord,$dbName,$driver="mysql",$charset='utf-8'){
        $this->db = new PDO("$driver:host=$host;dbname=$dbName",$userName,$passWord);
        $this->exec("set names '$charset'");
    }

    public function exec($sql){
        if($this->db===null){
            return;
        }
        $count = $this->db->exec($sql);
        $this->checkError();
        return $count;
    }

    public function first($sql){
        $dataSet = $this->db->query($sql);
        if($dataSet!=null)
            return $dataSet->fetch(PDO::FETCH_OBJ);
    }

    public function get($sql){
        $dataSet = $this->db->query($sql);
        if($dataSet!=null)
            return $dataSet->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($table,$fill){
        if(is_array($fill)) {
            $sql = "insert into $table ";
            $field = "(";
            $value = "(";
            $count = 0;
            foreach ($fill as $key => $val) {
                $count++;
                if ($count == count($fill)) {
                    $field .= $key . ")";
                    $value .= "'$val')";
                } else {
                    $field .= $key . ",";
                    $value .= "'$val',";
                }
            }
            $sql .= $field . " values $value";
            $this->exec($sql);
        }else{
            $sql = "insert into $table ".$fill;
            $this->exec($sql);
        }
        return $this->db->lastInsertId();
    }

    public function update($table,$fill,$where=""){
        if(is_array($fill)) {
            $sql = "update $table set ";
            $count = 0;
            foreach ($fill as $key => $val) {
                $count++;
                if ($count == count($fill)) {
                    $sql .= "$key='$val' ";
                } else {
                    $sql .= "$key='$val',";
                }
            }
            $sql .=$where;
            return $this->exec($sql);
        }
    }

    private function checkError(){
        if($this->db->errorCode !='00000'){
            $errorInfo = $this->db->errorInfo();
            Core::getInstance()->make("system-log")->levelLog("sql:$errorInfo[2]","error","system-database");
            return $errorInfo;
        }
    }

    public function getLastError(){
        return $this->db->errorCode;
    }

    public function getLastErrorInfo(){
        if($this->db->errorCode !='00000') {
            return $this->db->errorInfo();
        }
        return false;
    }

    public function setConnectionSetting($address,$username,$password,$database,$type,$charset){
        $this->config["address"] = $address;
        $this->config["username"] = $username;
        $this->config["password"] = $password;
        $this->config["database"] = $database;
        $this->config["type"] = $type;
        $this->config["charset"] = $charset;
        $conf = "";
        foreach($this->config as $key=>$value){
            $conf .="$key = $value\n";
        }
        file_put_contents(ROOT_PATH."Storage/DataBase/connection.conf",$conf);

    }

    public function getConnectionSetting(){
        return $this->config;
    }
}