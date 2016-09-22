<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/16
 * Time: 14:32
 */

$str =
<<<EOF
POST http://welcome66.iteye.com/login HTTP/1.1
Host: welcome66.iteye.com
Proxy-Connection: keep-alive
Content-Length: 154
Cache-Control: max-age=0
Origin: http://welcome66.iteye.com
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36
Content-Type: application/x-www-form-urlencoded
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
Referer: http://welcome66.iteye.com/login
Accept-Encoding: gzip, deflate
Accept-Language: zh-CN,zh;q=0.8
Cookie: _javaeye_cookie_id_=1472806506635269; __utmt=1; remember_me=yes; _javaeye3_session_=BAh7CToPc2Vzc2lvbl9pZCIlMDBjNGQzMWQ4MGVhYmEzOWY5MzIxNDdlNjJlYWVmYTMiCmZsYXNoSUM6J0FjdGlvbkNvbnRyb2xsZXI6OkZsYXNoOjpGbGFzaEhhc2h7BjoKZXJyb3IiMueZu%2BW9leWQjeensOaIluWvhueggemUmeivr%2B%2B8jOivt%2BmHjeaWsOeZu%2BW9lQY6CkB1c2VkewY7B1Q6EF9jc3JmX3Rva2VuIjEzTFN0M1EycXBtNklLK3RoNVViZktWbFBQM0liWk5PY0dNa3l2M0Y5WlNZPToRb3JpZ2luYWxfdXJpIixodHRwOi8vd2VsY29tZTY2Lml0ZXllLmNvbS9ibG9nLzIxODc5MjM%3D--c47a04670fde0d798cd2ca0f7007f35916143208; __utma=191637234.1805378542.1472806577.1474448132.1474524453.10; __utmb=191637234.3.10.1474524453; __utmc=191637234; __utmz=191637234.1473910032.8.6.utmcsr=baidu|utmccn=(organic)|utmcmd=organic; dc_tos=odw6ep; dc_session_id=1474524529073

EOF;

$arr1 = explode("\r\n", trim($str));

$headers = [];
$http_version = '';
$method = '';
$uri = '';
for ($i =0; $i < count($arr1); $i++)
{
    $line = $arr1[$i];
    if($i === 0){
        list($method, $uri, $http_version) = explode(' ', $line);
        continue;
    }

    if($offset = strpos($line, ': ')){
        $key = substr($line, 0, $offset);
        $value = substr($line, $offset + 2);
        $headers[$key] = $value;
    }
}
var_dump($headers, $method, $uri, $http_version);




