<script src="src/jCarouselLite/jquery.jcarousellite.js"></script>
<style>
.dash-box {
    position: relative;
    background: rgb(255, 86, 65);
    background: -moz-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    background: linear-gradient(to bottom, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#ff5641', endColorstr='#fd3261', GradientType=0);
    border-radius: 4px;
    text-align: center;
    margin: 60px 0 50px;
}
.dash-box-icon {
    position: absolute;
    transform: translateY(-50%) translateX(-50%);
    left: 50%;
}
.dash-box-action {
    transform: translateY(-50%) translateX(-50%);
    position: absolute;
    left: 50%;
}
.dash-box-body {
    padding: 50px 20px;
}
.dash-box-icon:after {
    width: 60px;
    height: 60px;
    position: absolute;
    background: rgba(247, 148, 137, 0.91);
    content: '';
    border-radius: 50%;
    left: -10px;
    top: -10px;
    z-index: -1;
}
.dash-box-icon > i {
    background: #ff5444;
    border-radius: 50%;
    line-height: 40px;
    color: #FFF;
    width: 40px;
    height: 40px;
	font-size:22px;
}
.dash-box-icon:before {
    width: 75px;
    height: 75px;
    position: absolute;
    background: rgba(253, 162, 153, 0.34);
    content: '';
    border-radius: 50%;
    left: -17px;
    top: -17px;
    z-index: -2;
}
.dash-box-action > button {
    border: none;
    background: #FFF;
    border-radius: 19px;
    padding: 7px 16px;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 11px;
    letter-spacing: .5px;
    color: #003e85;
    box-shadow: 0 3px 5px #d4d4d4;
}
.dash-box-body > .dash-box-count {
    display: block;
    font-size: 30px;
    color: #FFF;
    font-weight: 300;
}
.dash-box-body > .dash-box-title {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.81);
}

.dash-box.dash-box-color-2 {
    background: rgb(252, 190, 27);
    background: -moz-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: -webkit-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: linear-gradient(to bottom, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#fcbe1b', endColorstr='#f85648', GradientType=0);
}
.dash-box-color-2 .dash-box-icon:after {
    background: rgba(254, 224, 54, 0.81);
}
.dash-box-color-2 .dash-box-icon:before {
    background: rgba(254, 224, 54, 0.64);
}
.dash-box-color-2 .dash-box-icon > i {
    background: #fb9f28;
}

.dash-box.dash-box-color-3 {
    background: rgb(183,71,247);
    background: -moz-linear-gradient(top, rgba(183,71,247,1) 0%, rgba(108,83,220,1) 100%);
    background: -webkit-linear-gradient(top, rgba(183,71,247,1) 0%,rgba(108,83,220,1) 100%);
    background: linear-gradient(to bottom, rgba(183,71,247,1) 0%,rgba(108,83,220,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b747f7', endColorstr='#6c53dc',GradientType=0 );
}
.dash-box-color-3 .dash-box-icon:after {
    background: rgba(180, 70, 245, 0.76);
}
.dash-box-color-3 .dash-box-icon:before {
    background: rgba(226, 132, 255, 0.66);
}
.dash-box-color-3 .dash-box-icon > i {
    background: #8150e4;
}
.twPc-div {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #e1e8ed;
    border-radius: 6px;
    height: 220px;
     // orginal twitter width: 290px;
}
.twPc-bg {
    background-image: url("https://png.pngtree.com/thumb_back/fw800/back_pic/00/03/16/25561d2660ac54b.jpg");
    background-position: 0 50%;
    background-size: 100% auto;
    border-bottom: 1px solid #e1e8ed;
    border-radius: 4px 4px 0 0;
    height: 95px;
    width: 100%;
}
.twPc-block {
    display: block !important;
}
.twPc-button {
    margin: -35px -10px 0;
    text-align: right;
    width: 100%;
}
.twPc-avatarLink {
    background-color: #fff;
    border-radius: 6px;
    display: inline-block !important;
    float: left;
    margin: -30px 5px 0 8px;
    max-width: 100%;
    padding: 1px;
    vertical-align: bottom;
}
.twPc-avatarImg {
    border: 2px solid #fff;
    border-radius: 7px;
    box-sizing: border-box;
    color: #fff;
    height: 72px;
    width: 72px;
}
.twPc-divUser {
    margin: 5px 0 0;
}
.twPc-divName {
    font-size: 18px;
    font-weight: 700;
    line-height: 21px;
}
.twPc-divName a {
    color: inherit !important;
}
.twPc-divStats {
    margin-left: 11px;
    padding: 10px 0;
}
.twPc-Arrange {
    box-sizing: border-box;
    display: table;
    margin: 0;
    min-width: 100%;
    padding: 0;
    table-layout: auto;
}
ul.twPc-Arrange {
    list-style: outside none none;
    margin: 0;
    padding: 0;
}
.twPc-ArrangeSizeFit {
    display: table-cell;
    padding: 0;
    vertical-align: top;
}
.twPc-ArrangeSizeFit a:hover {
    text-decoration: none;
}
.twPc-StatValue {
    display: block;
    font-size: 18px;
    font-weight: 500;
    transition: color 0.15s ease-in-out 0s;
}
.twPc-StatLabel {
    color: #8899a6;
    font-size: 10px;
    letter-spacing: 0.02em;
    overflow: hidden;
    text-transform: uppercase;
    transition: color 0.15s ease-in-out 0s;
}
</style>

<?php
if ($rule == 'admin' || $rule == 'member') {
    $sql = "SELECT member.name , bill, user_name, profile, num_id FROM member WHERE id_ctv = $idctv";
} else if ($rule == 'agency') {
    $sql = "SELECT member.name, member.bill, member.user_name, member.profile, member.num_id AS numid, COUNT(ctv.user_name) AS numctv FROM member INNER JOIN ctv ON member.id_ctv = ctv.id_agency WHERE member.id_ctv = $idctv";
} else {
    $sql = "SELECT ctv.name as name, ctv.bill, ctv.user_name, ctv.profile,ctv.num_id as numid, member.user_name as udaili, member.name as ndaili FROM ctv LEFT JOIN member ON member.id_ctv = ctv.id_agency WHERE ctv.id_ctvs = $idctv";
}
$result = mysqli_query($conn, $sql);
$x = mysqli_fetch_assoc($result);
?>
<div class="wow fadeIn" data-wow-duration="2s">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>HEESYSTEM - Thông báo</b>
                </div>
                <?php // } ?>
                <div class="news">
                    <ul class="list-group">
                        <?php
                        $getnoti = "SELECT content FROM notification";
                        $noti = mysqli_query($conn, $getnoti);
                        $i = 0;
                        while ($z = mysqli_fetch_assoc($noti)) {
                            $i++;
                            ?>
                            <li class="list-group-item <?= ($i % 2 == 0) ? 'text-success' : 'text-danger'; ?>" style="width:120%;height:67px;padding:3px">
                                <img src="src/jCarouselLite/new.png" alt="news" style="width: 24px; height:24px" /> <?php echo $z['content']; ?>
                            </li>
                        <?php } ?>
                </div>
            </div>
        </div>



        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
            <div class="twPc-div">
                <div class="twPc-block" style="height: 120px; width:100%; background-image: url('src/banner_.jpg');background-size: 100% 100%;border-bottom: 1px solid #e1e8ed;border-radius: 4px 4px 0 0;"></div>
                <a title="<?php echo isset($x['uname']) ? $x['uname'] : ''; ?>" class="twPc-avatarLink" href="https://fb.com/<?php echo $x['profile']; ?>">
                    <img alt="<?php echo isset($x['uname']) ? $x['uname'] : ''; ?>" src="https://graph.fb.me/<?php echo isset($x['profile']) ? $x['profile'] : ''; ?>/picture" class="twPc-avatarImg">
                </a>

                <div class="twPc-divUser">
                    <div class="twPc-divName">
                        <?php echo $x['name']; ?> <img src="src/verify.png" data-toggle="tooltip" title="Tài khoản đã được Xác minh" alt="verify" style="width:16px;height:16px" /> <?php if ($rule == 'admin') { ?> <img src="src/admin.gif" data-toggle="tooltip" title="Bạn là Admin" alt="admin" style="width:48px" /> <?php } else if ($rule == 'member') { ?><img src="src/member.gif" data-toggle="tooltip" title="Bạn là Member thường" alt="member" style="width:48px" /> <?php } else if ($rule == 'agency') { ?><span class="label label-success">Đại lí <img src="src/agency.png" alt="agency" data-toggle="tooltip" title="Bạn là Đại lí" style="width:20px" /></span> <?php } else { ?> <span class="label label-info">Cộng tác viên <img src="src/ctv.png" alt="ctv" data-toggle="tooltip" title="Bạn là Cộng tác viên" style="width:20px" /></span> <?php } ?>
                    </div>
                    <span>
                        @<span><?php echo $uname; ?></span>
                    </span>
                </div>

                <div class="twPc-divStats">
                    <?php if ($rule == 'admin') { ?>
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">
                                <button class="btn btn-info" data-toggle="tooltip" title="Số dư hiện tại của bạn">Số dư <span class="badge"><?php echo number_format($x['bill']); ?> VNĐ</span></button>  
                            </li>
                            <li class="twPc-ArrangeSizeFit">    
                                <button class="btn btn-success" data-toggle="tooltip" title="Số ID VIP bạn đã thêm trên hệ thống">Số ID VIP <span class="badge"><?php echo $x['num_id']; ?></span></button>                       
                            </li>
                            <li class="twPc-ArrangeSizeFit">    
                                <a class="btn btn-danger" data-toggle="tooltip" title="Lịch sử giao dịch" href="lich-su.html">Lịch sử <span class="badge"><?php echo $count_his; ?></span></a>                       
                            </li>
                            <li class="twPc-ArrangeSizeFit">    
                                <a class="btn btn-warning"  data-toggle="tooltip" title="Danh sách thông báo" href="thong-bao.html">Thông báo <span class="badge"><?php echo $count_noti; ?></span></a>                       
                            </li>
                        </ul>
                    <?php } else if ($rule == 'member') { ?>
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">
                                <button class="btn btn-info" data-toggle="tooltip" title="Số dư hiện tại của bạn">Số dư <span class="badge"><?php echo number_format($x['bill']); ?> VNĐ</span></button>  
                            </li>
                            <li class="twPc-ArrangeSizeFit">    
                                <button class="btn btn-success" data-toggle="tooltip" title="Số ID VIP bạn đã thêm trên hệ thống">Số ID VIP <span class="badge"><?php echo $x['num_id']; ?></span></button>                    
                            </li>
                            <li class="twPc-ArrangeSizeFit">    
                                <a class="btn btn-danger" href="https://www.facebook.com/DuySexyy" target="_blank" data-toggle="tooltip" title="Liên Hệ/Hỗ Trợ">Liên hệ/Hỗ trợ</a>                    
                            </li>
                        </ul>
                    <?php } else if ($rule == 'agency') { ?>
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">

                                <button class="btn btn-info" data-toggle="tooltip" title="Số dư hiện tại của bạn">Số dư <span class="badge"><?php echo number_format($x['bill']); ?> VNĐ</span></button>

                            </li>

                            <li class="twPc-ArrangeSizeFit">

                                <button class="btn btn-warning" data-toggle="tooltip" title="Số CTV của bạn">Số CTV <span class="badge"><?php echo number_format($x['numctv']); ?></span></button>

                            </li>

                            <li class="twPc-ArrangeSizeFit">

                                <button class="btn btn-success" data-toggle="tooltip" title="Số ID VIP bạn đã thêm trên hệ thống">Số ID VIP <span class="badge"><?php echo $x['numid']; ?></span></button>

                            </li>
                            <li class="twPc-ArrangeSizeFit">    
                                <a class="btn btn-danger" href="https://www.facebook.com/DuySexyy" target="_blank" data-toggle="tooltip" title="Liên Hệ/Hỗ Trợ">Liên hệ/Hỗ trợ</a>                    
                            </li>

                        </ul>

                    <?php } else { ?>   
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">

                                <button class="btn btn-info" data-toggle="tooltip" title="Số dư hiện tại của bạn">Số dư <span class="badge"><?php echo number_format($x['bill']); ?> VNĐ</span></button>
                            </li>

                            <li class="twPc-ArrangeSizeFit">
                                <button class="btn btn-warning" data-toggle="tooltip" title="Đại lí của bạn">Đại lí <span class="badge"><?php echo!empty($x['udaili']) ? $x['udaili'] . '( ' . $x['ndaili'] . ' )' : 'BestAuto System'; ?></span></button>
                            </li>

                            <li class="twPc-ArrangeSizeFit">
                                <button class="btn btn-success" data-toggle="tooltip" title="Số ID VIP bạn đã thêm trên hệ thống">Số ID VIP <span class="badge"><?php echo $x['numid']; ?></span></button>
                            </li>



                        </ul>
                    <?php } ?>           
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      	<div class="col-lg-6"> 
      <div class="panel"> 
        <header class="panel-heading"><center style="font-size: 20px;">VIP CẢM XÚC</center>
              <center style="font-size: 14px;"><font color="red"><b>(HOẠT ĐỘNG)</b></font></center></header> 
        <div class="panel-body"> 
          <div class="row"> 
        <div class="col-xs-6"> 
           <a href="them-vip-cam-xuc.html" class="btn btn-block btn-success">MUA</a> 
                </div> 
            <div class="col-xs-6"> 
                 <a href="vip-cam-xuc.html" class="btn btn-block btn-success">QUẢN LÍ</a> 
                                                        </div> 
                                                    </div> </div> </div>  </div> 
			<div class="col-lg-6"> 
      <div class="panel"> 
        <header class="panel-heading"><center style="font-size: 20px;">VIP BÌNH LUẬN </center>
              <center style="font-size: 14px;"><font color="red"><b>(HOẠT ĐỘNG)</b></font></center></header> 
        <div class="panel-body"> 
          <div class="row"> 
        <div class="col-xs-6"> 
           <a href="them-vip-binh-luan.html" class="btn btn-block btn-success">MUA</a> 
                </div> 
            <div class="col-xs-6"> 
                 <a href="vip-binh-luan.html" class="btn btn-block btn-success">QUẢN LÍ</a> 
                                                        </div> 
                                                    </div> </div> </div>  </div>
                                                    
                                                    
		<div class="col-lg-6"> 
      <div class="panel"> 
        <header class="panel-heading"><center style="font-size: 20px;">BOT REACTION</center>
              <center style="font-size: 14px;"><font color="red"><b>(HOẠT ĐỘNG)</b></font></center></header> 
        <div class="panel-body"> 
          <div class="row"> 
        <div class="col-xs-6"> 
           <a href="them-vip-bot-cam-xuc.html" class="btn btn-block btn-success">MUA</a> 
                </div> 
            <div class="col-xs-6"> 
                 <a href="vip-bot-cam-xuc.html" class="btn btn-block btn-success">QUẢN LÍ</a> 
                                                        </div> 
                                                    </div> </div> </div>  </div>
                                                    
                                                    
		<div class="col-lg-6"> 
      <div class="panel"> 
        <header class="panel-heading"><center style="font-size: 20px;">VIP SHARE</center>
              <center style="font-size: 14px;"><font color="red"><b>(TẠM DỪNG)</b></font></center></header> 
        <div class="panel-body"> 
          <div class="row"> 
        <div class="col-xs-6"> 
           <a href="javascript:void(0);" data-toggle="tooltip" title="Tạm dừng VIP Share" class="btn btn-block btn-success">MUA</a> 
                </div> 
            <div class="col-xs-6"> 
                 <a href="javascript:void(0);" data-toggle="tooltip" title="Tạm dừng VIP Share" class="btn btn-block btn-success">QUẢN LÍ</a> 
                       </div> </div> </div>
                         </div> </div> </div>  
    <!--<img class="animated bounceInDown" data-toggle="tooltip" title="Liên hệ với chúng tôi" src="src/mess.png" onclick="showMess();" id="mess" style="width:50px;height:50px; position: fixed; bottom:50px;right: 15px" />-->
    <!--<div id="fb-livechat" class="fb-livechat animated bounceInUp" style="display: none;">-->
    <!--    <div class="modal-content">-->
    <!--        <div class="modal-header" style="background: #3366FF">-->
    <!--            <button type="button" class="close" aria-label="Close" onclick="removeFacebookLiveChat();"><span aria-hidden="true" style="color: black; font-size:15px"><img data-toggle="tooltip" title="Ẩn khung này" src="src/minize.png" style="width:32px;height:32px" /></span></button>-->
    <!--            <span class="modal-title h4" data-toggle="tooltip" title="Gửi tin nhắn cho chúng tôi" style="font-weight: bold">Liên hệ với chúng tôi</span>-->
    <!--        </div>-->
    <!--        <div class="modal-body" style="text-align: center">-->
    <!--            <div class="fb-page" data-href="https://www.facebook.com/BestAuto.VIP.System/" data-tabs="messages" data-width="275" data-height="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
<script>
    var _0x1ef8 = ["\x66\x61\x64\x65\x4F\x75\x74", "\x23\x66\x62\x2D\x6C\x69\x76\x65\x63\x68\x61\x74", "\x66\x61\x64\x65\x54\x6F", "\x23\x6D\x65\x73\x73", "\x73\x68\x6F\x77"];
    var _0x704e = [_0x1ef8[0], _0x1ef8[1], _0x1ef8[2], _0x1ef8[3], _0x1ef8[4]];
    function removeFacebookLiveChat() {
        $(_0x704e[1])[_0x704e[0]]();
        $(_0x704e[3])[_0x704e[2]](1000, 0.5)
    }
    function showMess() {
        $(_0x704e[3])[_0x704e[0]]();
        $(_0x704e[1])[_0x704e[4]]()
    }
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script type="text/javascript">
    $(".news").jCarouselLite({
        // btnNext: ".default .next",
        // btnPrev: ".default .prev",
        vertical: true,
        circular: true,
        auto: 2000,
        start: 0,
        scroll: 1,
        speed: 2000
    });
</script>
