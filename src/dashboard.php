<script src="src/jquery.zoom.min.js"></script>
<style>
    .fb-livechat {
        width: 300px;
        height: 383px;
        position: fixed;
        bottom: 15px;
        right: 15px;
        z-index:999;
    }
    .zoom img {
        display: block;
    }

    .zoom img::selection { background-color: transparent; }
</style>
<script>
    $(document).ready(function () {
        $('#noti').zoom();
    });
</script>
<?php
$like = "SELECT COUNT(*) FROM autolike";
$result = mysqli_query($conn, $like);
$likes = mysqli_fetch_assoc($result)['COUNT(*)'];

$memb = "SELECT COUNT(*) FROM member";
$result1 = mysqli_query($conn, $memb);
$membs = mysqli_fetch_assoc($result1)['COUNT(*)'];

$viplike = "SELECT COUNT(*) FROM vip";
$result2 = mysqli_query($conn, $viplike);
$viplikes = mysqli_fetch_assoc($result2)['COUNT(*)'];

$vipcmt = "SELECT COUNT(*) FROM vipcmt";
$result3 = mysqli_query($conn, $vipcmt);
$vipcmts = mysqli_fetch_assoc($result3)['COUNT(*)'];

$vipreaction = "SELECT COUNT(*) FROM vipreaction";
$result4 = mysqli_query($conn, $vipreaction);
$vipreactions = mysqli_fetch_assoc($result4)['COUNT(*)'];

$vipid = $viplikes + $vipcmts + $vipreactions;
?><div class="row">
<div class="col-md-9">
    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="2s">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-thumbs-up"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">LIKES</span>
                <span class="info-box-number">1<?php echo $likes; ?><small>+</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="3s">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-comment"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Comments</span>
                <span class="info-box-number"><?php echo $likes; ?><small>+</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="4s">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Members</span>
                <span class="info-box-number"><?php echo $membs; ?><small>+</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="5s">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">VIP ID</span>
                <span class="info-box-number">4<?php echo $vipid; ?><small>+</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    </div>
    <a href="#sale" data-toggle="modal">
    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="5s">
        <div class="info-box">
            <span class="info-box-icon bg-violet"><img src="src/click.jpg" alt="click" /></span>

            <div class="info-box-content">
                <img src="src/sale.jpg" alt="sale" style="width:100%;height:70px" class="img-responsive" />
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    </a>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
        <div class="panel-body info-box" style="border-radius: 5px">
            <h1 class="wow flash">VIP.BestAuto.Pro</h1>
            <p  class="wow shake">H??? Th???ng H??? Tr??? Qu???n L?? Facebook VIP Auto m???nh m??? nh???t hi???n nay v???i nh???ng t??nh n??ng v?????t tr???i!</p>
            <a class="btn btn-success btn-lg wow bounceInLeft" data-toggle="modal" style="border-radius: 20px" href="#price"> B???ng gi?? VIP </a>
            <a class="btn btn-info btn-lg wow bounceInRight" style="border-radius: 20px" href="index.php?DS=Login">S??? D???NG NGAY</a>
        </div>
    </div>
</div>
<div class="col-sm-4" style="background: #fff; border-radius: 5px;box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
    <div class="widget">
        <div class="card panel-body text-center wow tada">
            <div class="et_pb_main_blurb_image"><img width="100px" src="src/1.png" alt="" class="et-waypoint et_pb_animation_off et-animated"></div>
            <div class="et_pb_blurb_container">
                <h4>C??ng ngh??? m???i</h4>

                <p>M???i th??? ?????u ???????c t??? ?????ng h??a v?? ???n ?????nh v???i h??? th???ng m??y ch??? t???t nh???t hi???n nay.</p>

            </div>
        </div>
        <!-- .et_pb_blurb_content -->
    </div>
    <!-- .et_pb_blurb -->
</div>
<div class="col-sm-4" style="background: #fff; border-radius: 5px;box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
    <div class="widget">
        <div class="card panel-body text-center wow tada">
            <div class="et_pb_main_blurb_image"><img width="133px" src="src/2.png" alt="" class="et-waypoint et_pb_animation_off et-animated"></div>
            <div class="et_pb_blurb_container">
                <h4>Chi ph?? th???p</h4>

                <p>Gi?? c??? h???p l??, c?? nhi???u g??i d???ch v??? ????p ???ng m???i nhu c???u c???a ng?????i d??ng.</p>

            </div>
        </div>
        <!-- .et_pb_blurb_content -->
    </div>
    <!-- .et_pb_blurb -->
</div>
<div class="col-sm-4" style="background: #fff; border-radius: 5px;box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
    <div class="widget">
        <div class="card panel-body text-center wow tada">
            <div class="et_pb_main_blurb_image"><img width="100px" src="src/3.png" alt="" class="et-waypoint et_pb_animation_off et-animated"></div>
            <div class="et_pb_blurb_container">
                <h4>B???o M???t & Hi???u qu???</h4>

                <p>B???n ch??? c???n ????ng k?? t??i kho???n v?? l???a ch???n d???ch v???. Vi???c c??n l???i, ????? ch??ng t??i lo.</p>

            </div>
        </div>
        <!-- .et_pb_blurb_content -->
    </div>
    <!-- .et_pb_blurb -->
</div>
<img class="animated bounceInDown" data-toggle="tooltip" title="Li??n h??? v???i ch??ng t??i" src="src/mess.png" onclick="showMess();" id="mess" style="display: none;width:50px;height:50px; position: fixed; bottom:200px;right: 15px" />
<div id="fb-livechat" class="fb-livechat animated bounceInUp hidden-xs">
    <div class="modal-content">
        <div class="modal-header" style="background: #3366FF">
            <button type="button" class="close" aria-label="Close" title="????ng" onclick="removeFacebookLiveChat();"><span aria-hidden="true" style="color: black; font-size:15px"><img data-toggle="tooltip" title="???n khung n??y" src="src/minize.png" style="width:32px;height:32px" /></span></button>
            <span class="modal-title h4" data-toggle="tooltip" title="G???i tin nh???n cho ch??ng t??i" style="font-weight: bold">Li??n h??? v???i ch??ng t??i</span>
        </div>
        <div class="modal-body">
            <div class="fb-page" data-href="https://www.facebook.com/VIP.BestAuto.Pro/" data-tabs="messages" data-width="300" data-height="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            </div>
        </div>
    </div>
</div>
<!-- <a href="#sale" id="showSale" data-toggle="modal"></a> -->
<div id="sale" class="modal fade animated bounceInDown" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Khuy???n M???i 2/9</h4>
            </div>
            <div class="modal-body">
                <div style="" id="noti">
                    <img src="src/sale.jpg" alt="Sale" class="img-thumbnail img-responsive"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">????ng</button>
            </div>
        </div>

    </div>
</div>
<script>
    function removeFacebookLiveChat() {
        $('#fb-livechat').fadeOut();

        $('#mess').fadeTo(1000, 0.5);

    }

    function showMess() {
        $('#mess').fadeOut();
        $('#fb-livechat').show();
    }
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!-- <script>
    window.onload = function () {
        document.getElementById('showSale').click();
    };
</script> -->