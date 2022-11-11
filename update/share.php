<?php
/* code by duysexy */
    include '../../_config.php';
    include 'curl.php';
    $privacy = '{"value":"EVERYONE"}';
    $layvip = mysqli_query($conn, 'SELECT user_id, shares, max_share, end FROM vipshare ORDER BY RAND() LIMIT 5');
    while($vip = mysqli_fetch_assoc($layvip)){
        if($vip['end'] >= time()){
            $feed = json_decode(cURL('https://graph.fb.me/'.$vip['user_id'].'/feed?limit=1&method=get&fields=privacy,id,shares,created_time&access_token='.$tokenx),true);
            $time_post = strtotime($feed['data'][0]['created_time']);
            $delay = (time() - $time_post)/60;
            if($delay >= 5 && !isset($feed['data'][0]['shares'])){
                continue;
            }else{
                $uid = explode('_', $feed['data'][0]['id'])[0];
                if($uid == $vip['user_id'] && $feed['data'][0]['privacy']['value'] == 'EVERYONE' && $feed['data'][0]['shares']['count'] < $vip['max_share']){
                    $laytoken = mysqli_query($conn, "SELECT access_token FROM autoshare ORDER BY RAND() LIMIT {$vip['shares']}");
                    while($token = mysqli_fetch_assoc($laytoken)){
                         cURL('https://graph.fb.me/'.$feed['data'][0]['id'].'/sharedposts?access_token='.$token['access_token'].'&method=post&privacy='.$privacy);
                    }
                }
            }
        }
    }
?>