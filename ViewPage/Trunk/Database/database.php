<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/10/16
 * Time: 10:29 AM
 */
use Trunk\Core\Core;

require_once ("../../../Vendor/Smarty/Template.class.php");
require_once ('../../../Trunk/Core/Bootstrap.php');

if($_SERVER['REQUEST_METHOD']=="POST"){
    Core::getInstance()->singletonMake("system-database")->setConnectionSetting(
        $_POST["address"],
        $_POST["username"],
        $_POST["password"],
        $_POST["database"],
        $_POST["type"],
        $_POST["charset"]
    );
}
Template::assign("conf",Core::getInstance()->singletonMake("system-database")->getConnectionSetting());
Template::display("Trunk/Database/database.tpl");
