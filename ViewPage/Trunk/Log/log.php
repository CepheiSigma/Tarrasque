<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/10/16
 * Time: 11:17 AM
 */

require_once ("../../../Vendor/Smarty/Template.class.php");
require_once ('../../../Trunk/Core/Bootstrap.php');
if(!empty($_GET["getlog"])){
    echo \Trunk\Core\Core::getInstance()->singletonMake("system-log")->getLog($_GET["log"]);
}else {
    Template::assign("logs", \Trunk\Core\Core::getInstance()->singletonMake("system-log")->getLogTrunks("error"));
    Template::display("Trunk/Log/log.tpl");
}