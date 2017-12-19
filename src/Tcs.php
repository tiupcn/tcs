<?php
namespace Tiup\Tcs;
use Cache;
class Tcs
{
    protected $host;
    protected $token;

    public function __construct($config){
        $this->host = $config['host'];
        $this->token = $config['token'];
        $this->prefix = $config['prefix'];
        $this->expire = $config['expire'];
        $this->template = $config['template'];
    }

    //发送短信 
    public function sms($phone, $content){
        $params = array(
            'type' => 'sms',
            'to' => $phone,
            'data' => $content
        );
        $ret = $this->send('/api/v1/push', $params);
        return $ret;
    }

    public function sendVerify($phone){
        $code = rand(1000,9999);
        $cache_key = $this->prefix. $phone;
        Cache::put($cache_key, $code, $this->expire);
        $content = str_replace("#code#", $code, $this->template);
        $this->sms($phone, $content);
        return $code;
    }

    //检查验证码
    public function checkVerify($phone, $input){
        $code = $this->getVerifyCode($phone);
        return $code == $input;
    }   

    public function getVerifyCode($phone){
        $cache_key = $this->prefix. $phone;
        return Cache::get($cache_key);
    }

    public function send($path, $params, $async = false){
        $url = $this->host.$path;

        $curl = new \Curl\Curl;
        $curl->setHeader('Group-Authenticate', $this->token);
        $curl->setHeader('Content-type', 'application/json');
        if ($async){
            $curl->setHeader('Async', 'true');
        }
        $curl->post($url, json_encode($params));
        $response = json_decode($curl->response);
        if ($curl->error) {
            throw new \Exception($curl->error_message.' '.$url, 1);   
        }
        return true;
    }
}
