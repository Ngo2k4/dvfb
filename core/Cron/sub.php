<?php
include '../../_config.php';
include 'curl.php';
$layvip = mysqli_query($conn, 'SELECT user_id, delay, subs, max_sub FROM vipsub ORDER BY RAND() LIMIT 5');
while ($vip = mysqli_fetch_assoc($layvip)){
    $i = 0;
    //$cur_sub = json_decode(cURL('https://graph.fb.me/'.$vip['user_id'].'/subscribers?access_token='.$tokenx.'&method=get'),true);
    if($vip['subs'] < $vip['max_sub']){
        $laytoken = mysqli_query($conn, 'SELECT access_token FROM autosub ORDER BY RAND() LIMIT '.$vip['delay']);
        while($token = mysqli_fetch_assoc($laytoken)){
            //$res = cURL('https://graph.fb.me/'.$vip['user_id'].'/subscribers?method=post&access_token='.$token['access_token']); // sub truc tiep
            $res = json_decode(cURL('https://graph.fb.me/me/friends?uid='.$vip['user_id'].'&method=post&access_token='.$token['access_token']),true); // sub qua add friend
            if($res == 'true'){
                $i++;
            }
        }
        mysqli_query($conn, "UPDATE vipsub SET subs = subs + $i WHERE user_id='{$vip['user_id']}'");
    }else{
    	mysqli_query($conn, "DELETE FROM vipsub WHERE user_id='{$vip['user_id']}'");
    }
}

