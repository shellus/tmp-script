<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/22
 * Time: 15:21
 */
$str = <<<EHO
curl 'http://welcome66.iteye.com/login' -H 'Cookie: _javaeye_cookie_id_=1472806506635269; __utmt=1; remember_me=yes; _javaeye3_session_=BAh7CToPc2Vzc2lvbl9pZCIlMDBjNGQzMWQ4MGVhYmEzOWY5MzIxNDdlNjJlYWVmYTMiCmZsYXNoSUM6J0FjdGlvbkNvbnRyb2xsZXI6OkZsYXNoOjpGbGFzaEhhc2h7BjoKZXJyb3IiMueZu%2BW9leWQjeensOaIluWvhueggemUmeivr%2B%2B8jOivt%2BmHjeaWsOeZu%2BW9lQY6CkB1c2VkewY7B1Q6EF9jc3JmX3Rva2VuIjEzTFN0M1EycXBtNklLK3RoNVViZktWbFBQM0liWk5PY0dNa3l2M0Y5WlNZPToRb3JpZ2luYWxfdXJpIixodHRwOi8vd2VsY29tZTY2Lml0ZXllLmNvbS9ibG9nLzIxODc5MjM%3D--c47a04670fde0d798cd2ca0f7007f35916143208; __utma=191637234.1805378542.1472806577.1474448132.1474524453.10; __utmb=191637234.3.10.1474524453; __utmc=191637234; __utmz=191637234.1473910032.8.6.utmcsr=baidu|utmccn=(organic)|utmcmd=organic; dc_tos=odw6ep; dc_session_id=1474524529073' -H 'Origin: http://welcome66.iteye.com' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: zh-CN,zh;q=0.8' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Cache-Control: max-age=0' -H 'Referer: http://welcome66.iteye.com/login' -H 'Proxy-Connection: keep-alive' --data 'authenticity_token=3LSt3Q2qpm6IK%2Bth5UbfKVlPP3IbZNOcGMkyv3F9ZSY%3D&name=asdusername&password=asdpassword&remember_me=1&button=%E7%99%BB%E3%80%80%E5%BD%95' --compressed
EHO;
//
//$str =
//<<<EOF
//curl -H 'Host: localhost' -H 'Cookie: sp\' an;'
//EOF;


$arr = [];
$arr_index = 0;

// 下一字符将转义
$next_escape = false;

// 当前在引号内
$in_quote = false;

for ($i = 0; $i < strlen($str); $i++)
{
    $char = substr($str, $i, 1);

    if($char !== '\\'){
        if($char === ' ' and $in_quote === false)
        {
            $arr_index++;
            continue;
        }elseif ($char === '\'')
        {
            $in_quote = !$in_quote;
            continue;
        }
    }else{
        $char = substr($str, ++$i, 1);
    }

    $arr[$arr_index] .= $char;
}

var_dump($arr);