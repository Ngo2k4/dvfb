<?php
/* code by duysexy */
include '../../_config.php';
include 'curl.php';
$result = mysqli_query($conn, 'SELECT user_id, cmts, max_cmt, noi_dung, gender, hash_tag, end FROM vipcmt ORDER BY RAND() LIMIT 20');
while ($vip = mysqli_fetch_assoc($result)) {
    if($vip['end'] > time()){
        $feed = json_decode(cURL('https://graph.facebook.com/' . $vip['user_id'] . '/feed?limit=1&fields=id,comments,message,privacy&access_token=' . $tokenx . '&method=get'), true);
        if (strpos($feed['data'][0]['message'], $vip['hash_tag'], 0) === false) {
            $uid = explode('_', $feed['data'][0]['id'])[0];
            $list_mess = array();
            $get = json_decode(cURL('https://graph.facebook.com/'.$feed['data'][0]['id'].'/comments?fields=message&method=get&limit='.$vip['max_cmt'].'&access_token='.$tokenx),true);
            foreach($get['data'] as $d){
                $list_mess[] = $d['message'];
            }
            //$count_cmt = count($feed['data'][0]['comments']['data']);
            if($feed['data'][0]['privacy']['value'] == 'EVERYONE' && $uid == $vip['user_id'] && $feed['data'][0]['comments']['count'] <= $vip['max_cmt']){
                if($vip['gender'] == 'both'){
                    $result1 = mysqli_query($conn, "SELECT access_token,gender FROM autocmt ORDER BY RAND() LIMIT {$vip['cmts']}");
                }else{
                    $result1 = mysqli_query($conn, "SELECT access_token,gender FROM autocmt WHERE gender = '{$vip['gender']}' ORDER BY RAND() LIMIT {$vip['cmts']}");
                }
                $listcmt = explode("\n", $vip['noi_dung']);
                while ($token = mysqli_fetch_assoc($result1)) {
                    $cmtt = $listcmt[array_rand($listcmt)];
                    if(!in_array(trim($cmtt), $list_mess)){
                        cURL('https://graph.facebook.com/' . $feed['data'][0]['id'] . '/comments?access_token=' . $token['access_token'] . '&message=' . urlencode($cmtt) . '&method=post');
                    }
                }
            }
        }
    }
}
?>