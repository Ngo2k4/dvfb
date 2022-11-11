<?php
$notify = mysqli_fetch_assoc($get_noti);
    if (empty($notify['COUNT(noti.id)'])) {
        $count_noti = 0;
    } else {
        $count_noti = $notify['COUNT(noti.id)'];
    }
    $history = mysqli_fetch_assoc($get_his);
    $count_his = '';
    if (empty($history['COUNT(history.id)'])) {
        $count_his = 0;
    } else {
        $count_his = $history['COUNT(history.id)'];
    }
    //couting agency, freelancer
    $get_agency = 'SELECT 1+1';
    $get_ctv = '';
    if ($rule == 'admin') {
        $get_agency = mysqli_query($conn, "SELECT COUNT(*) as num_agencys FROM member WHERE rule = 'agency' AND status = 1");
        $get_ctv = mysqli_query($conn, "SELECT COUNT(*) as num_ctvs FROM ctv WHERE status = 1");
        $agencies = mysqli_fetch_assoc($get_agency);
        $ctvs = mysqli_fetch_assoc($get_ctv);
    } else if ($rule == 'agency') {
        $get_ctv = mysqli_query($conn, "SELECT COUNT(*) as num_ctvs FROM ctv WHERE status = 1 AND id_agency = $idctv");
        $ctvs = mysqli_fetch_assoc($get_ctv);
    }
    $count_agency = '';
    if (empty($agencies['num_agencys'])) {
        $count_agency = 0;
    } else {
        $count_agency = $agencies['num_agencys'];
    }
    $count_ctv = 0;
    if (empty($ctvs['num_ctvs'])) {
        $count_ctv = 0;
    } else {
        $count_ctv = $ctvs['num_ctvs'];
    }
    //counting expires vipid
    $count_expires = 0;
    $get_expires_like = '';
    $get_expires_cmt = '';
    $get_expires_reaction = '';
    $expires_time = time();
    if ($rule != 'admin') {
        $get_expires_like = mysqli_query($conn, "SELECT COUNT(*) FROM vip WHERE (end-$expires_time) <= 480000 AND id_ctv = $idctv");
        $get_expires_cmt = mysqli_query($conn, "SELECT COUNT(*) FROM vipcmt WHERE (end-$expires_time) <= 480000 AND id_ctv = $idctv");
        
        $get_expires_reaction = mysqli_query($conn, "SELECT COUNT(*) FROM vipreaction WHERE (end-$expires_time) <= 480000 AND id_ctv = $idctv");
        $count_expires_like = mysqli_fetch_assoc($get_expires_like)['COUNT(*)'];
        $count_expires_cmt = mysqli_fetch_assoc($get_expires_cmt)['COUNT(*)'];
   
        $count_expires_reaction = mysqli_fetch_assoc($get_expires_reaction)['COUNT(*)'];
        $count_expires = $count_expires_like + $count_expires_cmt + $count_expires_reaction;
    } else {
        $get_expires_like = mysqli_query($conn, "SELECT COUNT(*) FROM vip WHERE (end-$expires_time) <= 480000");
        $get_expires_cmt = mysqli_query($conn, "SELECT COUNT(*) FROM vipcmt WHERE (end-$expires_time) <= 480000");
        $get_expires_reaction = mysqli_query($conn, "SELECT COUNT(*) FROM vipreaction WHERE (end-$expires_time) <= 480000");
        $count_expires_like = mysqli_fetch_assoc($get_expires_like)['COUNT(*)'];
        $count_expires_cmt = mysqli_fetch_assoc($get_expires_cmt)['COUNT(*)'];
        $count_expires_reaction = mysqli_fetch_assoc($get_expires_reaction)['COUNT(*)'];
        $count_expires = $count_expires_like + $count_expires_cmt + $count_expires_reaction;
    }
    // counting member
    $count_member = 0;
    $get_member = '';
    if ($rule == 'admin') {
        $get_member = mysqli_query($conn, "SELECT COUNT(*) FROM member WHERE rule = 'member'");
        $count_member = mysqli_fetch_assoc($get_member)['COUNT(*)'];
    }
    //counting vip id
    $get_like = '';
    $get_cmt = '';
    $get_reaction = '';
    $count_like = 0;
    $count_cmt = 0;
    $count_reaction = 0;
    if ($rule != 'admin') {
        $get_like = mysqli_query($conn, "SELECT COUNT(*) FROM vip WHERE id_ctv = $idctv");
        $get_cmt = mysqli_query($conn, "SELECT COUNT(*) FROM vipcmt WHERE id_ctv = $idctv");
        $get_reaction = mysqli_query($conn, "SELECT COUNT(*) FROM vipreaction WHERE id_ctv = $idctv");
        $count_like = mysqli_fetch_assoc($get_like)['COUNT(*)'];
        $count_cmt = mysqli_fetch_assoc($get_cmt)['COUNT(*)'];
        $count_reaction = mysqli_fetch_assoc($get_reaction)['COUNT(*)'];
    } else {
        $get_like = mysqli_query($conn, "SELECT COUNT(*) FROM vip");
        $get_cmt = mysqli_query($conn, "SELECT COUNT(*) FROM vipcmt");
        $get_reaction = mysqli_query($conn, "SELECT COUNT(*) FROM vipreaction");
        $count_like = mysqli_fetch_assoc($get_like)['COUNT(*)'];
        $count_cmt = mysqli_fetch_assoc($get_cmt)['COUNT(*)'];
        $count_reaction = mysqli_fetch_assoc($get_reaction)['COUNT(*)'];
    }

    //counting gift code
    $count_gift = 0;
    $get_gift = '';
    if ($rule == 'admin') {
        $get_gift = mysqli_query($conn, "SELECT COUNT(*) FROM gift WHERE status = 0");
        $count_gift = mysqli_fetch_assoc($get_gift)['COUNT(*)'];
    } else if ($rule == 'agency') {
        $get_gift = mysqli_query($conn, "SELECT COUNT(*) FROM gift WHERE status = 0 AND id_ctv = $idctv");
        $count_gift = mysqli_fetch_assoc($get_gift)['COUNT(*)'];
    }
?>