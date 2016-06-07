<?php
namespace Common\Common;
/**
* 网络请求工具类
*/
class NetUtil
{
    
     /* 请求HTTP数据
     * @param  [type] $url     完整URL地址
     * @param  string $params  POST参数
     * @param  string $method  提交方式GET、POST
     * @param  array  $header  Header参数
     */
    static function http($url, $params = '', $method = 'GET', $header = array()){
        $method = strtoupper($method);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, 1);
            if(!empty($params)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }
        }
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
