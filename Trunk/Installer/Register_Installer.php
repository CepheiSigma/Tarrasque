<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 3/6/16
 * Time: 8:27 PM
 */
namespace Trunk\Installer;

use Trunk\Core\Core;

class  Register_Installer{
    public function register(){
        Core::getInstance()->bind('system-installer',function(){
            return new Installer();
        });
    }
}