<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 12/2/15
 * Time: 5:29 PM
 */
namespace Trunk\Cron;

use Trunk\Core\Core;

class Register_Cron{
    public function register($name){
        Core::getInstance()->bind($name,function(){
            return new Cron();
        });
    }
}

