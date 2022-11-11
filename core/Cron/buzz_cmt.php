<?php
include '../../_config.php';
include 'curl.php';
$layvip = mysqli_query($conn, 'SELECT post_id, cmts, max_cmt, commented, noi_dung FROM buzz_cmt ORDER BY RAND()');
while($vip = mysqli_fetch_assoc($layvip)){
	$i = 0;
	if($vip['commented'] < $vip['max_cmt']){
		$nd = $vip['noi_dung'];
		if(strpos($vip['noi_dung'], "\n")){
			$list_nd = explode("\n", $vip['noi_dung']);
			$nd = $list_nd[array_rand($list_nd)];
		}
		$laytoken = mysqli_query($conn, 'SELECT access_token FROM autocmt ORDER BY RAND() LIMIT '.$vip['cmts']);
		while($token = mysqli_fetch_assoc($laytoken)){
			$res = json_decode(cURL('https://graph.fb.me/'.$vip['post_id'].'/comments?message='.urlencode($nd).'&method=post&access_token='.$token['access_token']),true);
			if($res['id']) $i++;
		}
		mysqli_query($conn, "UPDATE buzz_cmt SET commented = commented + $i WHERE post_id='{$vip['post_id']}'");
	}else{
		mysqli_query($conn, "DELETE FROM buzz_cmt WHERE post_id='{$vip['post_id']}'");
	}
}
?>