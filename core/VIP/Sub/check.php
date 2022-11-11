<?php
error_reporting(0);
include '../../../_config.php';
if($_POST['uid']){
    $uid = $_POST['uid'];
    $result = array();
    $check = json_decode(file_get_contents('https://graph.fb.me/'.$uid.'/subscribers?access_token='.$tokenx.'&method=get'),true);
    $name = json_decode(file_get_contents('https://graph.fb.me/'.$uid.'?access_token='.$tokenx.'&fields=name,id'),true);
    if($check['summary']['total_count'] && $name['name']){
        $sub = 'Số  người theo dõi hiện tại: <b>'.number_format($check['summary']['total_count']).'</b>';
        $name = $name['name'];
        $result['status'] = 'OK';
        $result['sub'] = $sub;
        $result['name'] = $name;
    }else{
        $result['status'] = 'Fail';
        $result['sub'] = '<b>Không lấy được số người theo dõi hiện tại của UID nàyy !!!!';
        $result['name'] = 'Không check được tên!!';
    }
    echo json_encode($result);
}
?>