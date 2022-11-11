<?php

include '../../_config.php';
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $me = json_decode(file_get_contents('https://graph.fb.me/' . $user_id . '?access_token=' . $tokenx), true);
    if (isset($me['id'])) {
        echo $me['name'];
    } else {
        echo 'Default';
    }
}else if(isset($_POST['link'], $_POST['type'])){
    $type = $_POST['type'];
    $profile = $_POST['link'];
    if(strpos($profile, 'https', 0) === false){
        echo "<code>Link Facebook phải bắt đầu với giao thức <kbd>https://</kbd> và hỗ trợ các domain <kbd>m.facebook.com, mbasic.facebook.com, www.facebook.com</kbd></code>";
    }else{
        if($type == 'person'){
            if(strpos($profile, 'w', 0) == 8){
                $pattern = '#fb://profile/([0-9]+)#';
            }else if(strpos($profile, 'm', 0) == 8){
                $pattern = '#;id=([0-9]+)&amp;#';
            }
            $str = file_get_contents($profile);
            preg_match($pattern, $str, $matches);
            if($matches[1]){
                echo 'Thành công, VIP ID của bạn là: <kbd>'.$matches[1].'</kbd>';
            }else{
                echo '<code>Lỗi: Không thể lấy được ID, vui lòng kiểm tra lại địa chỉ Facebook!</code>';
            }
        }else if($type == 'page'){
            if(strpos($profile, 'w', 0) == 8){
                $pattern = '#fb://page/([0-9]+)#';
            }else if(strpos($profile, 'm', 0) == 8){
                $pattern = '#;id=([0-9]+)&amp;#';
            }
            $str = file_get_contents($profile);
            preg_match($pattern, $str, $matches);
            if($matches[1]){
                echo 'Thành công, VIP ID của bạn là: <kbd>'.$matches[1].'</kbd>';
            }else{
                echo '<code>Lỗi: Không thể lấy được ID, vui lòng kiểm tra lại địa chỉ Facebook!</code>';
            }
        }
    }
}