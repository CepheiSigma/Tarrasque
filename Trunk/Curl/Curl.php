<?php
/**
 * Created by PhpStorm.
 * User: cephei
 * Date: 11/25/15
 * Time: 9:35 AM
 */

namespace Trunk\Curl;

class Curl
{
    public $header = false;
    public $httpHeader = [];
    public $method = "GET";
    public $formData=[];
    public $cookies=[];
    public $cookiePath="";
    public $httpVersion=CURL_HTTP_VERSION_1_1;
    public $lastResponse=null;
    public $request;
    public $certPath;
    public $proxy='';
    public $proxyAddress='';
    public $timeOut = 30;

    public function __construct(){
        $this->request = curl_init();
    }
    public function sendRequest($url){
        if($this->request==null)
            $this->request = curl_init();
        $request = $this->request;
        $ssl = strpos($url,"https://")===false?false:true;
        curl_setopt($request,CURLOPT_HEADER,$this->header);
        curl_setopt($request,CURLOPT_HTTPHEADER,$this->httpHeader);
        if($this->method=="GET")
            curl_setopt($request,CURLOPT_POST,0);
        else if($this->method=="POST"){
            curl_setopt($request,CURLOPT_POST,1);
            if(is_array($this->formData))
                curl_setopt($request,CURLOPT_POSTFIELDS,http_build_query($this->formData));
            else
                curl_setopt($request,CURLOPT_POSTFIELDS,$this->formData);
        }else
            curl_setopt($request,CURLOPT_CUSTOMREQUEST,$this->method);
        if($this->cookiePath!=""){
            curl_setopt($request,CURLOPT_COOKIEFILE,$this->cookiePath);
            curl_setopt($request,CURLOPT_COOKIEJAR,$this->cookiePath);
        }else {
            $cookieStr = '';
            foreach ($this->cookies as $key => $value) {
                $cookieStr .= ";$key=$value";
            }
            if (strlen($cookieStr) > 1) {
                $cookieStr = substr($cookieStr, 1);
            }

            curl_setopt($request, CURLOPT_COOKIE, $cookieStr);
        }
        if($ssl) {
            curl_setopt($request,CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($request,CURLOPT_SSL_VERIFYPEER, false);
        }
        if($this->proxy!=''){
            $proxyType = 0;
            switch($this->proxy){
                case "HTTP":
                    $proxyType = CURLPROXY_HTTP;
                    break;
                case "SOCKS":
                    $proxyType = CURLPROXY_SOCKS4;
                    break;
                case "SOCKS5":
                    $proxyType = CURLPROXY_SOCKS5;
                    break;
            }
            curl_setopt($request,CURLOPT_PROXYTYPE,$proxyType);
            curl_setopt($request,CURLOPT_PROXY,$this->proxyAddress);
        }
        curl_setopt($request,CURLOPT_TIMEOUT,$this->timeOut);
        curl_setopt($request,CURLOPT_HTTP_VERSION,$this->httpVersion);
        curl_setopt($request,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($request,CURLOPT_URL,$url);
        $this->lastResponse = curl_exec($request);
        return $this->lastResponse;
    }

    public function addToHttpHeader($key,$value){
        $this->httpHeader[]="$key:$value";
    }
    public function addToHttpForm($key,$value){
        $this->formData[$key]=$value;
    }
    public function addToCookie($key,$value){
        $this->cookies[$key]=$value;
    }
    public function getError(){
        return curl_error($this->request);
    }
    public function close(){
        curl_close($this->request);
        $this->request = null;
    }

    public function getInfo(){
        return curl_getinfo($this->request);
    }

}