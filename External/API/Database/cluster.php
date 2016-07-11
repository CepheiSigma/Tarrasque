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

$dataBase = Core::getInstance()->singletonMake("system-database");
$operation = isset($_REQUEST["operation"])?$_REQUEST["operation"]:"";
switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        switch ($operation) {
            case "update_settings":
                $dataBase->setConnectionSetting(
                    $_POST["address"],
                    $_POST["username"],
                    $_POST["password"],
                    $_POST["database"],
                    $_POST["type"],
                    $_POST["charset"]
                );
                echoResponse("");
                break;
            default:
                echoResponse(["code"=>404,"summary"=>"Operation not defined"],404);
                break;
        }
        break;
    case "GET":
        switch ($operation) {
            case "get_setting":
                echoResponse($dataBase->getConnectionSetting());
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
