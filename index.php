<?php
ob_start();
session_start();
define('COPYRIGHT', 'DuySexy');
date_default_timezone_set('Asia/Ho_Chi_Minh');
include '_config.php';
include 'Mailer/PHPMailerAutoload.php';
include 'login/function/active.php';
$hour = date("G");
$duysexy = false;
if (isset($_SESSION['login']) && $_SESSION['login'] == 'ok') {
    $duysexy = true;
    $idctv = $_SESSION['id_ctv'];
    $rule = $_SESSION['rule'];
    $uname = $_SESSION['user_name'];
    $upass = $_SESSION['pass'];
    $ustatus = $_SESSION['status'];
    $get_info = '';
    if ($rule != 'freelancer') {
        $get_info = mysqli_query($conn, "SELECT name, email, bill, user_name,profile FROM member WHERE id_ctv = $idctv");
    } else {
        $get_info = mysqli_query($conn, "SELECT name, email, bill, user_name,profile FROM ctv WHERE id_ctvs = $idctv");
    }
    // save session information user
    $info_user = mysqli_fetch_assoc($get_info);
    $xname = $info_user['name'];
    $xemail = $info_user['email'];
    $xbill = $info_user['bill'];
    $xprofile = $info_user['profile'];
    // counting notify, history
    $get_his = '';
    $get_noti = '';
    $count_noti = '';
    if ($rule != 'admin') {
        $get_his = mysqli_query($conn, "SELECT COUNT(history.id) FROM history WHERE id_ctv=$idctv");
        $get_noti = mysqli_query($conn, "SELECT COUNT(noti.id) FROM noti WHERE id_ctv = $idctv AND status = 0");
    } else if ($rule == 'admin' && $idctv != 1) {
        $get_his = mysqli_query($conn, "SELECT COUNT(history.id) FROM history WHERE id_ctv != 1 AND id_ctv > 0");
        $get_noti = mysqli_query($conn, 'SELECT COUNT(noti.id) FROM noti WHERE id_ctv != 1 AND id_ctv > 0');
    } else if ($rule == 'admin' && $idctv == 1) {
        $get_his = mysqli_query($conn, "SELECT COUNT(history.id) FROM history");
        $get_noti = mysqli_query($conn, 'SELECT COUNT(noti.id) FROM noti');
    }
    include 'inc/counting.php';
}
?>
<html>
    <head>
        <!-- Meta Tag -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="theme-color" content="red" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <meta name="description" content="HEESYSTEM, là 1 hệ thống quản lí VIP Facebook Auto chuyên nghiệp nhất hiện nay với những tính năng VIP Like, VIP CMT, VIP Share mạnh mẽ, tối ưu, mọi thứ đều được tự động hóa hiệu quả cao." />
        <meta name="keywords" content="VIP Like, VIP CMT, VIP Reaction, Auto Like, Auto Sub, Auto CMT, Auto Share, HEESYSTEM" />
        <meta name="author" content="HEESYSTEM" />
        <meta name="copyright" content="HEESYSTEM" />
        <meta name="robots" content="index, follow" />
        <meta property="fb:app_id" content="350685531728" />
        <meta property="og:title" content="HEESYSTEM - VIP Auto Facebook System" />
        <meta property="og:url" content="https://tudongtuongtac.com" />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="HEESYSTEM là 1 hệ thống quản lí VIP Facebook Auto chuyên nghiệp nhất hiện nay với những tính năng mạnh mẽ và tối ưu hiệu quả cao." />
        <meta property="og:image" content="https://seedingtdm.com/src/banner.jpg" />
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:author" content="HEESYSTEM" />
        <meta property="og:image:alt" content="HEESYSTEM VIP System" />
        <!-- Title -->
        <title>HEESYSTEM - Hệ thống VIP LIKE, VIP CMT, VIP Share tốt nhất</title>
        <!-- CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css?_=<?= time(); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css?_=<?= time(); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css?_=<?= time(); ?>">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css?_=<?= time(); ?>">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css?_=<?= time(); ?>">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css?_=<?= time(); ?>">
        <link rel="stylesheet" href="data:text/css;base64,I0R1eVNleHlPdmVybGF5IHsNCiAgICAgICAgICAgICAgICBwb3NpdGlvbjogZml4ZWQ7DQogICAgICAgICAgICAgICAgbGVmdDogMHB4Ow0KICAgICAgICAgICAgICAgIHRvcDogMHB4Ow0KICAgICAgICAgICAgICAgIHdpZHRoOiAxMDAlOw0KICAgICAgICAgICAgICAgIGhlaWdodDogMTAwJTsNCiAgICAgICAgICAgICAgICB6LWluZGV4OiA5OTk5Ow0KICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6IHVybCgnc3JjL2xvYWRpbmcuZ2lmJykgNTAlIDUwJSBuby1yZXBlYXQgcmdiKDI0OSwyNDksMjQ5KTsNCiAgICAgICAgICAgICAgICBvcGFjaXR5OiAwLjY5Ow0KICAgICAgICAgICAgfQ0KICAgICAgICAgICAgQG1lZGlhIG9ubHkgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiA0ODBweCl7DQogICAgICAgICAgICAgICAgI0R1eVNleHlPdmVybGF5ew0KICAgICAgICAgICAgICAgICAgICBkaXNwbGF5Om5vbmU7DQogICAgICAgICAgICAgICAgfQ0KICAgICAgICAgICAgfQ0KICAgICAgICAgICAgYTpob3ZlcnsNCiAgICAgICAgICAgICAgICB0ZXh0LXRyYW5zZm9ybTp1cHBlcmNhc2U7DQogICAgICAgICAgICAgICAgYmFja2dyb3VuZC1pbWFnZTogdXJsKCdzcmMvdGltYmF5LmdpZicpOw0KICAgICAgICAgICAgfQ==" type="text/css">
        <link href="src/animate.css?_=<?= time(); ?>" rel="stylesheet" type="text/css" />
        <link href="src/duy98.css?_=<?= time(); ?>" rel="stylesheet" type="text/css" />
        <link href="src/profile.css?_=<?= time(); ?>" rel="stylesheet" type="text/css" />
        <!-- Shortcut Icon -->
        <link rel="shortcut icon" href="src/favicon.ico" type="image/x-icon" />
        <!-- JavaScript -->
        <script src="src/jCarouselLite/jquery-1.11.1.js"></script>
        <script src="bootstrap/js/bootstrap.min.js?_=<?= time(); ?>"></script>
        <script src="src/wow.js?_=<?= time(); ?>"></script>
        <script>new WOW().init();</script>
        <script src="inc/js/noti.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=350685531728";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
            function _likePage() {
                if (confirm('Mình kéo like fanpage ( like ngoại nhé ) rate 20đ/like max 10K. Ai mua inbox mình nhé!!') == true) {
                    window.location = 'http://fb.com/4';
                } else {
                    alert('ahihi');
                    return false;
                }
            }
    </script>
</head>
<body onload="collapseSidebarDuySexy()" class="hold-transition <?php
if ($hour >= 0 && $hour <= 5) {
    echo 'skin-purple-light';
} else if ($hour > 6 && $hour <= 15) {
    echo 'skin-yellow-light';
} else if ($hour > 9 && $hour <= 18) {
    echo 'skin-blue-light';
} else if ($hour > 12 && $hour <= 20) {
    echo 'skin-purple-light';
} else if ($hour > 16 && $hour <= 22) {
    echo 'skin-red-light';
} else if ($hour > 20 && $hour <= 26) {
    echo 'skin-green-light';
} else {
    echo 'skin-blue-light';
}
?> sidebar-mini">
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107412984-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments)
    }
    ;
    gtag('js', new Date());

    gtag('config', 'UA-107412984-1');
    </script>
    <div class="wrapper">
        <header class="main-header">
            <a href="trang-chu.html" class="logo">
                <span class="logo-mini animated tada infinite"><b>HEE</b></span>
                <span class="logo-lg animated flash infinite"><b>HEESYSTEM</b></span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <?php if ($duysexy == true) {
                        ?>

                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu animated flash infinite">
                                <a href="#xprofile" data-toggle="modal">
                                    <img src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : '4'; ?>/picture" class="user-image" alt="Avatar">

                                    <span class="hidden-xs"><?php echo isset($xname) ? $xname : ''; ?></span>
                                </a>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu animated tada">
                                <a href="#" onclick="alert('Đăng nhập đi rùi mới click vào đây na na na!!');" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : '4'; ?>/picture" class="user-image" alt="Avatar">

                                    <span class="hidden-xs">Chào, Khách!</span>
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </nav>
        </header>

        <!-- Sidebar Menu -->
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel wow flash" data-wow-duration="3s">
                    <div class="pull-left image">
                        <img src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : '4'; ?>/picture" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo isset($uname) ? $uname : 'Mark Zuckerberg'; ?>  <img src="src/verify.png" alt="verify" style="width:16px;height:16px" /></p>
                        <!-- Status -->
                        <a href="<?php echo (isset($rule) && $rule == 'admin' && $idctv == 1) ? 'notify.html' : ''; ?>"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <?php if ($duysexy == false) { ?>
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header wow fadeInLeft">MENU</li>
                        <li class="active wow flash" data-wow-duration="0.5s"><a href="//TienDucBlog.Com" target="_blank"><i class="fa fa-star"></i> <span style="color:red">TienDucBlog.Com</span></a></li>

                        <li><a href="https://www.facebook.com/DucHee.VN" target="_blank" class="wow flash"><i class="glyphicon glyphicon-tower"></i> <span>Tham gia Group</span></a></li>
                        <li class="active animated flash infinite" data-wow-duration="0.5s"><a href="javascript:void(0)" onclick="_likePage()"><i class="fa fa-star"></i> <span style="color:red">Mua Like Page</span></a></li>
                        <!--<li><a onclick="report();"><i class="glyphicon glyphicon-move"></i> <span>Hỗ trợ / Báo lỗi</span></a></li>-->
                        <li class="wow fadeInUp" data-wow-duration="1s"><a href="dang-nhap.html"><i class="fa fa-sign-in"></i> <span>Đăng nhập</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="1.5s"><a href="dang-ki.html"><i class="glyphicon glyphicon-new-window"></i> <span>Đăng kí</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="2s"><a href="quen-mat-khau.html"><i class="glyphicon glyphicon-lock"></i> <span>Quên mật khẩu?</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="2.5s"><a href="nap-tien.html"><i class="glyphicon glyphicon-shopping-cart"></i> <span>Thanh toán</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="3s"><a data-toggle="modal" href="#price"><i class="glyphicon glyphicon-usd" id="showModal"></i> <span>Bảng giá</span></a></li>
                        <!--<li class="wow fadeInUp" data-wow-duration="3.5s"><a href="danh-sach-dev.html"><i class="glyphicon glyphicon-list-alt"></i> <span>Quản trị viên / Đại lí</span></a></li>-->
                        <!--<li class="wow fadeInUp" data-wow-duration="4s"><a href="get-token.html"><i class="glyphicon glyphicon-retweet"></i> <span>Get Access Token</span></a></li>-->
                        <!--<li class="wow fadeInUp" data-wow-duration="4s"><a href="check-token.html"><i class="glyphicon glyphicon-transfer"></i> <span>Check Access Token</span></a></li>-->
                    </ul>
                    <?php
                } else {
                    if ($rule == 'freelancer' || $rule == 'member') {
                        ?>
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">MENU</li>
<li><a href="#"><i class="fa fa-spinner fa-spin"></i> <span>vòng quay may mắn</span></a></li>
                            <li><a href="nap-tien.html"><i class="glyphicon glyphicon-usd"></i> <span>Nạp tiền</span></a></li>
                            <li><a href="https://www.facebook.com/groups/DucHee.VN" target="_blank" class="wow flash"><i class="glyphicon glyphicon-tower"></i> <span>Tham gia Group</span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-thumbs-o-up"></i> <span>VIP Cảm Xúc</span>
                                    <span class="pull-right-container"><span class="label label-info"><?php echo $count_like; ?></span></span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class=""><a href="them-vip-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm VIP ID</a></li>
                                    <li><a href="vip-cam-xuc.html"><i class="fa fa-circle-o"></i> Quản Lí VIP ID</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-comments"></i> <span>VIP COMMENT</span>
                                    <span class="pull-right-container">
                                        <span class="label label-success"><?php echo $count_cmt; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-binh-luan.html"><i class="fa fa-circle-o"></i> Thêm VIP CMT</a></li>
                                    <li><a href="vip-binh-luan.html"><i class="fa fa-circle-o"></i> Quản Lí VIP CMT</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-heartbeat"></i> <span>VIP BOT Cảm Xúc</span>
                                    <span class="pull-right-container">
                                        <span class="label label-warning"><?php echo $count_reaction; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm VIP REACTION</a></li>
                                    <li><a href="vip-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Quản Lí VIP REACTION</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>VIP Share</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-chia-se.html"><i class="fa fa-circle-o"></i> Thêm VIP Share</a></li>
                                    <li><a href="vip-chia-se.html"><i class="fa fa-circle-o"></i> Quản Lí VIP Share</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-rss"></i> <span>VIP Sub</span>
                                    <span class="pull-right-container">
                                        <span class="label label-warning">+</span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="mua-sub.html"><i class="fa fa-circle-o"></i> Mua Sub</a></li>
                                    <li><a href="them-sub.html"><i class="fa fa-circle-o"></i> Thêm ID Sub</a></li>
                                    <li><a href="sub.html"><i class="fa fa-circle-o"></i> Danh sách ID Sub</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-bolt"></i> <span>VIP Buzz</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="treeview">
                                        <a href="#"><i class="fa fa-circle-o"></i> VIP Buzz Like
                                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="them-buzz-like.html"><i class="fa fa-circle-o"></i> Thêm Post ID</a></li>
                                            <li><a href="buzz-like.html"><i class="fa fa-circle-o"></i> Quản lí ID</a></li>
                                        </ul>
                                    </li>

                                    <li class="treeview">
                                        <a href="#"><i class="fa fa-circle-o"></i> VIP Buzz CMT
                                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="them-buzz-cmt.html"><i class="fa fa-circle-o"></i> Thêm Post ID</a></li>
                                            <li><a href="buzz-cmt.html"><i class="fa fa-circle-o"></i> Quản lí ID</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li><a href="vipid-sap-het-han.html"><i class="glyphicon glyphicon-off"></i> <span>VIP ID Sắp Hết Hạn</span><span class="pull-right-container"> <span class="label label-danger"><?php echo $count_expires; ?></span></span></a></li>
                            <li><a href="gift-code.html"><i class="glyphicon glyphicon-gift"></i> <span>GIFT CODE</span></a></li>
                            <li><a href="thong-bao.html"><i class="glyphicon glyphicon-bell"></i> <span>Thông báo mới</span><span class="pull-right-container"> <span class="label label-success"><?php echo $count_noti; ?></span></span></a></li>
                            <li><a href="lich-su.html"><i class="glyphicon glyphicon-retweet"></i> <span>Lịch sử hoạt động</span> <span class="pull-right-container"><span class="label label-warning"><?php echo $count_his; ?></span></span></a></li>
<li><a href="#"><i class="fa fa-spinner fa-spin"></i> <span>vòng quay may mắn</span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-wrench"></i> <span>Cá nhân </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="cap-nhat-thong-tin.html"><i class="fa fa-circle-o"></i> Cập nhật thông tin</a></li>
                                    <li><a href="doi-mat-khau.html"><i class="fa fa-circle-o"></i> Đổi mật khẩu</a></li>
                                    <li><a href="nap-tien.html"><i class="fa fa-circle-o"></i> Nạp tiền</a></li>
                                </ul>
                            </li>

                        </ul>

                    <?php } else if ($rule == 'agency') { ?>

                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">SÁCH MENU</li>
<li><a href="#"><i class="fa fa-spinner fa-spin"></i> <span>vòng quay may mắn</span></a></li>
                            <li><a href="nap-tien.html"><i class="glyphicon glyphicon-usd"></i> <span>Nạp tiền</span></a></li>
                            <li><a href="https://www.facebook.com/groups/DucHee.VN" target="_blank" class="wow flash"><i class="glyphicon glyphicon-tower"></i> <span>Tham gia Group</span></a></li>
                            
                            <li class="treeview">
                                <a href="#"><i class="fa fa-thumbs-o-up"></i> <span>VIP Cảm Xúc</span>
                                    <span class="pull-right-container">
                                        <span class="pull-right-container"><span class="label label-info"><?php echo $count_like; ?></span></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class=""><a href="them-vip-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm VIP ID</a></li>
                                    <li><a href="vip-cam-xuc.html"><i class="fa fa-circle-o"></i> Quản Lí VIP ID</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-comments"></i> <span>VIP COMMENT</span> 
                                    <span class="pull-right-container">
                                        <span class="label label-success"><?php echo $count_cmt; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-binh-luan.html"><i class="fa fa-circle-o"></i> Thêm VIP CMT</a></li>
                                    <li><a href="vip-binh-luan.html"><i class="fa fa-circle-o"></i> Quản Lí VIP CMT</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-heartbeat"></i> <span>VIP BOT Cảm Xúc</span>
                                    <span class="pull-right-container">
                                        <span class="label label-warning"><?php echo $count_reaction; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm VIP REACTION</a></li>
                                    <li><a href="vip-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Quản Lí VIP REACTION</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>VIP Share</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Share"><i class="fa fa-circle-o"></i> Thêm VIP Share</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Share"><i class="fa fa-circle-o"></i> Quản Lí VIP Share</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-bolt"></i> <span>VIP Buzz</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="treeview">
                                        <a href="#"><i class="fa fa-circle-o"></i> VIP Buzz Like
                                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="them-buzz-like.html"><i class="fa fa-circle-o"></i> Thêm Post ID</a></li>
                                            <li><a href="buzz-like.html"><i class="fa fa-circle-o"></i> Quản lí ID</a></li>
                                        </ul>
                                    </li>

                                    <li class="treeview">
                                        <a href="#"><i class="fa fa-circle-o"></i> VIP Buzz CMT
                                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="them-buzz-cmt.html"><i class="fa fa-circle-o"></i> Thêm Post ID</a></li>
                                            <li><a href="buzz-cmt.html"><i class="fa fa-circle-o"></i> Quản lí ID</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-rss"></i> <span>VIP Sub</span>
                                    <span class="pull-right-container">
                                        <span class="label label-warning">+</span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="mua-sub.html"><i class="fa fa-circle-o"></i> Mua Sub</a></li>
                                    <li><a href="them-sub.html"><i class="fa fa-circle-o"></i> Thêm ID Sub</a></li>
                                    <li><a href="sub.html"><i class="fa fa-circle-o"></i> Danh sách ID Sub</a></li>
                                </ul>
                            </li>
                            <li><a href="vipid-sap-het-han.html"><i class="glyphicon glyphicon-off"></i> <span>VIP ID Sắp Hết Hạn</span><span class="pull-right-container"> <span class="label label-danger"><?php echo $count_expires; ?></span></span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-user"></i> <span>Quản lí CTV </span>
                                    <span class="pull-right-container">
                                        <span class="label label-success"><?php echo $count_ctv; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-ctv.html"><i class="fa fa-circle-o"></i> Tạo tài khoản CTV</a></li>
                                    <li><a href="cong-tac-vien.html"><i class="fa fa-circle-o"></i> Danh sách CTV</a></li>
                                    <li><a href="chuyen-tien.html"><i class="fa fa-circle-o"></i> Chuyển tiền</a></li>
                                    <li><a href="ctv-vipid-cam-xuc.html"><i class="fa fa-circle-o"></i> Danh sách ID VIP Cảm Xúc</a></li> 
                                    <li><a href="ctv-vipid-binh-luan.html"><i class="fa fa-circle-o"></i> Danh sách ID VIP CMT</a></li> 
                                    <li><a href="ctv-vipid-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Danh sách ID VIP Reaction</a></li> 


                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-gift"></i> <span>Quản Lí GIFT CODE</span>
                                    <span class="pull-right-container">
                                        <span class="label label-info"><?php echo $count_gift; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-gift-code.html"><i class="fa fa-circle-o"></i> Thêm Gift Code</a></li>
                                    <li><a href="list-gift-code.html"><i class="fa fa-circle-o"></i> Quản Lí Gift Code</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-bell"></i> <span>Quản lí thông báo </span>
                                    <span class="pull-right-container">
                                        <span class="label label-danger"><?php echo $count_noti; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="gui-thong-bao.html"><i class="fa fa-circle-o"></i> Gửi thông báo</a></li>
                                    <li><a href="thong-bao.html"><i class="fa fa-circle-o"></i> Danh sách Thông báo</a></li>
                                </ul>
                            </li>
                            <li><a href="lich-su.html"><i class="glyphicon glyphicon-retweet"></i> <span>Lịch sử hoạt động</span>
                                    <span class="pull-right-container"><span class="label label-warning"><?php echo $count_his; ?>
                                        </span></span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-wrench"></i> <span>Cá nhân </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="cap-nhat-thong-tin.html"><i class="fa fa-circle-o"></i> Cập nhật thông tin</a></li>
                                    <li><a href="doi-mat-khau.html"><i class="fa fa-circle-o"></i> Đổi mật khẩu</a></li>
                                    <li><a href="nap-tien.html"><i class="fa fa-circle-o"></i> Nạp tiền</a></li>
                                </ul>
                            </li>

                        </ul>

                    <?php } else if ($rule == 'admin') { ?>
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">MENU</li>
<li><a href="#"><i class="fa fa-spinner fa-spin"></i> <span>vòng quay may mắn</span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-thumbs-o-up"></i> <span>VIP Cảm Xúc </span>
                                    <span class="pull-right-container">
                                        <span class="label label-info"><?php echo $count_like; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class=""><a href="them-vip-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm VIP ID</a></li>
                                    <li><a href="vip-cam-xuc.html"><i class="fa fa-circle-o"></i> Quản Lí VIP ID</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-comments"></i> <span>VIP COMMENT</span>
                                    <span class="pull-right-container">
                                        <span class="label label-success"><?php echo $count_cmt; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-binh-luan.html"><i class="fa fa-circle-o"></i> Thêm VIP CMT</a></li>
                                    <li><a href="vip-binh-luan.html"><i class="fa fa-circle-o"></i> Quản Lí VIP CMT</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-heartbeat"></i> <span>VIP BOT Cảm Xúc</span>
                                    <span class="pull-right-container">
                                        <span class="label label-warning"><?php echo $count_reaction; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-vip-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm VIP REACTION</a></li>
                                    <li><a href="vip-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Quản Lí VIP REACTION</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>VIP Share</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Share"><i class="fa fa-circle-o"></i> Thêm VIP Share</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Share"><i class="fa fa-circle-o"></i> Quản Lí VIP Share</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-bolt"></i> <span>VIP Buzz</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="treeview">
                                        <a href="#"><i class="fa fa-circle-o"></i> VIP Buzz Like
                                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="them-buzz-like.html"><i class="fa fa-circle-o"></i> Thêm Post ID</a></li>
                                            <li><a href="buzz-like.html"><i class="fa fa-circle-o"></i> Quản lí ID</a></li>
                                        </ul>
                                    </li>

                                    <li class="treeview">
                                        <a href="#"><i class="fa fa-circle-o"></i> VIP Buzz CMT
                                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="them-buzz-cmt.html"><i class="fa fa-circle-o"></i> Thêm Post ID</a></li>
                                            <li><a href="buzz-cmt.html"><i class="fa fa-circle-o"></i> Quản lí ID</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-rss"></i> <span>VIP Sub</span>
                                    <span class="pull-right-container">
                                        <span class="label label-warning">+</span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="mua-sub.html"><i class="fa fa-circle-o"></i> Mua Sub</a></li>
                                    <li><a href="them-sub.html"><i class="fa fa-circle-o"></i> Thêm ID Sub</a></li>
                                    <li><a href="sub.html"><i class="fa fa-circle-o"></i> Danh sách ID Sub</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-off"></i> <span>VIP ID Sắp Hết Hạn</span>
                                    <span class="pull-right-container">
                                        <span class="label label-danger"><?php echo $count_expires; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="vipid-sap-het-han.html"><i class="fa fa-circle-o"></i> Danh sách</a></li>
                                    <?php if ($idctv == 1) { ?>
                                        <li><a href="xoa-vipid-het-han.html"><i class="fa fa-circle-o"></i> Xóa VIP ID Hết Hạn</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-gift"></i> <span>Quản Lí GIFT CODE</span>
                                    <span class="pull-right-container">
                                        <span class="label label-success"><?php echo $count_gift; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-gift-code.html"><i class="fa fa-circle-o"></i> Thêm Gift Code</a></li>
                                    <li><a href="list-gift-code.html"><i class="fa fa-circle-o"></i> Quản Lí Gift Code</a></li>
                                </ul>
                            </li>


                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-bell"></i> <span>Quản lí thông báo</span>
                                    <span class="pull-right-container">
                                        <span class="label label-info"><?php echo $count_noti; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="gui-thong-bao.html"><i class="fa fa-circle-o"></i> Gửi thông báo</a></li>
                                    <li><a href="thong-bao.html"><i class="fa fa-circle-o"></i> Danh sách Thông báo</a></li>
                                </ul>
                            </li>
                            <li><a href="lich-su.html"><i class="glyphicon glyphicon-retweet"></i> <span>Quản lí Lịch sử </span> <span class="pull-right-container"><span class="label label-warning"><?php echo $count_his; ?></span></span></a></li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-list-alt"></i> <span>Quản lí Đại Lí</span>
                                    <span class="pull-right-container">
                                        <span class="label label-info"><?php echo $count_agency; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-dai-li.html"><i class="fa fa-circle-o"></i> Tạo tài khoản Đại Lí</a></li>
                                    <li><a href="dai-li.html"><i class="fa fa-circle-o"></i> <span>Danh sách Đại Lí</span></a></li>



                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-globe"></i> <span>Quản lí CTV </span>
                                    <span class="pull-right-container">
                                        <span class="label label-success"><?php echo $count_ctv; ?></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-ctv.html"><i class="fa fa-circle-o"></i> Tạo tài khoản CTV</a></li>
                                    <li><a href="cong-tac-vien.html"><i class="fa fa-circle-o"></i> <span>Danh sách CTV</span></a></li>
                                    <li><a href="ctv-vipid-cam-xuc.html"><i class="fa fa-circle-o"></i> Danh sách ID VIP Cảm Xúc</a></li> 
                                    <li><a href="ctv-vipid-binh-luan.html"><i class="fa fa-circle-o"></i> Danh sách ID VIP CMT</a></li> 
                                    <li><a href="ctv-vipid-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Danh sách ID VIP Reaction</a></li> 



                                </ul>
                            </li>

                            <li><a href="thanh-vien.html"><i class="glyphicon glyphicon-user"></i> <span>Quản lí Member</span> <span class="pull-right-container"><span class="label label-danger"><?php echo $count_member; ?></span></span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-random"></i> <span>Giao dịch </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if ($idctv == 1) { ?><li><a href="cong-tien.html"><i class="fa fa-circle-o"></i> Cộng tiền</a></li> <li><a href="cap-nhat-tien.html"><i class="fa fa-circle-o"></i> Cập nhật tiền</a></li><?php } ?>
                                    <?php if ($idctv == 1 || $idctv == 359) { ?><li><a href="chuyen-tien.html"><i class="fa fa-circle-o"></i> Chuyển tiền</a></li> <?php } ?>

                                </ul>
                            </li>


                            <?php if ($idctv == 1) { ?>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="glyphicon glyphicon-hdd"></i> <span>Quản lí package</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>

                                    <ul class="treeview-menu">

                                        <li class="treeview">
                                            <a href="#"><i class="fa fa-circle-o"></i>Package VIP Cảm Xúc
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="them-package-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm Package</a></li>
                                                <li><a href="package-cam-xuc.html"><i class="fa fa-circle-o"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>

                                        <li class="treeview">
                                            <a href="#"><i class="fa fa-circle-o"></i> Package VIP CMT
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="them-package-binh-luan.html"><i class="fa fa-circle-o"></i> Thêm Package</a></li>
                                                <li><a href="package-binh-luan.html"><i class="fa fa-circle-o"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>

                                        <li class="treeview">
                                            <a href="#"><i class="fa fa-circle-o"></i> Package VIP Share
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="them-package-chia-se.html"><i class="fa fa-circle-o"></i> Thêm Package</a></li>
                                                <li><a href="package-chia-se.html"><i class="fa fa-circle-o"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>

                                        <li class="treeview">
                                            <a href="#"><i class="fa fa-circle-o"></i> Package VIP Bot Reaction
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="them-package-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Thêm Package</a></li>
                                                <li><a href="package-bot-cam-xuc.html"><i class="fa fa-circle-o"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                            <?php } ?>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-wrench"></i> <span>Cá nhân </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="cap-nhat-thong-tin.html"><i class="fa fa-circle-o"></i> Cập nhật thông tin</a></li>
                                    <li><a href="doi-mat-khau.html"><i class="fa fa-circle-o"></i> Đổi mật khẩu</a></li>

                                </ul>
                            </li>
                            <?php if ($idctv == 1) { ?>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-wrench"></i> <span>Token Management</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="them-token.html"><i class="fa fa-circle-o"></i> Thêm token</a></li>
                                    <li><a href="xoa-token.html"><i class="fa fa-circle-o"></i> Xóa token die</a></li>

                                </ul>
                            </li>
                            <?php } ?>    
                        </ul>
                        <?php
                    }
                }
                ?>
            </section>
        </aside>

        <div class="content-wrapper" style="padding:5px">
           
            
            <?php
            if (isset($_REQUEST['DS'])) {
                $DuySexy = $_REQUEST['DS'];
                if ($duysexy == false) {
                    switch ($DuySexy) {
                        // Account Handle
                        case 'Login':
                            include 'login/index.php';
                            break;
                        case 'Register':
                            include 'login/register.php';
                            break;
                        case 'Confirm':
                            include 'login/confirm.php';
                            break;
                        case 'Recover':
                            include 'login/recover.php';
                            break;
                        case 'Charge_Money':
                            include 'person/billing.php';
                            break;
                        case 'Check_Token':
                            include 'core/Token/check.php';
                            break;
                        case 'Get_Token':
                            include 'person/get_token.php';
                            break;
                        case 'ResendEmail':
                            include 'login/resend.php';
                            break;
                        case 'NapThe':
                            include 'Card/transaction.php';
                            break;
                        case 'List':
                            include 'core/Admin/list.php';
                            break;
                        // login ctv
                        case 'Login_CTV':
                            include 'login/ctv.php';
                            break;
                        default:
                            echo "<script>alert('Hình như có cái gì sai sai ấy!!'); window.location='trang-chu.html';</script>";
                            break;
                    }
                } else {
                    switch ($DuySexy) {
                        // Account Handle
                        case 'Get_Token_Clone':
                            include 'core/Token/Clone/index.php';
                            break;
                        case 'Loc_Token':
                            include 'core/Token/loc.html';
                            break;
                        case 'Confirm':
                            echo "<script>alert('Vui lòng đăng xuất trước khi kích hoạt'); window.location='trang-chu.html';</script>";
                            break;
                        case 'ResendEmail':
                            echo "<script>alert('Vui lòng đăng xuất!!); window.location='trang-chu.html';</script>";
                            break;
                        case 'Charge_Money':
                            include 'person/billing.php';
                            break;
                        case 'Change_Pass':
                            include 'person/change_pass.php';
                            break;
                        case 'Get_Token':
                            include 'person/get_token.php';
                            break;
                        case 'Change_Info':
                            include 'person/change_info.php';
                            break;
                        case 'NapThe':
                            include 'Card/transaction.php';
                            break;
                        
                           //VIP Share
                            case 'Add_VIP_Share':
                                include 'core/VIP/Share/add.php';
                                break;
                            case 'Manager_VIP_Share':
                                include 'core/VIP/Share/list.php';
                                break;
                            case 'Extending_Share':
                                include 'core/VIP/Share/extend.php';
                                break;
                            case 'Update_Share':
                                include 'core/VIP/Share/update.php';
                                break;
                            case 'Delete_Share';
                                include 'core/VIP/Share/del.php';
                                break;
                        //VIP Buff
	                    case 'Add_Buzz_Like':
		                    include 'core/VIP/Buzz/Like/add.php';
		                    break;
	                    case 'Update_Buzz_Like';
		                    include 'core/VIP/Buzz/Like/update.php';
		                    break;
	                    case 'Delete_Buzz_Like':
		                    include 'core/VIP/Buzz/Like/del.php';
		                    break;
	                    case 'List_Buzz_Like';
		                    include 'core/VIP/Buzz/Like/list.php';
		                    break;

	                    // VIP Post CMT
	                    case 'Add_Buzz_CMT':
		                    include 'core/VIP/Buzz/CMT/add.php';
		                    break;
	                    case 'Update_Buzz_CMT';
		                    include 'core/VIP/Buzz/CMT/update.php';
		                    break;
	                    case 'Delete_Buzz_CMT':
		                    include 'core/VIP/Buzz/CMT/del.php';
		                    break;
	                    case 'List_Buzz_CMT';
		                    include 'core/VIP/Buzz/CMT/list.php';
		                    break;
                        //VIP LIKE
                        case 'Add_VIP_Like':
                            include 'core/VIP/LIKE/add.php';
                            break;
                        case 'Manager_VIP_Like':
                            include 'core/VIP/LIKE/list.php';
                            break;
                        case 'Extending_Like':
                            include 'core/VIP/LIKE/extend.php';
                            break;
                        case 'Update_Like':
                            include 'core/VIP/LIKE/update.php';
                            break;
                        case 'Delete_Like';
                            include 'core/VIP/LIKE/del.php';
                            break;


                        // VIP CMT
                        case 'Add_VIP_CMT':
                            include 'core/VIP/CMT/add.php';
                            break;
                        case 'Delete_CMT':
                            include 'core/VIP/CMT/del.php';
                            break;
                        case 'Update_CMT':
                            include 'core/VIP/CMT/update.php';
                            break;
                        case 'Manager_VIP_CMT':
                            include 'core/VIP/CMT/list.php';
                            break;
                        case 'Extending_CMT':
                            include 'core/VIP/CMT/extend.php';
                            break;

                        //VIP BOT Reaction

                        case 'Add_VIP_Reaction':
                            include 'core/VIP/Reaction/add.php';
                            break;
                        case 'Delete_Reaction':
                            include 'core/VIP/Reaction/del.php';
                            break;
                        case 'Update_Reaction':
                            include 'core/VIP/Reaction/update.php';
                            break;
                        case 'Manager_VIP_Reaction':
                            include 'core/VIP/Reaction/list.php';
                            break;
                        case 'Extending_Reaction':
                            include 'core/VIP/Reaction/extend.php';
                            break;
                        
                        //Event
                        case 'Event':
                            include 'Event/index.php';
                            break;

                        // VIP Sub
                        case 'Buy_Sub':
                            include 'core/VIP/Sub/buy.php';
                            break;
                        case 'Add_Sub':
                            include 'core/VIP/Sub/add.php';
                            break;
                        case 'Del_Sub':
                            include 'core/VIP/Sub/del.php';
                            break;
                        case 'List_Sub':
                            include 'core/VIP/Sub/list.php';
                            break;




                        // Expires
                        case 'Expires':
                            include 'core/VIP/Expires/list.php';
                            break;
                        case 'Del_Expires':
                            include 'core/VIP/Expires/del.php';
                            break;


                        // NOTIFICATION
                        case 'Notify':
                            include 'core/Noti/list.php';
                            break;
                        case 'Seen_Noti':
                            include 'core/Noti/seen.php';
                            break;
                        case 'Delete_Noti':
                            include 'core/Noti/del.php';
                            break;
                        case 'Send_Notify':
                            include 'core/Noti/send.php';
                            break;


                        //HISTORY
                        case 'History';
                            include 'core/History/list.php';
                            break;
                        case 'Delete_History';
                            include 'core/History/del.php';
                            break;

                        // Gift Code
                        case 'GiftCode':
                            include 'core/GiftCode/exec.php';
                            break;
                        case 'Add_GiftCode':
                            include 'core/GiftCode/add.php';
                            break;
                        case 'Manager_GiftCode':
                            include 'core/GiftCode/list.php';
                            break;
                        case 'Delete_GiftCode':
                            include 'core/GiftCode/del.php';
                            break;
                        case 'Edit_GiftCode':
                            include 'core/GiftCode/edit.php';
                            break;

                        // Tools
                        // Manger Member
                        case 'List_Member':
                            include 'core/Admin/Member/list.php';
                            break;
                        case 'Delete_Member':
                            include 'core/Admin/Member/del.php';
                            break;
                        case 'Update_Member':
                            include 'core/Admin/Member/edit.php';
                            break;

                        //Money Transaction
                        case 'Add_Money':
                            include 'core/Admin/Transaction/add.php';
                            break;
                        case 'Transfer_Money':
                            include 'core/Admin/Transaction/transfer.php';
                            break;
                        case 'Change_Money':
                            include 'core/Admin/Transaction/change.php';
                            break;


                        //manager package like
                        case 'Add_Package_Like':
                            include 'core/Package/LIKE/add.php';
                            break;
                        case 'List_Package_Like':
                            include 'core/Package/LIKE/list.php';
                            break;
                        case 'Update_Package_Like':
                            include 'core/Package/LIKE/edit.php';
                            break;
                        case 'Delete_Package_Like':
                            include 'core/Package/LIKE/del.php';
                            break;

                        //manager package CMT
                        case 'Add_Package_CMT':
                            include 'core/Package/CMT/add.php';
                            break;
                        case 'List_Package_CMT':
                            include 'core/Package/CMT/list.php';
                            break;
                        case 'Update_Package_CMT':
                            include 'core/Package/CMT/edit.php';
                            break;
                        case 'Delete_Package_CMT':
                            include 'core/Package/CMT/del.php';
                            break;

                        //manager package share
                        case 'Add_Package_Share':
                            include 'core/Package/Share/add.php';
                            break;
                        case 'List_Package_Share':
                            include 'core/Package/Share/list.php';
                            break;
                        case 'Update_Package_Share':
                            include 'core/Package/Share/edit.php';
                            break;
                        case 'Delete_Package_Share':
                            include 'core/Package/Share/del.php';
                            break;

                        //manager package reaction
                        case 'Add_Package_Reaction':
                            include 'core/Package/Reaction/add.php';
                            break;
                        case 'List_Package_Reaction':
                            include 'core/Package/Reaction/list.php';
                            break;
                        case 'Update_Package_Reaction':
                            include 'core/Package/Reaction/edit.php';
                            break;
                        case 'Delete_Package_Reaction':
                            include 'core/Package/Reaction/del.php';
                            break;

                        // token 
                        case 'Add_Token':
                            include 'core/Token/Add/index.php';
                            break;
                        case 'Del_Token':
                            include 'core/Token/Del/index.php';
                            break;
                        case 'Check_Token':
                            include 'core/Token/check.php';
                            break;
                        case 'Gets_Token':
                            include 'core/Token/Get/index.php';
                            break;


                        // list admin
                        case 'List':
                            include 'core/Admin/list.php';
                            break;

                        // CTV Management
                        case 'List_CTV':
                            include 'core/Admin/CTV/list.php';
                            break;
                        case 'Delete_CTV':
                            include 'core/Admin/CTV/del.php';
                            break;
                        case 'Update_CTV':
                            include 'core/Admin/CTV/update.php';
                            break;
                        case 'Add_CTV':
                            include 'core/Admin/CTV/add.php';
                            break;
                        case 'Edit_CTV':
                            include 'core/Admin/CTV/edit.php';
                            break;

                        // List VIP Like CTV
                        case 'CTV_Like':
                            include 'core/Admin/CTV/Like/list.php';
                            break;
                        case 'CTV_Delete_Like':
                            include 'core/Admin/CTV/Like/del.php';
                            break;
                        case 'CTV_Extending_Like':
                            include 'core/Admin/CTV/Like/extend.php';
                            break;
                        case 'CTV_Update_Like':
                            include 'core/Admin/CTV/Like/update.php';
                            break;

                        //List VIP CMT CTV
                        case 'CTV_Delete_CMT':
                            include 'core/Admin/CTV/CMT/del.php';
                            break;
                        case 'CTV_Extending_CMT':
                            include 'core/Admin/CTV/CMT/extend.php';
                            break;
                        case 'CTV_Update_CMT':
                            include 'core/Admin/CTV/CMT/update.php';
                            break;
                        case 'CTV_CMT':
                            include 'core/Admin/CTV/CMT/list.php';
                            break;

                        //List VIP Reaction CTV
                        case 'CTV_Delete_Reaction':
                            include 'core/Admin/CTV/Reaction/del.php';
                            break;
                        case 'CTV_Extending_Reaction':
                            include 'core/Admin/CTV/Reaction/extend.php';
                            break;
                        case 'CTV_Update_Reaction':
                            include 'core/Admin/CTV/Reaction/update.php';
                            break;
                        case 'CTV_Reaction':
                            include 'core/Admin/CTV/Reaction/list.php';
                            break;

                        case 'List_Agency':
                            include 'core/Admin/Dai_Li/list.php';
                            break;
                        case 'Delete_Agency':
                            include 'core/Admin/Dai_Li/del.php';
                            break;
                        case 'Update_Agency':
                            include 'core/Admin/Dai_Li/update.php';
                            break;
                        case 'Edit_Agency':
                            include 'core/Admin/Dai_Li/edit.php';
                            break;
                        case 'Add_Agency':
                            include 'core/Admin/Dai_Li/add.php';
                            break;

                        //Notification
                        case 'Update_Noti':
                            include 'core/Admin/Noti/update.php';
                            break;

                        default:
                            echo "<script>alert('Hình như có cái gì sai sai ấy!!'); window.location='trang-chu.html';</script>";
                            break;
                    }
                }
            } else {
                if ($duysexy == false) {
                    include 'dashboard.php';
                } else {
                    include 'person/dashboard.php';
                }
            }
            ?>
        </div>
        <footer class="main-footer" data-wow-duration="3s">
            <div class="pull-right hidden-xs">
                <!--<b>HEE TEAM</b> Co, Ltd. <a href="//#" target="_blank"> Auto Bot Like Facebook</a>-->
                <strong><code>HEESYSTEM V5.0</code> Developer by <a href="//fb.com/duysexyy" target="_blank"><code>HEESYSTEM</code></a></strong>
            </div>
            <strong>&copy; 2017-<?= date('Y'); ?> <code>HEESYSTEM</code> Powered By <a href="//fb.com/DucHee.VN" target="_blank"><code>HEE TEAM</code></a> <img src="src/sexyteam.jpg" alt="sexyteam" style="width:24px;height:24px" data-toggle="tooltip" title="HEE TEAM Legend (2015-<?= date('Y'); ?>)" />
        </footer>

        <div id="price" class="modal animated flash" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align:center">Bảng Giá HEESYSTEM</h4>
                    </div>
                    <div class="modal-body">
                        <?php include 'inc/bang_gia.php'; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="xprofile" class="modal animated fadeIn" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="card hovercard">
                            <div class="cardheader" style="background-image: url('src/banner_.jpg');background-size: 100% 100%;border-bottom: 1px solid #e1e8ed;border-radius: 4px 4px 0 0;"></div>
                            <div class="info" style="padding: 10px">
                                <div class="title" style="font-size: 20px;color:white">
                                    <div class="avatar">
                                        <img alt="" src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : ''; ?>/picture">
                                    </div>
                                    <?php echo isset($uname, $xname) ? $xname . '( @' . $uname . ' )' : ''; ?>
                                </div>
                                <button class="btn btn-default" data-toggle="tooltip" title="Đây là số dư hiện tại của bạn">Số dư: <span class="badge"><?php echo isset($xbill) ? number_format($xbill) . ' VNĐ' : ''; ?></button><br />
                                <a href="cap-nhat-thong-tin.html" data-toggle="tooltip" title="Cập nhật thông tin tài khoản" class="btn btn-info">Cập nhật thông tin</a>
                                <a href="doi-mat-khau.html" data-toggle="tooltip" title="Thay đổi mật khẩu tài khoản"  class="btn btn-danger">Đổi mật khẩu</a><br />
                                <a href="nap-tien.html" data-toggle="tooltip" title="Nạp tiền vào tài khoản"  class="btn btn-success">Nạp tiền</a> 
                                <a href="#" data-toggle="tooltip" title="Đăng xuất khỏi hệ thống" onclick="logout()" class="btn btn-warning">Đăng xuất</a><br />
                                <a target="_blank"  data-toggle="tooltip" title="Trang cá nhân Facebook"  class="btn btn-primary btn-sm" rel="publisher"
                                   href="http://Facebook.Com/<?php echo isset($xprofile) ? $xprofile : ''; ?>">
                                    <i class="fa fa-facebook"></i>/<?php echo isset($xprofile) ? $xprofile : ''; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
        <script src="dist/js/adminlte.js?_=<?= time(); ?>"></script>
        <script src="plugins/datatables/jquery.dataTables.min.js?_=<?= time(); ?>"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js?_=<?= time(); ?>"></script>
        <script src="plugins/ckeditor/ckeditor.js?_=<?= time(); ?>"></script>
        <script src="inc/js/ext.js"></script><noscript>Your browser does not support JavaScript!!!</noscript>
</body>
</html>
