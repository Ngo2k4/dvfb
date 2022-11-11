<?php
include 'curl.php';
include '../../_config.php';
$hour = date('H');
$min = date('i');
$result = mysqli_query($conn, 'SELECT `user_id`, `type`, `access_token`, `end`, `custom`, `botcmt`, `noi_dung`, `link_img`,`sticker` FROM vipreaction ORDER BY RAND()');
while ($vip = mysqli_fetch_assoc($result)) {
    if ($vip['end'] >= time()) { // neu con han
        if ($hour == 00 && $min < 10) {
            if (file_exists('log_id/' . $vip['user_id'] . '.txt')) {
                unlink('log_id/' . $vip['user_id'] . '.txt');
            } else {
                break;
            }
        } else {
            // $nums = range(5,$vip['limit_react']);
            // $num = $nums[array_rand($nums)];
            $check = json_decode(cURL('https://graph.fb.me/me?access_token=' . $vip['access_token'] . '&fields=id&method=get'), true);
            if (isset($check['id'])) { // neu token live
                $type = $vip['type'];
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
                            /* dfdsfdsfdsfdsfsdgssd */
                            
                            if($vip['botcmt'] == 'yes'){
                                $list_icon = array(
                                urldecode('%F3%BE%80%80'),
                                urldecode('%F3%BE%80%81'),
                                urldecode('%F3%BE%80%82'),
                                urldecode('%F3%BE%80%83'),
                                urldecode('%F3%BE%80%84'),
                                urldecode('%F3%BE%80%85'),
                                urldecode('%F3%BE%80%87'), 
                                urldecode('%F3%BE%80%B8'), 
                                urldecode('%F3%BE%80%BC'),
                                urldecode('%F3%BE%80%BD'),
                                urldecode('%F3%BE%80%BE'),
                                urldecode('%F3%BE%80%BF'),
                                urldecode('%F3%BE%81%80'),
                                urldecode('%F3%BE%81%81'),
                                urldecode('%F3%BE%81%82'),
                                urldecode('%F3%BE%81%83'),
                                urldecode('%F3%BE%81%85'),
                                urldecode('%F3%BE%81%86'),
                                urldecode('%F3%BE%81%87'),
                                urldecode('%F3%BE%81%88'),
                                urldecode('%F3%BE%81%89'), 
                                urldecode('%F3%BE%81%91'),
                                urldecode('%F3%BE%81%92'),
                                urldecode('%F3%BE%81%93'), 
                                urldecode('%F3%BE%86%90'),
                                urldecode('%F3%BE%86%91'),
                                urldecode('%F3%BE%86%92'),
                                urldecode('%F3%BE%86%93'),
                                urldecode('%F3%BE%86%94'),
                                urldecode('%F3%BE%86%96'),
                                urldecode('%F3%BE%86%9B'),
                                urldecode('%F3%BE%86%9C'),
                                urldecode('%F3%BE%86%9D'),
                                urldecode('%F3%BE%86%9E'),
                                urldecode('%F3%BE%86%A0'),
                                urldecode('%F3%BE%86%A1'),
                                urldecode('%F3%BE%86%A2'),
                                urldecode('%F3%BE%86%A4'),
                                urldecode('%F3%BE%86%A5'),
                                urldecode('%F3%BE%86%A6'),
                                urldecode('%F3%BE%86%A7'),
                                urldecode('%F3%BE%86%A8'),
                                urldecode('%F3%BE%86%A9'),
                                urldecode('%F3%BE%86%AA'),
                                urldecode('%F3%BE%86%AB'),
                                urldecode('%F3%BE%86%AE'),
                                urldecode('%F3%BE%86%AF'),
                                urldecode('%F3%BE%86%B0'),
                                urldecode('%F3%BE%86%B1'),
                                urldecode('%F3%BE%86%B2'),
                                urldecode('%F3%BE%86%B3'), 
                                urldecode('%F3%BE%86%B5'),
                                urldecode('%F3%BE%86%B6'),
                                urldecode('%F3%BE%86%B7'),
                                urldecode('%F3%BE%86%B8'),
                                urldecode('%F3%BE%86%BB'),
                                urldecode('%F3%BE%86%BC'),
                                urldecode('%F3%BE%86%BD'),
                                urldecode('%F3%BE%86%BE'),
                                urldecode('%F3%BE%86%BF'),
                                urldecode('%F3%BE%87%80')
                            );
                                $icon = $list_icon[array_rand($list_icon)];
                                $list_nd = explode("\n", $vip['noi_dung']);
                                $nd = $list_nd[array_rand($list_nd)];
                                $nd .= "\n\n".$icon;
                                if($vip['sticker'] == 'yes'){
                                    if($vip['link_img'] != 'empty'){
                                        $list_sticker = array('392309624199683','334188620117492','785424294962258', '575284979224213','465624336970446','396449313832508');
                                        $sticker= $list_sticker[array_rand($list_sticker)];
                                        $link = $vip['link_img'];
                                        $rand = rand(0,1);
                                        if($rand == 0){
                                            $api = 'https://graph.fb.me/'.$act['id'].'/comments?access_token='.$vip['access_token'].'&message='.urlencode($nd).'&attachment_id='.$sticker.'&method=post';
                                        }else{
                                             $api = 'https://graph.fb.me/'.$act['id'].'/comments?access_token='.$vip['access_token'].'&message='.urlencode($nd).'&attachment_url='.urlencode($link).'&method=post';
                                        }
                                    }else{
                                        $list_sticker = array('392309624199683','334188620117492','785424294962258', '575284979224213','465624336970446','396449313832508');
                                        $sticker= $list_sticker[array_rand($list_sticker)];
                                        $api = 'https://graph.fb.me/'.$act['id'].'/comments?access_token='.$vip['access_token'].'&message='.urlencode($nd).'&attachment_id='.$sticker.'&method=post';
                                    }
                                }else{
                                    if($vip['link_img'] != 'empty'){
                                        $link = $vip['link_img'];
                                        $api = 'https://graph.fb.me/'.$act['id'].'/comments?access_token='.$vip['access_token'].'&message='.urlencode($nd).'&attachment_url='.urlencode($link).'&method=post';
                                    }
                                }
                            }
                            cURL($api);
                        }
                    } else {
//                        if (strpos($listid, $act['id']) === false) {
//                            $reaction = json_decode(cURL('https://graph.facebook.com/' . $act['id'] . '/reactions?access_token=' . $vip['access_token'] . '&type=' . $type . '&method=post'), true);
//                            if ($reaction['success']) {
//                                fwrite($fp, $act['id'] . "\n"); // ghi id da bot vao file
//                            }
//                        }
                    }
                }
                fclose($fp);
                // }
            } else {
                if (file_exists('log_id/' . $vip['user_id'] . '.txt')) {
                    unlink('log_id/' . $vip['user_id'] . '.txt');
                }
                continue;
            }
        }
    }
}
?>