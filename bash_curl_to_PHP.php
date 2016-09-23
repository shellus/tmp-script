<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/23
 * Time: 13:33
 */

require 'parse_command_line.php';

$str = <<<EHO
curl 'http://xcnice.com/?controller=default&action=menu' -H 'Cookie: __nxquid=NR1aSgAAAABEKVYOr4jDTQ==12980010; __nxqsid=14745996600010; _sessionHandler=d9aefb0c368442cc21dbfb0818355cc88a560f1d; isLogin=true; PHPSESSID=b104ee5ebdc8sfqfulhovdse12; __utmt=1; u=shellus; __utma=146161213.502313140.1474599984.1474599984.1474609615.2; __utmb=146161213.4.10.1474609615; __utmc=146161213; __utmz=146161213.1474599984.1.1.utmcsr=xingyunxing111.com|utmccn=(referral)|utmcmd=referral|utmcct=/; __utmv=146161213.|1=version=2.0=1; pmode_selected_value=2; sound=on' -H 'Origin: http://xcnice.com' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: zh-CN,zh;q=0.8' -H 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Accept: */*' -H 'Referer: http://xcnice.com/?nav=24xsc&flaglot=hnquick5' -H 'X-Requested-With: XMLHttpRequest' -H 'Connection: keep-alive' --data 'flag=getmoney' --compressed
EHO;

//$str =
//<<<EOF
//curl 'http://localhost/' -H 'Accept-Encoding: gzip, deflate, sdch' -H 'Accept-Language: zh-CN,zh;q=0.8' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Cache-Control: max-age=0' -H 'Cookie: Phpstorm-8750499e=6f5f9371-382b-4828-88f2-1adcb1afc43f' -H 'Connection: keep-alive' --compressed
//EOF;


$request_info = parse_command_line($str);



$headers = [];
foreach ($request_info['options']['-H'] as $line)
{
    $headers[] = $line;
}

//var_dump($headers);
//die();

$ch = curl_init($request_info['arguments'][0]);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0); // 不返回headers
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 不直接输出
curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); // gzip

if(key_exists('--data', $request_info['options'])){
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_info['options']['--data']);
}

$body = curl_exec($ch);

if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

curl_close($ch);

var_dump($body);