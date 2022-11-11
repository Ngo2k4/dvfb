<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include '_config.php';
include 'Mailer/PHPMailerAutoload.php';
include 'login/function/active.php';
if ($_SERVER['HTTP_HOST'] == 'vip.duysexy.online' || $_SERVER['HTTP_HOST'] == 'vipshare.ml') {
    header('Location: http://vip.bestauto.pro');
}
$hour = date("G");
$duysexy = false;
if ((isset($_SESSION['login']) && $_SESSION['login'] == 'ok') || (isset($_COOKIE['login']) && $_COOKIE['login'] == 'ok')) {
    $duysexy = true;
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'ok') {
        $idctv = $_SESSION['id_ctv'];
        $rule = $_SESSION['rule'];
        $uname = $_SESSION['user_name'];
        $upass = $_SESSION['pass'];
        $ustatus = $_SESSION['status'];
    } else if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'ok') {
        $idctv = $_COOKIE['id_ctv'];
        $rule = $_COOKIE['rule'];
        $uname = $_COOKIE['user_name'];
        $upass = $_COOKIE['pass'];
        $ustatus = $_COOKIE['status'];
    }
    if ($rule != 'freelancer') {
        $sql = "SELECT name, email, bill, user_name,profile FROM member WHERE id_ctv = $idctv";
    } else {
        $sql = "SELECT name, email, bill, user_name,profile FROM ctv WHERE id_ctvs = $idctv";
    }
    $kq = mysqli_query($conn, $sql);
    $n = mysqli_fetch_assoc($kq);
    $uname = $n['user_name'];
    $xname = $n['name'];
    $xemail = $n['email'];
    $xbill = $n['bill'];
    $xprofile = $n['profile'];
    $count_noti = '';
    if ($rule != 'admin') {
        $get_his = "SELECT COUNT(history.id) FROM history WHERE id_ctv=$idctv";
        $get_noti = "SELECT COUNT(noti.id) FROM noti WHERE id_ctv = $idctv AND status = 0";
    } else if ($rule == 'admin' && $idctv != 1) {
        $get_his = "SELECT COUNT(history.id) FROM history WHERE id_ctv != 1 AND id_ctv != -69";
        $get_noti = 'SELECT COUNT(noti.id) FROM noti WHERE id_ctv != 1';
    } else if ($rule == 'admin' && $idctv == 1) {
        $get_his = "SELECT COUNT(history.id) FROM history";
        $get_noti = 'SELECT COUNT(noti.id) FROM noti';
    }
    $notification = mysqli_query($conn, $get_noti);
    $notify = mysqli_fetch_assoc($notification);
    if (empty($notify['COUNT(noti.id)'])) {
        $count_noti = 0;
    } else {
        $count_noti = $notify['COUNT(noti.id)'];
    }
    $histories = mysqli_query($conn, $get_his);
    $history = mysqli_fetch_assoc($histories);
    $count_his = '';
    if (empty($history['COUNT(history.id)'])) {
        $count_his = 0;
    } else {
        $count_his = $history['COUNT(history.id)'];
    }
    if ($rule == 'admin') {
        $get_agency = "SELECT COUNT(*) as num_agencys FROM member WHERE rule = 'agency' AND status = 0";
        $get_ctv = "SELECT COUNT(*) as num_ctvs FROM ctv WHERE status = 0";
    } else if ($rule == 'agency') {
        $get_ctv = "SELECT COUNT(*) as num_ctvs FROM ctv WHERE status = 0 AND id_agency = $idctv";
    }
    $agencies = mysqli_fetch_assoc(mysqli_query($conn, $get_agency));
    $count_agency = '';
    if (empty($agencies['num_agencys'])) {
        $count_agency = 0;
    } else {
        $count_agency = $agencies['num_agencys'];
    }
    $ctvs = mysqli_fetch_assoc(mysqli_query($conn, $get_ctv));
    $count_ctv = '';
    if (empty($ctvs['num_ctvs'])) {
        $count_ctv = 0;
    } else {
        $count_ctv = $ctvs['num_ctvs'];
    }
}
?>
<!DOCTYPE html>
<!-- 
    Source Code: VIP Facebook Auto System v2.1.1 - (c) 2017 Code By DuySexy
-->
<html>
    <head>
        <!-- Meta Tag -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="theme-color" content="pink" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <meta name="description" content="Vip.BestAuto.Pro là 1 hệ thống quản lí VIP Facebook Auto chuyên nghiệp nhất hiện nay với những tính năng VIP Like, VIP CMT, VIP Share mạnh mẽ, tối ưu, mọi thứ đều được tự động hóa hiệu quả cao." />
        <meta name="keywords" content="VIP Like, VIP CMT, VIP Reaction, Auto Like, Auto Sub, Auto CMT, Auto Share, BestAuto.Pro, VIP.BestAuto.Pro" />
        <meta name="author" content="DuySexy" />
        <meta name="copyright" content="DuySexy" />
        <meta name="robots" content="index, follow" />
        <meta property="fb:app_id" content="1976783309235526" />
        <meta property="og:title" content="VIP.BestAuto.Pro - VIP Auto Facebook System" />
        <meta property="og:url" content="http://vip.bestauto.pro" />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="Vip.BestAuto.Pro là 1 hệ thống quản lí VIP Facebook Auto chuyên nghiệp nhất hiện nay với những tính năng mạnh mẽ và tối ưu hiệu quả cao." />
        <meta property="og:image" content="http://vip.bestauto.pro/src/banner.jpg" />
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:author" content="DuySexy" />
        <meta property="og:image:alt" content="BestAuto VIP System" />
        <!-- Title -->
        <title>VIP.BestAuto.Pro - Hệ thống VIP LIKE, VIP CMT, VIP REACTION, VIP SHARE giá rẻ, ổn định, chất lượng</title>
        <!-- CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/<?php
        if ($hour >= 0 && $hour <= 5) {
            echo 'skin-black-light.min.css';
        } else if ($hour > 5 && $hour <= 9) {
            echo 'skin-yellow-light.min.css';
        } else if ($hour > 9 && $hour <= 12) {
            echo 'skin-blue-light.min.css';
        } else if ($hour > 12 && $hour <= 16) {
            echo 'skin-purple-light.min.css';
        } else if ($hour > 6 && $hour <= 20) {
            echo 'skin-red-light.min.css';
        } else if ($hour > 20 && $hour <= 23) {
            echo 'skin-green-light.min.css';
        } else {
            echo 'skin-blue-light.min.css';
        }
        ?>">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <link href="src/animate.css" rel="stylesheet" type="text/css" />
        <link href="src/duy98.css" rel="stylesheet" type="text/css" />
        <link href="src/profile.css" rel="stylesheet" type="text/css" />
        <!-- Shortcut Icon -->
        <link rel="shortcut icon" href="src/favicon.ico" type="image/x-icon" />
        <!-- JavaScript -->
        <script src="plugins/jQuery/jquery-3.1.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="src/wow.js"></script>
        <script>new WOW().init();</script>
        <script>
            var _0x5446=["\x42\u1EA1\x6E\x20\x63\xF3\x20\x63\x68\u1EAF\x63\x20\x63\x68\u1EAF\x6E\x20\x6D\x75\u1ED1\x6E\x20\u0111\u0103\x6E\x67\x20\x78\x75\u1EA5\x74\x3F","\x6C\x6F\x63\x61\x74\x69\x6F\x6E","\x6C\x6F\x67\x6F\x75\x74\x2E\x70\x68\x70","\x41\x68\x69\x69\x68\x69\x69"];function logout(){if(confirm(_0x5446[0])== true){window[_0x5446[1]]= _0x5446[2]}else {alert(_0x5446[3])}}
        </script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=1976783309235526";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</head>
<body onload="collapseSidebarDuySexy()" class="hold-transition <?php
if ($hour >= 0 && $hour <= 5) {
    echo 'skin-black-light';
} else if ($hour > 6 && $hour <= 9) {
    echo 'skin-yellow-light';
} else if ($hour > 9 && $hour <= 12) {
    echo 'skin-blue-light';
} else if ($hour > 12 && $hour <= 16) {
    echo 'skin-purple-light';
} else if ($hour > 16 && $hour <= 20) {
    echo 'skin-red-light';
} else if ($hour > 20 && $hour <= 23) {
    echo 'skin-green-light';
} else {
    echo 'skin-blue-light';
}
?> sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="index.php" class="logo">
                <span class="logo-mini animated bounceInDown"><b>DS</b></span>
                <span class="logo-lg animated bounceInDown"><b>VIP</b>.BestAuto.Pro</span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <?php if ($duysexy == true) {
                        ?>

                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu wow bounceInDown">
                                <a href="#xxprofile" data-toggle="modal">
                                    <img src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : '4'; ?>/picture" class="user-image" alt="Avatar">

                                    <span class="hidden-xs"><?php echo isset($xname) ? $xname : ''; ?></span>
                                </a>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu wow bounceInDown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : '4'; ?>/picture" class="user-image" alt="Avatar">

                                    <span class="hidden-xs">Chào, Khách!</span>
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </nav>
        </header>


        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel wow flash" data-wow-duration="3s">
                    <div class="pull-left image">
                        <img src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : '4'; ?>/picture" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo isset($uname) ? $uname : 'Mark Zuckerberg'; ?>  <img src="src/verify.png" alt="verify" style="width:16px;height:16px" /></p>
                        <!-- Status -->
                        <a href="<?php echo (isset($rule) && $rule == 'admin') ? 'index.php?DS=Update_Noti' : ''; ?>"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <?php if ($duysexy == false) { ?>
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header wow fadeInLeft">DANH SÁCH MENU</li>
                        <li class="active wow fadeInUp" data-wow-duration="0.5s"><a href="//bestauto.pro" target="_blank"><i class="fa fa-star"></i> <span>BestAuto.Pro</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="1s"><a href="index.php?DS=Login"><i class="fa fa-sign-in"></i> <span>Đăng nhập</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="1.5s"><a href="index.php?DS=Register"><i class="glyphicon glyphicon-new-window"></i> <span>Đăng kí</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="2s"><a href="index.php?DS=Recover"><i class="glyphicon glyphicon-lock"></i> <span>Quên mật khẩu?</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="2.5s"><a href="index.php?DS=Charge_Money"><i class="glyphicon glyphicon-shopping-cart"></i> <span>Thanh toán</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="3s"><a data-toggle="modal" href="#price"><i class="glyphicon glyphicon-usd" id="showModal"></i> <span>Bảng giá</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="3.5s"><a href="index.php?DS=List"><i class="glyphicon glyphicon-list-alt"></i> <span>Quản trị viên / Đại lí</span></a></li>
                        <li class="wow fadeInUp" data-wow-duration="4s"><a href="index.php?DS=Get_Token"><i class="glyphicon glyphicon-transfer"></i> <span>Get Access Token</span></a></li>
                    </ul>
                    <?php
                } else {
                    if ($rule == 'freelancer' || $rule == 'member') {
                        ?>
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">DANH SÁCH MENU</li>
                            <li><a href="index.php?DS=Charge_Money"><i class="glyphicon glyphicon-usd"></i> <span>Nạp tiền</span></a></li>
                            <li>
                                <a href="index.php?DS=Trung_Thu_2017"><i class="glyphicon glyphicon-star-empty"></i> <span>Event Trung Thu 2017</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> <span>VIP LIKE</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class=""><a href="index.php?DS=Add_VIP_Like"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP ID</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Like"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP ID</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-comment"></i> <span>VIP COMMENT</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_CMT"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP CMT</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_CMT"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP CMT</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>VIP Share</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Share"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP Share</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Share"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP Share</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-heart"></i> <span>VIP BOT REACTION</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP REACTION</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP REACTION</a></li>
                                </ul>
                            </li>

                            <li><a href="index.php?DS=GiftCode"><i class="glyphicon glyphicon-gift"></i> <span>GIFT CODE</span></a></li>
                            <li><a href="index.php?DS=Notify"><i class="glyphicon glyphicon-bell"></i> <span>Thông báo mới <span class="badge"><?php echo $count_noti; ?></span></a></li>
                            <li><a href="index.php?DS=History"><i class="glyphicon glyphicon-retweet"></i> <span>Lịch sử hoạt động <span class="badge"><?php echo $count_his; ?></span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-wrench"></i> <span>Cá nhân </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Change_Info"><i class="glyphicon glyphicon-asterisk"></i> Cập nhật thông tin</a></li>
                                    <li><a href="index.php?DS=Change_Pass"><i class="glyphicon glyphicon-asterisk"></i> Đổi mật khẩu</a></li>
                                    <li><a href="index.php?DS=Charge_Money"><i class="glyphicon glyphicon-asterisk"></i> Nạp tiền</a></li>
                                </ul>
                            </li>

                        </ul>

                    <?php } else if ($rule == 'agency') { ?>

                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">DANH SÁCH MENU</li>
                            <li><a href="index.php?DS=Charge_Money"><i class="glyphicon glyphicon-usd"></i> <span>Nạp tiền</span></a></li>
                            <li>
                                <a href="index.php?DS=Trung_Thu_2017"><i class="glyphicon glyphicon-star-empty"></i> <span>Event Trung Thu 2017</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> <span>VIP LIKE</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class=""><a href="index.php?DS=Add_VIP_Like"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP ID</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Like"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP ID</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-comment"></i> <span>VIP COMMENT</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_CMT"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP CMT</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_CMT"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP CMT</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>VIP Share</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Share"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP Share</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Share"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP Share</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-heart"></i> <span>VIP BOT REACTION</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP REACTION</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP REACTION</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-user"></i> <span>Quản lí CTV </span><span class="badge"><?php echo $count_ctv; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_CTV"><i class="glyphicon glyphicon-asterisk"></i> Tạo tài khoản CTV</a></li>
                                    <li><a href="index.php?DS=List_CTV"><i class="glyphicon glyphicon-asterisk"></i> Danh sách CTV</a></li>
                                    <li><a href="index.php?DS=Transfer_Money"><i class="glyphicon glyphicon-asterisk"></i> Chuyển tiền</a></li>
                                    <li><a href="index.php?DS=CTV_Like"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP LIKE</a></li> 
                                    <li><a href="index.php?DS=CTV_CMT"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP CMT</a></li> 
                                    <li><a href="index.php?DS=CTV_Share"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP Share</a></li> 
                                    <li><a href="index.php?DS=CTV_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP Reaction</a></li> 


                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-gift"></i> <span>Quản Lí GIFT CODE</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_GiftCode"><i class="glyphicon glyphicon-asterisk"></i> Thêm Gift Code</a></li>
                                    <li><a href="index.php?DS=Manager_GiftCode"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí Gift Code</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-bell"></i> <span>Quản lí thông báo </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Send_Notify"><i class="glyphicon glyphicon-asterisk"></i> Gửi thông báo</a></li>
                                    <li><a href="index.php?DS=Notify"><i class="glyphicon glyphicon-asterisk"></i> Danh sách Thông báo <span class="badge"><?php echo $count_noti; ?></span></a></li>
                                </ul>
                            </li>
                            <li><a href="index.php?DS=History"><i class="glyphicon glyphicon-retweet"></i> <span>Lịch sử hoạt động <span class="badge"><?php echo $count_his; ?></span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-wrench"></i> <span>Cá nhân </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Change_Info"><i class="glyphicon glyphicon-asterisk"></i> Cập nhật thông tin</a></li>
                                    <li><a href="index.php?DS=Change_Pass"><i class="glyphicon glyphicon-asterisk"></i> Đổi mật khẩu</a></li>
                                    <li><a href="index.php?DS=Charge_Money"><i class="glyphicon glyphicon-asterisk"></i> Nạp tiền</a></li>
                                </ul>
                            </li>

                        </ul>

                    <?php } else if ($rule == 'admin') { ?>
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">DANH SÁCH MENU</li>
                            <li>
                                <a href="index.php?DS=Trung_Thu_2017"><i class="glyphicon glyphicon-star-empty"></i> <span>Event Trung Thu 2017</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> <span>VIP LIKE</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class=""><a href="index.php?DS=Add_VIP_Like"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP ID</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Like"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP ID</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-comment"></i> <span>VIP COMMENT</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_CMT"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP CMT</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_CMT"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP CMT</a></li>
                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>VIP Share</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Share"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP Share</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Share"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP Share</a></li>
                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-heart"></i> <span>VIP BOT REACTION</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_VIP_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Thêm VIP REACTION</a></li>
                                    <li><a href="index.php?DS=Manager_VIP_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí VIP REACTION</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-gift"></i> <span>Quản Lí GIFT CODE</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_GiftCode"><i class="glyphicon glyphicon-asterisk"></i> Thêm Gift Code</a></li>
                                    <li><a href="index.php?DS=Manager_GiftCode"><i class="glyphicon glyphicon-asterisk"></i> Quản Lí Gift Code</a></li>
                                </ul>
                            </li>


                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-bell"></i> <span>Quản lí thông báo <span class="badge"><?php echo $count_noti; ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Send_Notify"><i class="glyphicon glyphicon-asterisk"></i> Gửi thông báo</a></li>
                                    <li><a href="index.php?DS=Notify"><i class="glyphicon glyphicon-asterisk"></i> Danh sách Thông báo</a></li>
                                </ul>
                            </li>
                            <li><a href="index.php?DS=History"><i class="glyphicon glyphicon-retweet"></i> <span>Quản lí Lịch sử <span class="badge"><?php echo $count_his; ?></span></a></li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-list-alt"></i> <span>Quản lí Đại Lí  </span><span class="badge"><?php echo $count_agency; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_Agency"><i class="glyphicon glyphicon-asterisk"></i> Tạo tài khoản Đại Lí</a></li>
                                    <li><a href="index.php?DS=List_Agency"><i class="glyphicon glyphicon-asterisk"></i> <span>Danh sách Đại Lí</span></a></li>



                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-globe"></i> <span>Quản lí CTV </span> <span class="badge"><?php echo $count_ctv; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Add_CTV"><i class="glyphicon glyphicon-asterisk"></i> Tạo tài khoản CTV</a></li>
                                    <li><a href="index.php?DS=List_CTV"><i class="glyphicon glyphicon-asterisk"></i> <span>Danh sách CTV</span></a></li>
                                    <li><a href="index.php?DS=CTV_Like"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP LIKE</a></li> 
                                    <li><a href="index.php?DS=CTV_CMT"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP CMT</a></li> 
                                    <li><a href="index.php?DS=CTV_Share"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP Share</a></li> 
                                    <li><a href="index.php?DS=CTV_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Danh sách ID VIP Reaction</a></li> 



                                </ul>
                            </li>

                            <li><a href="index.php?DS=List_Member"><i class="glyphicon glyphicon-user"></i> <span>Quản lí Member</span></a></li>
                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-random"></i> <span>Giao dịch </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if ($idctv == 1) { ?><li><a href="index.php?DS=Add_Money"><i class="glyphicon glyphicon-asterisk"></i> Cộng tiền</a></li> <li><a href="index.php?DS=Change_Money"><i class="glyphicon glyphicon-asterisk"></i> Cập nhật tiền</a></li><?php } ?>
                                    <li><a href="index.php?DS=Transfer_Money"><i class="glyphicon glyphicon-asterisk"></i> Chuyển tiền</a></li>

                                </ul>
                            </li>


                            <?php if ($idctv == 1) { ?>
                                <li class="treeview">
                                    <a href="#" id="package"><i class="glyphicon glyphicon-hdd"></i> <span>Quản lí Package  </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>

                                    <ul class="treeview-menu pack">
                                        <li class="treeview">
                                            <a href="#"><i class="glyphicon glyphicon-hand-up"></i> <span>Package VIP Like </span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="index.php?DS=Add_Package_Like"><i class="glyphicon glyphicon-asterisk"></i> Thêm Package</a></li>
                                                <li><a href="index.php?DS=List_Package_Like"><i class="glyphicon glyphicon-asterisk"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>
                                    </ul>

                                    <ul class="treeview-menu pack">
                                        <li class="treeview">
                                            <a href="#"><i class="glyphicon glyphicon-comment"></i> <span>Package VIP CMT </span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="index.php?DS=Add_Package_CMT"><i class="glyphicon glyphicon-asterisk"></i> Thêm Package</a></li>
                                                <li><a href="index.php?DS=List_Package_CMT"><i class="glyphicon glyphicon-asterisk"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <ul class="treeview-menu pack">
                                        <li class="treeview">
                                            <a href="#"><i class="glyphicon glyphicon-share-alt"></i> <span>Package VIP Share </span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="index.php?DS=Add_Package_Share"><i class="glyphicon glyphicon-asterisk"></i> Thêm Package</a></li>
                                                <li><a href="index.php?DS=List_Package_Share"><i class="glyphicon glyphicon-asterisk"></i> Danh sách Package</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <ul class="treeview-menu pack">
                                        <li class="treeview">
                                            <a href="#"><i class="glyphicon glyphicon-heart-empty"></i> <span>Package VIP Reaction  </span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="index.php?DS=Add_Package_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Thêm Package</a></li>
                                                <li><a href="index.php?DS=List_Package_Reaction"><i class="glyphicon glyphicon-asterisk"></i> Danh sách Package</a></li>
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
                                    <li><a href="index.php?DS=Change_Info"><i class="glyphicon glyphicon-asterisk"></i> Cập nhật thông tin</a></li>
                                    <li><a href="index.php?DS=Change_Pass"><i class="glyphicon glyphicon-asterisk"></i> Đổi mật khẩu</a></li>

                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#"><i class="glyphicon glyphicon-record"></i> <span>Token Management </span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?DS=Check_Token"><i class="glyphicon glyphicon-asterisk"></i> Check Access Token</a></li>

                                    <li><a href="index.php?DS=Get_Token"><i class="glyphicon glyphicon-asterisk"></i> Get Access Token</a></li>
                                    <li><a href="index.php?DS=Add_Token"><i class="glyphicon glyphicon-asterisk"></i> Add Access Token To Data</a></li>
                                    <?php if ($idctv == 1) { ?> <li><a href="index.php?DS=Del_Token"><i class="glyphicon glyphicon-asterisk"></i> Xóa Access Token Die</a></li> <?php } ?>
                                </ul>
                            </li>

                            <?php if ($idctv == 1) {
                                ?>
                                <li class="treeview">
                                    <a href="#"><i class="glyphicon glyphicon-flash"></i> <span>BUFF MAX TOKEN </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">

                                        <li><a href="index.php?DS=BUFF_LIKE"><i class="glyphicon glyphicon-asterisk"></i> BUFF LIKE</a></li>
                                        <li><a href="index.php?DS=BUFF_CMT"><i class="glyphicon glyphicon-asterisk"></i> BUFF CMT</a></li><li><a href="index.php?DS=BUFF_FRIEND"><i class="glyphicon glyphicon-asterisk"></i> BUFF Friend Request</a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#"><i class="glyphicon glyphicon-flash"></i> <span>Sự kiện </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">

                                        <li><a href="index.php?DS=Trung_Thu_2017"><i class="glyphicon glyphicon-asterisk"></i> Trung Thu</a></li>
                                        <li><a href="index.php?DS=Event_Add_Card"><i class="glyphicon glyphicon-asterisk"></i> Add Card</a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- <li><a href="index.php?DS=Statics"><i class="glyphicon glyphicon-calendar"></i> <span>Thống kê doanh thu</span></a></li> -->
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
                            case 'Trung_Thu_2017':
                            include 'Event/trungthu.php';
                            break;
                        default:
                            echo "<script>alert('Hình như có cái gì sai sai ấy!!'); window.location='index.php';</script>";
                            break;
                    }
                } else {
                    switch ($DuySexy) {
                        // Account Handle
                        case 'Confirm':
                            echo "<script>alert('Vui lòng đăng xuất trước khi kích hoạt'); window.location='index.php';</script>";
                            break;
                        case 'ResendEmail':
                            echo "<script>alert('Vui lòng đăng xuất!!); window.location='index.php';</script>";
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

                        case 'Add_VIP_Like1':
                            include 'core/VIP/LIKE1/add.php';
                            break;
                        case 'Manager_VIP_Like1':
                            include 'core/VIP/LIKE1/list.php';
                            break;
                        case 'Extending_Like1':
                            include 'core/VIP/LIKE1/extend.php';
                            break;
                        case 'Update_Like1':
                            include 'core/VIP/LIKE1/update.php';
                            break;
                        case 'Delete_Like1';
                            include 'core/VIP/LIKE1/del.php';
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

                        //VIP Reaction

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

                        //VIP Share

                        case 'Add_VIP_Share':
                            include 'core/VIP/Share/add.php';
                            break;
                        case 'Delete_Share':
                            include 'core/VIP/Share/del.php';
                            break;
                        case 'Update_Share':
                            include 'core/VIP/Share/update.php';
                            break;
                        case 'Manager_VIP_Share':
                            include 'core/VIP/Share/list.php';
                            break;
                        case 'Extending_Share':
                            include 'core/VIP/Share/extend.php';
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
                            include 'core/Token/check.html';
                            break;
                        case 'Gets_Token':
                            include 'core/Token/Get/index.php';
                            break;

                        //BUFF
                        case 'BUFF_LIKE':
                            include 'core/BUFF/Like.php';
                            break;
                        case 'BUFF_CMT':
                            include 'core/BUFF/CMT.php';
                            break;
                        case 'BUFF_Friend':
                            include 'core/BUFF/Friend.php';
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

                        //List VIP SHare CTV
                        case 'CTV_Delete_Share':
                            include 'core/Admin/CTV/Share/del.php';
                            break;
                        case 'CTV_Extending_Share':
                            include 'core/Admin/CTV/Share/extend.php';
                            break;
                        case 'CTV_Update_Share':
                            include 'core/Admin/CTV/Share/update.php';
                            break;
                        case 'CTV_Share':
                            include 'core/Admin/CTV/Share/list.php';
                            break;

                        // Đại lí
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

                        //Statics
                        case 'Statics//':
                            include 'core/Admin/Statics/list.php';
                            break;
                        case 'Update_Statics':
                            include 'core/Admin/Statics/update.php';
                            break;
                        case 'Reset_Statics':
                            include 'core/Admin/Statics/reset.php';
                            break;

                        //Event
                        case 'Trung_Thu_2017':
                            include 'Event/trungthu.php';
                            break;
                        case 'Event_Add_Card':
                            include 'Event/card.php';
                            break;
                        default:
                            echo "<script>alert('Vui lòng đăng nhập!!'); window.location='index.php';</script>";
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
                <b>BestAuto.Pro</b> Co, Ltd. <a href="//bestauto.pro" target="_blank"> Auto Bot Like Facebook</a>
            </div>
            <strong>&copy; 2017 <a href="#">VIP.BestAuto.Pro</a></strong> Powered By <b>Sexy Team</b> <img src="src/sexyteam.jpg" alt="sexyteam" style="width:24px;height:24px" data-toggle="tooltip" title="Powered By Sexy Team" />
        </footer>

        <div id="price" class="modal animated flash" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Bảng Giá VIP.BestAuto.Pro</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a  href="#like" data-toggle="tab">VIP LIKE</a>
                            </li>
                            <li><a href="#cmt" data-toggle="tab">VIP CMT</a>
                            </li>
                            <li><a href="#reaction" data-toggle="tab">VIP REACTION</a>
                            </li>
                            <li><a href="#share" data-toggle="tab">VIP Share</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="like">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Max Like</th>
                                            <th>Limit Post</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>

                                        </tr>
                                        <?php
                                        $like = "SELECT max, price FROM package WHERE type='LIKE' AND max <=1500 ORDER BY price ASC";
                                        $r_like = mysqli_query($conn, $like);
                                        while ($x = mysqli_fetch_assoc($r_like)) {
                                            $member = $x['price'];
                                            $agency = $x['price'] - $x['price'] * 20 / 100;
                                            $ctv = $x['price'] - $x['price'] * 10 / 100;
                                            ?>
                                            <tr style="font-weight: bold">
                                                <td><?php echo $x['max'] . ' Likes'; ?></td>
                                                <td><?php echo "Không giới hạn"; ?></td>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="cmt">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Max CMT</th>
                                            <th>Limit Post</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>
                                        </tr>
                                        <?php
                                        $cmt = "SELECT max, price FROM package WHERE type='CMT' ORDER BY price ASC";
                                        $r_cmt = mysqli_query($conn, $cmt);
                                        while ($x = mysqli_fetch_assoc($r_cmt)) {
                                            $member = $x['price'];
                                            $agency = $x['price'] - $x['price'] * 20 / 100;
                                            $ctv = $x['price'] - $x['price'] * 10 / 100;
                                            ?>
                                            <tr style="font-weight: bold">
                                                <td><?php echo $x['max'] . ' CMT'; ?></td>
                                                <td><?php echo "Không giới hạn"; ?></td>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="reaction">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Max Cảm Xúc/Cron</th>
                                            <th>Loại Cảm Xúc</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>
                                        </tr>
                                        <?php
                                        $react = "SELECT max, price FROM package WHERE type='REACTION' ORDER BY price ASC";
                                        $r_react = mysqli_query($conn, $react);
                                        while ($x = mysqli_fetch_assoc($r_react)) {
                                            $member = $x['price'];
                                            $agency = $x['price'] - $x['price'] * 20 / 100;
                                            $ctv = $x['price'] - $x['price'] * 10 / 100;
                                            ?>
                                            <tr style="font-weight: bold">
                                                <td><?php echo $x['max'] . ' Reactions'; ?></td>
                                                <td><?php echo "Tùy chọn"; ?></td>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="share">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Max Share</th>
                                            <th>Limit Post</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>
                                        </tr>
                                        <?php
                                        $react = "SELECT max, price FROM package WHERE type='SHARE' AND max <= 1000 ORDER BY price ASC";
                                        $r_react = mysqli_query($conn, $react);
                                        while ($x = mysqli_fetch_assoc($r_react)) {
                                            $member = $x['price'];
                                            $agency = $x['price'] - $x['price'] * 20 / 100;
                                            $ctv = $x['price'] - $x['price'] * 10 / 100;
                                            ?>
                                            <tr style="font-weight: bold">
                                                <td><?php echo $x['max'] . ' Share'; ?></td>
                                                <td><?php echo "Không giới hạn"; ?></td>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <p>
                            <font color="red">(*)</font>: Giá này được áp dụng khi bạn là <b>Member thường </b>trên hệ thống<br />
                            <font color="red">(**)</font>: Giá này được áp dụng khi bạn là <b>Cộng tác viên</b> của hệ thống (Min 300K - 500K )</b><br />
                            <font color="red">(***)</font>: Giá này được áp dụng khi bạn là <b>Đại Lí</b> của hệ thống ( Min 2 - 3 triệu )</b><br />
                            <b>Tất cả đều được hệ thống <font color="red">Tự động giảm</font> khi Thêm VIP ID!<br />Nếu bạn muốn mua các <font color="red">gói Like, CMT, Share, Reaction</font> với <font color="red">số lượng</font> và <font color="red">thời hạn</font> khác tùy chọn, liên hệ Admin để trao đổi và được hỗ trợ!</b><br />
                            <b>Chú ý: Bảng giá trên được áp dụng với <font color="red">số dư tài khoản của bạn trên hệ thống</font>. Xem chi tiết cách thức nạp tiền, chiết khấu các loại thẻ, click <a href="index.php?DS=Charge_Money" target="_blank"><font color="red">Vào đây</font></a></b>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="xsprofile" class="modal animated shake" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="card hovercard">
                            <div class="cardheader" style="background-image: url('src/banner_.jpg');/* hihi token nek */ background-size: 100% auto;border-bottom: 1px solid #e1e8ed;border-radius: 4px 4px 0 0;"></div>
                            <div class="info" style="padding: 10px">
                                <div class="title" style="font-size: 20px;color:white">
                                    <div class="avatar">
                                        <img alt="" src="https://graph.fb.me/<?php echo isset($xprofile) ? $xprofile : ''; ?>/picture">
                                    </div>
                                    <?php echo isset($uname, $xname) ? $xname . '( @' . $uname . ' )' : ''; ?>
                                </div>
                                <button class="btn btn-default" data-toggle="tooltip" title="Đây là số dư hiện tại của bạn">Số dư: <span class="badge"><?php echo isset($xbill) ? number_format($xbill) . ' VNĐ' : ''; ?></button><br />
                                <a href="index.php?DS=Change_Info" data-toggle="tooltip" title="Cập nhật thông tin tài khoản" class="btn btn-info">Cập nhật thông tin</a>
                                <a href="index.php?DS=Change_Pass" data-toggle="tooltip" title="Thay đổi mật khẩu tài khoản"  class="btn btn-danger">Đổi mật khẩu</a><br />
                                <a href="index.php?DS=Charge_Money" data-toggle="tooltip" title="Nạp tiền vào tài khoản"  class="btn btn-success">Nạp tiền</a> 
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
        <script src="plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/adminlte.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/js/pages/dashboard2.js"></script>
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="plugins/ckeditor/ckeditor.js"></script>
        <script>
            var _0x2301=["\x64\x65\x73\x63","\x23\x65\x78\x61\x6D\x70\x6C\x65\x31\x2C\x20\x23\x65\x78\x61\x6D\x70\x6C\x65\x32\x2C\x23\x65\x78\x61\x6D\x70\x6C\x65\x33\x2C\x23\x65\x78\x61\x6D\x70\x6C\x65\x34","\x61\x73\x63","\x23\x6F\x72\x64\x65\x72\x50\x72\x69\x63\x65","\x73\x6C\x69\x64\x65\x54\x6F\x67\x67\x6C\x65","\x2E\x70\x61\x63\x6B","\x63\x6C\x69\x63\x6B","\x23\x70\x61\x63\x6B\x61\x67\x65","\x6F\x75\x74\x65\x72\x57\x69\x64\x74\x68","\x62\x6F\x64\x79","\x73\x69\x64\x65\x62\x61\x72\x2D\x63\x6F\x6C\x6C\x61\x70\x73\x65","\x61\x64\x64\x43\x6C\x61\x73\x73"];$(function(){$(_0x2301[1]).DataTable({"\x70\x61\x67\x69\x6E\x67":true,"\x6C\x65\x6E\x67\x74\x68\x43\x68\x61\x6E\x67\x65":true,"\x73\x65\x61\x72\x63\x68\x69\x6E\x67":true,"\x6F\x72\x64\x65\x72\x69\x6E\x67":true,"\x69\x6E\x66\x6F":true,"\x61\x75\x74\x6F\x57\x69\x64\x74\x68":true,"\x6F\x72\x64\x65\x72":[[0,_0x2301[0]]]});$(_0x2301[3]).DataTable({"\x70\x61\x67\x69\x6E\x67":true,"\x6C\x65\x6E\x67\x74\x68\x43\x68\x61\x6E\x67\x65":true,"\x73\x65\x61\x72\x63\x68\x69\x6E\x67":true,"\x6F\x72\x64\x65\x72\x69\x6E\x67":true,"\x69\x6E\x66\x6F":true,"\x61\x75\x74\x6F\x57\x69\x64\x74\x68":true,"\x6F\x72\x64\x65\x72":[[1,_0x2301[2]]]})});$(_0x2301[7])[_0x2301[6]](function(){$(_0x2301[5])[_0x2301[4]]()});function collapseSidebarDuySexy(){$(function(){if($(_0x2301[9])[_0x2301[8]](true)> 756){$(_0x2301[9])[_0x2301[11]](_0x2301[10])}})}
        </script>
        <?php include 'check.php'; ?>
</body>
</html>
