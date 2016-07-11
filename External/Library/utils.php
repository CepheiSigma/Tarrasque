<?php


set_exception_handler("onExceptionOccurred");

function onExceptionOccurred($exception){
    echoResponse(json_encode([
        "code"=>$exception->getCode(),
        "summary"=>$exception->getMessage(),
        "trace"=>$exception->getTrace()
    ]),500);
}

function echoResponse($obj,$statusCode = 200,$CORS=true){
    if(is_array($obj)) {
        header("count:".count($obj));
        header("Content-Type:application/json");
        $obj = json_encode($obj);
    }
    if(is_object($obj)) {
        header("Content-Type:application/json");
        $obj = json_encode($obj);
    }
    if($CORS){
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials:true");
        header("Access-Control-Expose-Headers:count");
        header("Access-Control-Allow-Methods:PUT,GET,POST,DELETE,PATCH");
    }
    http_response_code($statusCode);
    echo $obj;
}