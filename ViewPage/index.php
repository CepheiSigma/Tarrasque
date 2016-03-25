<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/9/16
 * Time: 3:05 PM
 */

use Trunk\Core\Core;

require_once ('../Vendor/Smarty/Template.class.php');
require_once ('../Trunk/Core/Bootstrap.php');

Template::assign('trunks', Core::getInstance()->singletonMake("system-installer")->getAllInstalledTrunks());
Template::display("index.tpl");



