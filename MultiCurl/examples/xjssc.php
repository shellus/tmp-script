<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/23
 * Time: 9:28
 */

require __DIR__ . '/../vendor/autoload.php';


$url = 'http://www.xjflcp.com/game/SelectDate';
$data = ['selectDate'=>'20161122'];

$request = new MultiCurl\FormRequest($url, $data);

$request -> setClosure(function (\MultiCurl\Response $response){
    /** @var \MultiCurl\Response $response */
    var_dump(strlen($response -> getContent()));
});

$m = new \MultiCurl\MultiCurl();

$m -> addRequest($request);

$m -> exec();