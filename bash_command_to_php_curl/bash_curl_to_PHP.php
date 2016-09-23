<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/23
 * Time: 13:33
 */

require 'parse_command_line.php';

$str = <<<EHO
curl 'https://www.google.com/search?espv=2&biw=1920&bih=950&q=php+curl+%E8%B7%B3%E8%BD%AC&oq=php+curl+%E8%B7%B3%E8%BD%AC&gs_l=serp.12...0.0.1.3026453.0.0.0.0.0.0.0.0..0.0....0...1c..64.serp..0.0.0.oJxfWeTwpkY&bav=on.2,or.&bvm=bv.133700528,d.dGo&fp=25ac533fec87b54f&ion=1&tch=1&ech=1&psi=5-DkV8P6AYjx0ASnrYaoDg.1474617575870.5' -H 'Referer: https://www.google.com/' -H 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36' --compressed
EHO;

$request_info = parse_command_line($str);

$data_headers = [];
foreach ($request_info['options']['-H'] as $line)
{
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
