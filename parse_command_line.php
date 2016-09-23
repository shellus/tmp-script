<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/22
 * Time: 15:21
 */


function parse_command_line($str){
    $arr = [];
    $arr_index = 0;

// 下一字符将转义
    $next_escape = false;

// 当前在引号内
    $in_quote = false;

// 当前值需编码ANSI
    $to_ansi = false;

    for ($i = 0; $i < strlen($str); $i++)
    {

        if(substr($str, $i, 1) === '\\'){
            // 如果是转义字符

            $arr[$arr_index] .= substr($str, ++$i, 1);
        }else{


            if(substr($str, $i, 1) === ' ' and $in_quote === false)
            {
                $arr_index++;
                continue;
            }
            elseif ($in_quote === false && substr($str, $i, 2) === '$\'')
            {
                // bash 的特殊引号，引号内转换成ANSI，双引号本地化暂未处理
                $i++;
                $to_ansi = true;
                $in_quote = !$in_quote;
                continue;
            }
            elseif (substr($str, $i, 1) === '\'')
            {
                if($in_quote === true && $to_ansi == true){
                    $to_ansi = ! $to_ansi;
                }
                $in_quote = ! $in_quote;
                continue;
            }else
            {
                $char = substr($str, $i, 1);
                if($to_ansi){
//                    $char = mb_convert_encoding($char, 'ANSI-C');
                }

                key_exists($arr_index, $arr) or $arr[$arr_index] = '';
                $arr[$arr_index] .= $char;
            }
        }
    }

    $result = [
        // ls
        'command' => [],
        // ls /usr
        'arguments' => [],
        // -user root
        'options' => [],
        // --help
        'switches' => [],
    ];

    for ($i = 0; $i < count($arr); $i++)
    {
        if (substr($arr[$i],0,2) === '--' or substr($arr[$i],0,1) === '-'){

            if(count($arr) === $i + 1 or substr($arr[$i + 1],0,2) === '--' or substr($arr[$i + 1],0,1) === '-')
            {
                // 最后一个，或者下一个值是option
                $result['options'][$arr[$i]] = true;
            }
            else
            {
                // 下一个成员作为选项值，下移数字指针
                if (key_exists($arr[$i], $result['options']))
                {
                    if (is_array($result['options'][$arr[$i]]))
                    {
                        $result['options'][$arr[$i]][] = $arr[++$i];
                    }else
                    {
                        $result['options'][$arr[$i]] = [$result['options'][$arr[$i]], $arr[++$i]];
                    }

                }else
                {
                    $result['options'][$arr[$i]] = $arr[++$i];
                }

            }
        }
        else
        {
            if($i === 0){
                $result['command'] = $arr[$i];
            }
            $result['arguments'][] = $arr[$i];
        }
    }

    return $result;
}


$str = <<<EHO
curl 'http://xcnice.com/mmc/?controller=mmcgame&action=play' -H 'Cookie: __nxquid=NR1aSgAAAABEKVYOr4jDTQ==12980010; __nxqsid=14745996600010; _sessionHandler=d9aefb0c368442cc21dbfb0818355cc88a560f1d; __utmt=1; u=shellus; isLogin=true; __utma=146161213.502313140.1474599984.1474599984.1474599984.1; __utmb=146161213.13.10.1474599984; __utmc=146161213; __utmz=146161213.1474599984.1.1.utmcsr=xingyunxing111.com|utmccn=(referral)|utmcmd=referral|utmcct=/; __utmv=146161213.|1=version=2.0=1; sound=on; modes=1' -H 'Origin: http://xcnice.com' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: zh-CN,zh;q=0.8' -H 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Accept: */*' -H 'Referer: http://xcnice.com/mmc/?nav=mmc&flaglot=xc_mmc' -H 'X-Requested-With: XMLHttpRequest' -H 'Connection: keep-alive' --data $'lotteryid=23&curmid=311700&poschoose=&flag=save&play_source=&lt_project_modes=1&lt_project%5B%5D=%7B\'type\'%3A\'dxds\'%2C\'methodid\'%3A1010708%2C\'codes\'%3A\'%E5%8F%8C%7C%E5%8D%95\'%2C\'menuid\'%3A311729%2C\'nums\'%3A1%2C\'omodel\'%3A1%2C\'times\'%3A1%2C\'money\'%3A2%2C\'mode\'%3A1%2C\'desc\'%3A\'%5B%E5%A4%A7%E5%B0%8F%E5%8D%95%E5%8F%8C_%E5%90%8E%E4%BA%8C%5D+%5B%E5%A4%A7%E5%B0%8F%E5%8D%95%E5%8F%8C_%E5%90%8E%E4%BA%8C%5D+%E5%8F%8C%2C%E5%8D%95\'%7D&lt_total_nums=1&lt_total_money=2&randomNum=1103&times=1' --compressed
EHO;
//
//$str =
//<<<EOF
//curl -H 'Host: localhost' -H 'Cookie: sp\' an;'
//EOF;



var_dump(parse_command_line($str));