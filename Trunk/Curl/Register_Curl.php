<?php


/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 11/25/15
 * Time: 10:03 AM
 */

namespace Trunk\Curl;


use Trunk\Core\Core;

class Register_Curl{
    public function register($name){
        Core::getInstance()->bind($name,function(){;
            return new Curl();
        });
    }
}