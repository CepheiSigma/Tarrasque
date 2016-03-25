<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/25/16
 * Time: 3:26 PM
 */
require_once ("../../../Vendor/Smarty/Template.class.php");
require_once ('../../../Trunk/Core/Bootstrap.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $step = $_POST["step"];
    \Trunk\Core\Core::getInstance()->singletonMake("system-cron")->changeStep($step);
}

Template::assign("tasks", \Trunk\Core\Core::getInstance()->singletonMake("system-cron")->getTracerList());
Template::display("Trunk/Cron/cron.tpl");