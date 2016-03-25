<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 12/2/15
 * Time: 5:28 PM
 */

namespace Trunk\Cron;


use Trunk\Core\Core;

class Cron
{
    private $trackers;
    private $step=60;

    public function __construct(){
        while(file_exists(ROOT_PATH."Storage/Cron/Config/cron.lock")
            &&$this->checkPID(file_get_contents(ROOT_PATH."Storage/Cron/Config/cron.lock")))
            sleep(10);
        file_put_contents(ROOT_PATH."Storage/Cron/Config/cron.lock",getmypid());
        $conf = json_decode(file_get_contents(ROOT_PATH."Storage/Cron/Config/cron.json"),true);
        $this->trackers = $conf["trackers"];
        $this->step = $conf["step"];
    }

    public function __destruct()
    {
        $conf = ["trackers"=>$this->trackers,"step"=>$this->step];
        file_put_contents(ROOT_PATH."Storage/Cron/Config/cron.json",json_encode($conf));
        @unlink(ROOT_PATH."Storage/Cron/Config/cron.lock");

    }

    public function addCronTask($name,$trunk, $method,$time=60,$args = [])
    {
        $this->trackers[$name] = ["name"=>$name,"plugin"=>$trunk,"method"=>$method,"args"=>json_encode($args),"time"=>$time,"lefttime"=>$time];
    }

    public function removeTask($name){
        $keys = array_keys($this->trackers);
        $index = array_search($name,$keys);
        array_splice($this->trackers,$index,1);
    }

    public function appendTask($name,$trunk, $method,$time=60,$args = []){
        $this->addCronTask($name,$trunk, $method,$time,$args);
    }

    public function exec(){
        $log = Core::getInstance()->make("system-log");
        foreach($this->trackers as $key=>$tracker) {
            $this->trackers[$key]["lefttime"] = $tracker["lefttime"]-$this->step;
            if($tracker["lefttime"]<=0) {
                $this->trackers[$key]["lefttime"] = $tracker["time"];
                $instance = new $tracker["plugin"]();
                if ($instance == null)
                    continue;
                $method = $tracker["method"];
                $args = json_decode($tracker["args"]);
                try {
                    call_user_func_array([$instance, $method], $args);
                    if ($log != null)
                        $log->levelLog("Task - {$tracker["name"]} has been executed", "daily", "system-cron");
                }catch(\Exception $ex){
                    if ($log != null)
                        $log->levelLog("Task - {$tracker["name"]} occurred errors,more information,please check log", "daily", "system-cron");
                }
            }
        }

    }

    public function changeStep($time){
        if(!empty($time)) {
            $this->step = $time;
        }
    }

    public function getTracerList(){
        return $this->trackers;
    }

    private function checkPID($pid){
        switch(PHP_OS){
            case "Darwin":
            case "Linux":
                $count = shell_exec("ps -e|grep -c '^\s*{$pid}'");
                return $count>0;
            default:
                return false;
        }
    }
}
