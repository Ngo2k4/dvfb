<?php
/* code by duysexy */
include '../../_config.php';
include 'curl.php';
$layvip = mysqli_query($conn, 'SELECT user_id, likes, max_like, end, type FROM vip ORDER BY RAND() LIMIT 20');
while ($vip = mysqli_fetch_assoc($layvip)) {
    if ($vip['end'] > time()) {
        $feed = json_decode(cURL('https://graph.fb.me/' . $vip['user_id'] . '/feed?limit=1&fields=id,story,privacy,message&method=get&access_token=' . $tokenx), true);
        if (isset($feed['data'][0]['id']) && $feed['data'][0]['privacy']['value'] == 'EVERYONE') {
            $uid = explode('_', $feed['data'][0]['id'])[0];
            if ($uid == $vip['user_id']) {
                $idpost = $feed['data'][0]['id'];
                if (strpos($feed['data'][0]['story'], 'profile picture.', 0) || strpos($feed['data'][0]['story'], 'cover photo.', 0)) {
                    $idpost = explode('_', $feed['data'][0]['id'])[1];
                }
                $count_react = json_decode(cURL('https://graph.fb.me/' . $feed['data'][0]['id'] . '/reactions?access_token=' . $tokenx . '&fields=id&method=get&summary=total_count'), true);
                if ($count_react['summary']['total_count'] < $vip['max_like']) {
                    $cx = $vip['type'];
                    if (strpos($vip['type'], "\n", 0)) {
                        $list_cx = explode("\n", $vip['type']);
                        $cx = $list_cx[array_rand($list_cx)];
                    }
                    $laytoken = mysqli_query($conn, 'SELECT access_token FROM autolike ORDER BY RAND() LIMIT ' . $vip['likes']);
                    while ($token = mysqli_fetch_assoc($laytoken)) {
                        cURL('https://graph.fb.me/' . $idpost . '/reactions?access_token=' . $token['access_token'] . '&type=' . $cx . '&method=post');
                        //if($count_react['summary']['total_count'] == $vip['max_like']) break;
                    }
                }
            }
        }
    }
}
?>