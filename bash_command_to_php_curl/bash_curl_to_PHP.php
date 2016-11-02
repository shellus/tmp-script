<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/23
 * Time: 13:33
 */

require 'parse_command_line.php';

$str = <<<EHO
curl http://config.pinyin.sogou.com/api/toolbox/geturl.php?h=CE7B8B67F8B608F54EC2E96E1FB77B0B&v=8.0.0.8381&r=0000_sogou_pinyin_80m
EHO;

$request_info = parse_command_line($str);

$data_headers = [];
foreach ($request_info['options']['-H'] as $line)
{
    $t = explode(': ', $line);
    if(strtolower($t[0]) === 'cookie'){
        // cookie 不直接放进header

        $cookies = [];
        $kvarr = explode('; ', substr($line, strpos($line,': ') + 2));
        foreach ($kvarr as $kv){
            // 之所以用索引数组而非关联数组来储存一组cookie，是因为...
            $cookies[]=explode('=', $kv);
        }
        continue;
    }
    $data_headers[] = $line;
}


$url = $request_info['arguments'][0];

if(key_exists('--data', $request_info['options'])){
    $form_data = [];
    parse_str($request_info['options']['--data'], $form_data);
}

ob_start();
require 'code-tmpl.php';
$teml_data = ob_get_clean();

file_put_contents(__DIR__ . '/curl.php', $teml_data);
