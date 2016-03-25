<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 11/24/15
 * Time: 2:47 PM
 */

define("ROOT_PATH",__DIR__.'/../../');
require_once "AutoLoad.php";

use Trunk\Core\Core;

$container = new Core();
$trunksText = file_get_contents(ROOT_PATH."Storage/Core/Config/Trunks.json");
$trunks = json_decode($trunksText,true);
$providers=[];
foreach($trunks as $key=>$trunk){
    if($trunk["enable"]<=0)
        continue;
    $provider = new $trunk["register"]();
    if(!empty($provider)&&method_exists($provider,'register')) {
        $provider->register($key);
        $providers[] = $provider;
    }
}

foreach($providers as $provider){
    if(method_exists($provider,'autoBoot')){
        $provider->autoBoot();
    }
}