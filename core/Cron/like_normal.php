<?php
// like ko cảm xúc, chạy like full cx thì kocaafn cron file này
/* code by duysexy */
include '../../_config.php';
include 'curl.php';
$layvip = mysqli_query($conn, 'SELECT `user_id`, `max_like`, `end`, `likes` FROM vip ORDER BY RAND() LIMIT 40');
while ($vip = mysqli_fetch_assoc($layvip)) {
    if ($vip['end'] > time()) {
        $time = time();
        $feed = json_decode(cURL('https://graph.facebook.com/' . $vip['user_id'] . '/feed?limit=1&fields=id,likes&method=get&access_token=' . $tokenx . '&_=' . $time), true);
        //echo $feed['data'][0]['id'];
        $uid = explode('_', $feed['data'][0]['id'])[0];
        if (($uid == $vip['user_id']) && ($feed['data'][0]['likes']['count'] < $vip['max_like'])) {
            $laytoken = mysqli_query($conn, "SELECT access_token FROM autolike ORDER BY RAND() LIMIT {$vip['likes']}");
            while ($token = mysqli_fetch_assoc($laytoken)) {
                cURL('https://graph.fb.me/' . $feed['data'][0]['id'] . '/likes?access_token=' . $token['access_token'] . '&method=post&_=' . $time);
            }
        }
    }
}
?>