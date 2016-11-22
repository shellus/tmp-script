<?php

for($i = 0; $i < 32; $i++)
{
    $r = 1 << $i;

    $s = str_pad(decbin($r), 32, '0', STR_PAD_LEFT);

    var_dump($r);
    var_dump($s);
}
