<?='<?php'?>

$url = '<?=$url?>';

$ch = curl_init($url);


$headers = [
<?php foreach ($data_headers as $header): ?>
    '<?=$header;?>',
<?php endforeach; ?>
];

<?php if(!empty($cookies)):?>
$cookies = [
<?php foreach ($cookies as $cookie): ?>
    ['<?=$cookie[0];?>', '<?=$cookie[1];?>'],
<?php endforeach; ?>
];

foreach ($cookies as $cookie){
    $cs[] = implode('=', $cookie);
}
curl_setopt($ch, CURLOPT_COOKIE, implode('; ', $cs));
<?php endif;?>

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0); // 不返回headers
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 不直接输出
curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); // 自适应gzip
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 跟随跳转

<?php if(!empty($form_data)):?>
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    <?php foreach ($form_data as $key => $value): ?>
    '<?=$key?>' => '<?=$value?>',
    <?php endforeach; ?>
]));
<?php endif;?>

$body = curl_exec($ch);

if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

curl_close($ch);

var_dump($body);