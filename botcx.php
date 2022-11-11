<?php
include '../../_config.php';
function getRandomUserAgent(){
    $userAgents = array(
'Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; SCH-I535 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
'Mozilla/5.0 (Linux; Android 7.0; SM-G930V Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.125 Mobile Safari/537.36',
'Mozilla/5.0 (Linux; Android 7.0; SM-A310F Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.91 Mobile Safari/537.36 OPR/42.7.2246.114996',
'Opera/9.80 (Android 4.1.2; Linux; Opera Mobi/ADR-1305251841) Presto/2.11.355 Version/12.10',
'Opera/9.80 (J2ME/MIDP; Opera Mini/5.1.21214/28.2725; U; ru) Presto/2.8.119 Version/11.10',
'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) OPiOS/10.2.0.93022 Mobile/11D257 Safari/9537.53',
'Mozilla/5.0 (Android 7.0; Mobile; rv:54.0) Gecko/54.0 Firefox/54.0',
'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_2 like Mac OS X) AppleWebKit/603.2.4 (KHTML, like Gecko) FxiOS/7.5b3349 Mobile/14F89 Safari/603.2.4',
'Mozilla/5.0 (Linux; U; Android 7.0; en-US; SM-G935F Build/NRD90M) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/11.3.8.976 U3/0.8.0 Mobile Safari/534.30',
'Mozilla/5.0 (Linux; Android 6.0.1; SM-G920V Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
'Mozilla/5.0 (Linux; Android 5.1.1; SM-N750K Build/LMY47X; ko-kr) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Puffin/6.0.8.15804AP',
'Mozilla/5.0 (Linux; Android 5.1.1; SM-N750K Build/LMY47X; ko-kr) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Puffin/6.0.8.15804AP',
'Mozilla/5.0 (Linux; Android 7.0; SAMSUNG SM-G955U Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/5.4 Chrome/51.0.2704.106 Mobile Safari/537.36',
'Mozilla/5.0 (Linux; Android 6.0; Lenovo K50a40 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.137 YaBrowser/17.4.1.352.00 Mobile Safari/537.36',
'Mozilla/5.0 (Linux; U; Android 7.0; en-us; MI 5 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.146 Mobile Safari/537.36 XiaoMi/MiuiBrowser/9.0.3',
'Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; Microsoft; Lumia 950)',
'Mozilla/5.0 (Windows Phone 10.0; Android 6.0.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Mobile Safari/537.36 Edge/15.14977',
'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.3.3.2205 Mobile Safari/537.35'
    );
    return $userAgents[array_rand($userAgents)];
}

function cURL($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);    
    curl_setopt($ch,CURLOPT_REFERER,$url);                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT,getRandomUserAgent());
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    return curl_exec($ch);
    curl_close($ch);
}
$hour = date('H');
$min = date('i');
$result = mysqli_query($conn, 'SELECT `user_id`, `type`, `access_token`, `end`, `custom`, `limit_react` FROM vipreaction ORDER BY RAND()');
while ($vip = mysqli_fetch_assoc($result)) {
    if ($vip['end'] >= time()) { // neu con han
        if($hour == 00 && $min < 10){
            if(file_exists('log_id/' . $vip['user_id'] . '.txt')){
                unlink('log_id/' . $vip['user_id'] . '.txt');
            }else{
                break;
            }
        }else{
            // $nums = range(5,$vip['limit_react']);
            // $num = $nums[array_rand($nums)];
            $check = json_decode(cURL('https://graph.fb.me/me?access_token=' . $vip['access_token'] . '&fields=id&method=get'), true);
            if (isset($check['id'])) { // neu token live
                $type = $vip['type'];
                if (strpos($vip['type'], "\n")) {
                    $list_type = explode("\n", $vip['type']);
                    $type = trim($list_type[array_rand($list_type)]);
                }
                // lay list stt
                $home = json_decode(cURL('https://graph.facebook.com/me/home?limit=2&fields=id,from&access_token=' . $vip['access_token'] . '&method=get'), true);
                // luu vao file loc trung
                $listid = file_get_contents('log_id/' . $vip['user_id'] . '.txt'); // lay danh sach id da bot
                $fp = fopen('log_id/' . $vip['user_id'] . '.txt', 'a+'); // mo file
                foreach ($home['data'] as $act) { // duyet new feed
                    if ($vip['custom'] == 0) { // neu chi bot stt ban be
                        if (!isset($act['from']['category']) && strpos($listid, $act['id']) === false) { // loc & check trung
                            $reaction = json_decode(cURL('https://graph.fb.me/' . $act['id'] . '/reactions?access_token=' . $vip['access_token'] . '&type=' . $type . '&method=post'), true); // tha cam xuc
                            if ($reaction['success']) {
                                fwrite($fp, $act['id'] . "\n"); // ghi id da bot vao file
                            }
                        }
                    } else {
                        if (strpos($listid, $act['id']) === false) {
                            $reaction = json_decode(cURL('https://graph.facebook.com/' . $act['id'] . '/reactions?access_token=' . $vip['access_token'] . '&type=' . $type . '&method=post'), true);
                            if ($reaction['success']) {
                                fwrite($fp, $act['id'] . "\n"); // ghi id da bot vao file
                            }
                        }
                    }
                }
                fclose($fp);
                // }
            } else {
                if(file_exists('log_id/' . $vip['user_id'] . '.txt')){
                    unlink('log_id/' . $vip['user_id'] . '.txt');
                }
                continue;
            }
        }
    }
}
?>
