<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/9/16
 * Time: 5:44 PM
 */
require_once ("../../../Vendor/Smarty/Template.class.php");
require_once ('../../../Trunk/Core/Bootstrap.php');


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $fileName = $_FILES["file"]["tmp_name"];
    \Trunk\Core\Core::getInstance()->singletonMake("system-installer")->installTrunk($fileName);
}

Template::assign("trunks", \Trunk\Core\Core::getInstance()->singletonMake("system-installer")->getAllInstalledTrunks());
Template::display("Trunk/Installer/installer.tpl");