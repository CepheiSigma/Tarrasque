<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 12/9/15
 * Time: 5:10 PM
 */

namespace Trunk\Log;

class Log{
    public function log($message,$destination){
        error_log($message,3,$destination);
    }
    public function levelLog($message,$level,$trunk="system"){
        $time = date('Y-m-d H:i:s',time());
        if(!is_dir(ROOT_PATH."Storage/Log"))
            mkdir(ROOT_PATH."Storage/Log");
        if(!is_dir(ROOT_PATH."Storage/Log/Log"))
            mkdir(ROOT_PATH."Storage/Log/Log");
        switch($level){
            default:
            case "info":
                $this->log("[$time]:$message\n",ROOT_PATH."Storage/Log/Log/{$trunk}_info.log");
                break;
            case "warning":
                $this->log("[$time]:$message\n",ROOT_PATH."Storage/Log/Log/{$trunk}_warning.log");
                break;
            case "error":
                $this->log("[$time]:$message\n",ROOT_PATH."Storage/Log/Log/{$trunk}_error.log");
                break;
            case "daily":
                $time = date('Y-m-d H:i:s',time());
                $fileTime = date('Y-m-d',time());
                $this->log("[$time]:$message\n",ROOT_PATH."Storage/Log/Log/{$trunk}_daily_$fileTime.log");
                break;
        }
    }

    public function getLogTrunks()
    {
        $trunks =[];
        if (false != ($Handle = opendir(ROOT_PATH . "Storage/Log/Log/"))) {
            while (false != ($File = readdir($Handle))) {
                if ($File != '.' && $File != '..' && strpos($File, '.')) {
                    $trunks[] = $File;
                }
            }
            closedir($Handle);
        }
        return $trunks;
    }

    public function getLog($logName){
        if(file_exists(ROOT_PATH . "Storage/Log/Log/$logName"))
            return file_get_contents(ROOT_PATH . "Storage/Log/Log/$logName");
        else
            return "No Log";
    }

    public function deleteLog($logName){
        if(file_exists(ROOT_PATH . "Storage/Log/Log/$logName"))
            return file_get_contents(ROOT_PATH . "Storage/Log/Log/$logName");
        else
            return "No Log";
    }
}
