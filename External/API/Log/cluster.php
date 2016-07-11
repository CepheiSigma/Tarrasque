<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 2016/7/7
 * Time: 10:27
 */

use Trunk\Core\Core;

require_once ('../../../Trunk/Core/Bootstrap.php');
include_once ('../../Library/utils.php');

$logger = Core::getInstance()->singletonMake("system-log");
$operation = isset($_REQUEST["operation"])?$_REQUEST["operation"]:"";
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        switch ($operation) {
            case "get_log":
                echoResponse($logger->getLog($_GET["log"]));
                break;
            case "get_log_list":
                echoResponse($logger->getLogTrunks());
                break;
            default:
                echoResponse(["code"=>404,"summary"=>"Operation not defined"],404);
                break;
        }
        break;
    case "OPTIONS":
        echoResponse("");
        break;
    default:
        echoResponse(["code"=>405,"summary"=>"Method not allowed"],405);
        break;
}
