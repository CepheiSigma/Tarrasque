<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 11/24/15
 * Time: 2:36 PM
 */
require_once(ROOT_PATH."Storage/Core/Config/CoreConfig.php");

function autoload($className)
{
    foreach (CoreConfig::$autoMap as $class => $path) {
        if ($class == $className) {
            require_once(__DIR__ . "/" . $path);
            return;
        }
    }

    $array = explode('\\', $className);
    if (count($array) > 0) {
        $requirePath = ROOT_PATH;
        for ($i = 0; $i < count($array); $i++) {
            if($i==0)
                $requirePath .= $array[$i];
            else
                $requirePath .= '/' . $array[$i];
        }
        if(file_exists($requirePath . '.php')) {
            require_once $requirePath . '.php';
            return;
        }
    }

    $array = explode('\\', $className);
    if (count($array) > 0) {
        $requirePath ='';
        for ($i = 0; $i < count($array); $i++) {
            $requirePath .= '/' . $array[$i];
        }
        if(file_exists(ROOT_PATH.'Vendor'.$requirePath .'.php')) {
            require_once(ROOT_PATH . 'Vendor' . $requirePath . '.php');
            return;
        }
    }

    error_log("[".date("Y:m:d H:i:s",time())."]Can't find $className\n", 3, ROOT_PATH."Storage/Core/Log/errors.log");
}

spl_autoload_register('autoload');