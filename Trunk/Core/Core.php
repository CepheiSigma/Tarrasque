<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 11/24/15
 * Time: 4:27 PM
 */
namespace Trunk\Core;

use Closure;

class Core{
    protected $bindings=[];
    protected $instances=[];
    private static $coreInstance=null;


    public function __construct(){
        static::$coreInstance = $this;
    }

    public function bind($key,$value){
        $this->bindings[$key] = $value;
    }
    public function make($key){
        if(!array_key_exists($key,$this->bindings))
            return null;
        if($this->bindings[$key] instanceof Closure){
            $instance = $this->bindings[$key]();
            return $instance;
        }
        error_log("[".date("Y:m:d H:i:s",time())."]Can't init $key\n", 3, ROOT_PATH."Storage/Core/Log/errors.log");
        return null;
    }

    public function singletonMake($key){
        if(!array_key_exists($key,$this->bindings))
            return null;
        if(isset($this->instances[$key]))
            return $this->instances[$key];
        if($this->bindings[$key] instanceof Closure){
            $instance = $this->bindings[$key]();
            $this->instances[$key] = $instance;
            return $instance;
        }
        error_log("[".date("Y:m:d H:i:s",time())."]Can't init $key\n", 3, ROOT_PATH."Storage/Core/Log/errors.log");
        return null;
    }

    public function getBindings(){
        return $this->bindings;
    }

    static function getInstance(){
        return static::$coreInstance;
    }

}