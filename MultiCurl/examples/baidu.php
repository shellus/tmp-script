<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/22
 * Time: 16:41
 */
require __DIR__ . '/../vendor/autoload.php';

$m = new MultiCurl();

//
//$url = 'http://php.net/manual/en/function.curl-multi-select.php';
//
//
//$m -> get(new MultiCurlItem($url, function($item){
//    /** @var MultiCurlItem $item */
//    $data = $item -> getContent();
//        var_dump(strlen($data));
//        var_dump(substr($data, -200));
//    }));


$url = 'http://dl.360safe.com/setup.exe';
$m -> get(new MultiCurlItem($url, function($item){
    /** @var MultiCurlItem $item */
    $data = $item -> getContent();
//    var_dump(strlen($data));
//    var_dump(substr($data, -200));
}));


$m -> exec();