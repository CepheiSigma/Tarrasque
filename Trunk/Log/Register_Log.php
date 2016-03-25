<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 12/9/15
 * Time: 5:56 PM
 */
namespace Trunk\Log;

use Trunk\Core\Core;

class Register_Log{
    public function register($name){
        Core::getInstance()->bind($name,function(){
            return new Log();
        });
    }

}