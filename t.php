<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/1
 * Time: 18:23
 */

$line = 'Cookie: visid_incap_632915=jxxAuMjkQemnzr163tpgNosszVcAAAAAQUIPAAAAAABO4lfn96qLp5L6M1FDkDs7; __utma=89240091.1530847008.1473064137.1473317688.1473405999.5; __utmz=89240091.1473064137.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=89240091.|1=version=2.0=1; __nxquid=D0uBDgAAAABMdTtUr4jDTQ==-2100010; isLogin=true; _sessionHandler=07434b2ea614c3f900daa9c0a33402fe66248e41; __utmt=1; u=shellus; pmode_selected_value=2; __utma=108618051.1200877059.1476340475.1477983864.1477992881.18; __utmb=108618051.6.10.1477992881; __utmc=108618051; __utmz=108618051.1476340475.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=108618051.|1=version=2.0=1; sound=on';

echo substr($line, strpos($line,': ') + 2);
