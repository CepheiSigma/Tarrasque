<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/9/16
 * Time: 3:30 PM
 */
require_once ('../Vendor/Smarty/Template.class.php');
header('Access-Control-Allow-Origin:*');

$ajax = $_GET["ajax"];
if($ajax==true) {
    $systemInfo = [];
    switch (PHP_OS) {
        case 'Darwin':
            $systemInfo = getSystemInfo_Darwin();
            break;
        case 'Linux':
            $systemInfo = getSystemInfo_Linux();
            break;
        case 'WIN32':
        case 'Windows':
        case 'WINNT':
            $systemInfo = getSystemInfo_Win32();
            break;
        case 'Unix':

            break;
        default:
            break;
    }
    $systemInfo["timestamp"] = time();
    echo json_encode($systemInfo);
}else{
    $systemInfo = [];
    switch (PHP_OS) {
        case 'Darwin':
            $systemInfo = getSystemInfo_Darwin(false);
            $systemInfo["os"]["type"] = "Mac OS X";
            break;
        case 'Linux':
            $systemInfo = getSystemInfo_Linux(false);
            $systemInfo["os"]["type"] = "Linux";
            break;
        case 'WIN32':
        case 'Windows':
        case 'WINNT':
            $systemInfo = getSystemInfo_Win32(false);
            $systemInfo["os"]["type"] = "Windows";
            break;
        case 'Unix':

            break;
        default:
            break;
    }
    $systemInfo["timestamp"] = time();
    switch(count($systemInfo["cpus"][0]["cores"])){
        case 1:
            $systemInfo["cpus"][0]["corenumber"] = "Single-Core";
            break;
        case 2:
            $systemInfo["cpus"][0]["corenumber"] = "Dual-Core";
            break;
        case 4:
            $systemInfo["cpus"][0]["corenumber"] = "Quad-Core";
            break;
        case 6:
            $systemInfo["cpus"][0]["corenumber"] = "Hexa-Core";
            break;
        case 10:
            $systemInfo["cpus"][0]["corenumber"] = "Deca-Core";
            break;
        case 12:
            $systemInfo["cpus"][0]["corenumber"] = "Dodeca-Core";
            break;
    }
    for ($i=0;$i<count($systemInfo["disks"]);$i++) {
        if(empty($systemInfo["disks"][$i]["percent"]))
            $systemInfo["disks"][$i]["percent"] = sprintf("%.2f",(1 - ( $systemInfo["disks"][$i]["freesize"]/ $systemInfo["disks"][$i]["totalsize"]))*100);
    }
    Template::assign('info', $systemInfo);
    Template::display("systeminfo.tpl");
}

function getSystemInfo_Darwin($ajax=true){
    //exec("/usr/sbin/system_profiler SPHardwareDataType",$result);
    $result = shell_exec("/usr/sbin/system_profiler SPHardwareDataType");
    $cpuName = shell_exec("/usr/sbin/sysctl -n machdep.cpu.brand_string");
    $info = [];
    if(preg_match_all("/.*?: (.*?)\n/",$result,$arr)){
        $cpu =["name"=>trim($cpuName)];
        $cpu["cores"]=[];
        for($i=0;$i<$arr[1][5];$i++){
            $cpu["cores"][]=$arr[1][2];
        }
        $cpu["speed"]=$arr[1][3];
        $info["cpus"][]=$cpu;
        $info["memory"]["size"] = $arr[1][8];
        $info["memory"]["type"] = "DDR";
    }
    $result = shell_exec("/usr/bin/sw_vers");
    if(preg_match_all("/.*?:\t(.*?)\n/",$result,$arr)){
        $info["os"]=[];
        $info["os"]["name"]=$arr[1][0];
        $info["os"]["version"]=$arr[1][1]."@".$arr[1][2];
    }
    $info["runtime"]=[];
    $info["runtime"]["cpu"]= trim(shell_exec("ps -A -o %cpu | awk '{s+=$1} END {print s }'"));
    $info["runtime"]["physicalmemory"]= trim(shell_exec("ps -A -o pmem | awk '{s+=$1} END {print s }'"));
    $info["runtime"]["realmemory"]= trim(shell_exec("ps -A -o %mem | awk '{s+=$1} END {print s }'"));
    $diskList = shell_exec("/usr/sbin/diskutil list");
    if(!$ajax) {
        if (preg_match_all("/\/dev\/disk.+?/", $diskList, $arr)) {
            for ($i = 0; $i < count($arr[0]); $i++) {
                $disk = [];
                if (preg_match("/Device \/ Media Name:([\s\S]*?)\n/", shell_exec("/usr/sbin/diskutil info {$arr[0][$i]}"), $diskName))
                    $disk["name"] = trim($diskName[1]);
                else
                    $disk["name"] = "";
                $totalSize = 0;
                $freeSize = 0;
                $j = 1;
                $countine = true;
                do {
                    $partitionInfo = shell_exec("/usr/sbin/diskutil info {$arr[0][$i]}s$j");
                    if (strpos($partitionInfo, "Could not find disk") !== false) {
                        $countine = false;
                    } else {
                        preg_match_all("/([0-9]+?) Bytes/", $partitionInfo, $sizes);
                        $totalSize += $sizes[1][0];
                        if (isset($sizes[1][1])) {
                            $freeSize += $sizes[1][1];
                        }
                    }
                    $j++;
                } while ($countine);
                $disk["totalsize"] = $totalSize;
                $disk["freesize"] = $freeSize;
                $info["disks"][] = $disk;
            }

        }
    }
    return $info;
}

function getSystemInfo_Win32($ajax=true){
    exec("wmic cpu get name",$cpuName);
    $cpu =["name"=>trim($cpuName[1])];
    $cpu["cores"]=[];
    exec("wmic cpu get NumberOfCores",$cpuCores);
    for($i=0;$i<$cpuCores[1];$i++){
        $cpu["cores"][]= $cpu['name'];
    }
    exec("wmic cpu get maxclockspeed",$cpuSpeed);
    $cpu["speed"]= (trim($cpuSpeed[1])/1000).' GHz';
    $info["cpus"][]=$cpu;

    exec("wmic memorychip get Capacity",$memoryInfo);
    $info["memory"]["size"] =($memoryInfo[1]/1024/1024/1024) ." GB";
    $info["memory"]["type"] = "DDR";

    exec("wmic os get Caption",$osInfo);
    $info["os"]=[];
    $encode = mb_detect_encoding($osInfo[1], array("ASCII","UTF-8","GB2312","GBK","BIG5"));
    $info["os"]["name"]=iconv($encode,"UTF-8",$osInfo[1]);
    $info["os"]["version"]="Release";

    $info["runtime"]=[];
    exec("wmic cpu get LoadPercentage",$cpuUsage);
    exec("wmic os get FreePhysicalMemory",$freeMemory);
	exec("wmic os get TotalVisibleMemorySize",$totalMemory);
    $info["runtime"]["cpu"]=$cpuUsage[1];
    $info["runtime"]["physicalmemory"]= sprintf("%.2f",(1 - ( $freeMemory[1]/$totalMemory[1]))*100);
    $info["runtime"]["realmemory"]= sprintf("%.2f",(1 - ( $freeMemory[1]/$totalMemory[1]))*100);

    if(!$ajax) {
        exec("wmic LOGICALDISK get name,size,freespace", $disks);
        for ($i = 1; $i < count($disks); $i++) {
            $disk = [];
            if (preg_match_all("/([0-9]+).*([A-Z]{1}):[\s]*([0-9]+)$/", $disks[$i], $arr)) {
                $disk["name"] = $arr[2][0];
                $disk["totalsize"] = $arr[3][0];
                $disk["freesize"] = $arr[1][0];
                $info["disks"][] = $disk;
            }
        }

    }
    return $info;
}

function getSystemInfo_Linux($ajax){
    $str = @file("/proc/cpuinfo");
    $str = implode("", $str);
    @preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(\@.-]+)([\r\n]+)/s", $str, $model);
    @preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);

    $cpu =["name"=>trim($model[1][0])];
    $cpu["cores"]=[];
    for($i=0;$i<sizeof($model[1]);$i++){
        $cpu["cores"][]= $cpu['name'];
    }
    $cpu["speed"]= $mhz[1][0];
    $info["cpus"][]=$cpu;

    $str = @file("/proc/meminfo");
    $str = implode("", $str);
    preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
    preg_match_all("/Buffers\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buffers);

    $totalMemory = round($buf[1][0]/1024, 2);
    $freeMemory = round($buf[2][0]/1024, 2);
   $bufferMemory = round($buffers[1][0]/1024, 2);
    $cachedMemory = round($buf[3][0]/1024, 2);


    $realUsedMemory = $totalMemory - $freeMemory -$cachedMemory - $bufferMemory; //真实内存使用

    $info["memory"]["size"] =round($totalMemory/1024,2) ." GB";
    $info["memory"]["type"] = "DDR";

    $info["os"]=[];
    $info["os"]["name"]=shell_exec("cat /etc/issue");
    $info["os"]["version"]="Release";

    $info["runtime"]=[];

    $mode = "/(cpu)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/";
    $string=shell_exec("more /proc/stat");
    preg_match_all($mode,$string,$arr);
//print_r($arr);
    $total1=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[5][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];
    $time1=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];

    sleep(1);
    $string=shell_exec("more /proc/stat");
    preg_match_all($mode,$string,$arr);
    $total2=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[5][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];
    $time2=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];
    $time=$time2-$time1;
    $total=$total2-$total1;
    $percent=bcdiv($time,$total,3);
    $percent=$percent*100;

    $info["runtime"]["cpu"]=$percent;
    $info["runtime"]["physicalmemory"]= (floatval($totalMemory)!=0)?round($realUsedMemory/$totalMemory*100,2):0;
    $info["runtime"]["realmemory"]=  (floatval($cachedMemory)!=0)?round($cachedMemory/$totalMemory*100,2):0;

    if(!$ajax) {
        $disk = [];
        $dt = round(@disk_total_space(".")/(1024*1024*1024),3); //总
        $df = round(@disk_free_space(".")/(1024*1024*1024),3); //可用
        $disk["name"] = "/dev/";
        $disk["totalsize"] =$dt;
        $disk["freesize"] =$df;
        $info["disks"][] = $disk;
//        $result = exec("/sbin/fdisk -l |grep 'Disk /dev/'");
//        if(preg_match_all("/\/dev\/[\S]:/",$result,$disks))
//        for ($i = 1; $i < count($disks); $i++) {
//
//            $percent = shell_exec("/bin/df /dev/sda |grep \"[0-9]\{1,3\}%\"");
//            $disk["name"] = $disks[$i];
//            $disk["percent"] = str_replace("%", "", $percent);
//            $info["disks"][] = $disk;
//
//        }
//        echo ($result);
    }
    return $info;
}

