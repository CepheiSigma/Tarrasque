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

$cron = Core::getInstance()->singletonMake("system-cron");
$operation = isset($_REQUEST["operation"])?$_REQUEST["operation"]:"";
$operation = isset($_REQUEST["operation"])?$_REQUEST["operation"]:"";
switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        switch ($operation) {
            case "change_step":
                $step = $_POST["step"];
                $cron->changeStep($step);
                echoResponse("");
                break;
            default:
                echoResponse(["code"=>404,"summary"=>"Operation not defined"],404);
                break;
        }
        break;
    case "GET":
        switch ($operation) {
            case "get_task_list":
                echoResponse($cron->getTracerList());
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
