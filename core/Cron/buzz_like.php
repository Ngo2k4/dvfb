<?php
include '../../_config.php';
include 'curl.php';
$layvip = mysqli_query($conn, 'SELECT post_id, liked, max_like, type, likes FROM buzz_like ORDER BY RAND() LIMIT 5');
while ($vip = mysqli_fetch_assoc($layvip)){
	$i = 0;
	if($vip['liked'] < $vip['max_like']){
		$type = $vip['type'];
		if(strpos($vip['type'], "\n")){
			$list_type = explode("\n", $vip['type']);
			$type = $list_type[array_rand($list_type)];
		}
		$laytoken = mysqli_query($conn, 'SELECT access_token FROM autolike ORDER BY RAND() LIMIT '.$vip['likes']);
		while($token = mysqli_fetch_assoc($laytoken)){
			$res = json_decode(cURL('https://graph.fb.me/'.$vip['post_id'].'/reactions?method=post&access_token='.$token['access_token'].'&type='.$type),true);
			if($res['success']) $i++;
		}
		mysqli_query($conn, "UPDATE buzz_like SET liked = liked + $i WHERE post_id='{$vip['post_id']}'");
	}else{
		mysqli_query($conn, "DELETE FROM buzz_like WHERE post_id='{$vip['post_id']}'");
	}
}

