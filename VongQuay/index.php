<?php
    // check phát
    $check = mysqli_query($conn, "SELECT COUNT(*) FROM event WHERE user_name = '$uname' AND rule='$rule'");
    $getcheck = mysqli_fetch_assoc($check);
    $res = $getcheck['COUNT(*)'];
    if($res == 0){ // vào lần đầu  thì cho  1 lượt
        mysqli_query($conn, "INSERT INTO event(user_name, rule, turn) VALUES('$uname','$rule',1)");
    }
    $getcount = mysqli_query($conn, "SELECT turn,id FROM event WHERE user_name = '$uname' AND rule='$rule'");
    $count = mysqli_fetch_assoc($getcount);
    $turn = $count['turn'];
    $id = $count['id'];
?>
<link rel="stylesheet" href="Event/css/duy.css" type="text/css" />
<script type="text/javascript" src="Event/js/awardRotate.js"></script>
<div id="event_result"></div>
<script type="text/javascript">
    var _0xc6e3=["\x68\x74\x6D\x6C","\x23\x65\x76\x65\x6E\x74\x5F\x72\x65\x73\x75\x6C\x74","\x70\x6F\x73\x74","\x72\x61\x6E\x64\x6F\x6D","\x66\x6C\x6F\x6F\x72","\x73\x74\x6F\x70\x52\x6F\x74\x61\x74\x65","\x23\x72\x6F\x74\x61\x74\x65","\x72\x6F\x74\x61\x74\x65","\x45\x76\x65\x6E\x74\x2F\x70\x72\x6F\x67\x72\x65\x73\x73\x2E\x70\x68\x70","\x6C\x6F\x73\x65\x2D\x74\x75\x72\x6E","\x6D\x6F\x6E\x65\x79","\x6E\x65\x77\x2D\x74\x75\x72\x6E","\x42\u1EA1\x6E\x20\u0111\xE3\x20\x68\u1EBF\x74\x20\x6C\u01B0\u1EE3\x74\x20\x71\x75\x61\x79\x21\x21"];function sendAjax(_0x5c08x2,_0x5c08x3,_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,_0x5c08x8){$[_0xc6e3[2]](_0x5c08x2,{id:_0x5c08x4,idacc:_0x5c08x5,type:_0x5c08x3,uname:_0x5c08x6,rule:_0x5c08x7},function(_0x5c08x9){setTimeout(function(){$(_0xc6e3[1])[_0xc6e3[0]](_0x5c08x9)},_0x5c08x8)})}function rnd(_0x5c08xb,_0x5c08xc){return Math[_0xc6e3[4]](Math[_0xc6e3[3]]()* (_0x5c08xc- _0x5c08xb+ 1)+ _0x5c08xb)}function getReward(_0x5c08x7,_0x5c08x6,_0x5c08x4,_0x5c08x5,_0x5c08xe){if(_0x5c08xe> 0){var _0x5c08xf=false;var _0x5c08x10=function(_0x5c08x11,_0x5c08x12){_0x5c08xf=  !_0x5c08xf;$(_0xc6e3[6])[_0xc6e3[5]]();$(_0xc6e3[6])[_0xc6e3[7]]({angle:0,animateTo:_0x5c08x12+ 3600,duration:9000,callback:function(){_0x5c08xf=  !_0x5c08xf}})};if(_0x5c08xf){return};var _0x5c08x13=rnd(0,7);switch(_0x5c08x13){case 0:_0x5c08x10(0,337);sendAjax(_0xc6e3[8],_0xc6e3[9],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 1:_0x5c08x10(1,26);sendAjax(_0xc6e3[8],_0xc6e3[10],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 2:_0x5c08x10(2,137);sendAjax(_0xc6e3[8],_0xc6e3[11],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 3:_0x5c08x10(3,137);sendAjax(_0xc6e3[8],_0xc6e3[11],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 4:_0x5c08x10(4,190);sendAjax(_0xc6e3[8],_0xc6e3[10],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 5:_0x5c08x10(5,190);sendAjax(_0xc6e3[8],_0xc6e3[10],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 6:_0x5c08x10(6,235);sendAjax(_0xc6e3[8],_0xc6e3[11],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break;case 7:_0x5c08x10(7,235);sendAjax(_0xc6e3[8],_0xc6e3[11],_0x5c08x4,_0x5c08x5,_0x5c08x6,_0x5c08x7,9000);break}}else {alert(_0xc6e3[12]);return false}}
</script>
    <div class="row">
        <div class="alert alert-success">
            <marquee onmouseover="this.stop();" onmouseout="this.start();">
                <?php 
                $getnoti = mysqli_query($conn, "SELECT event_history.id as stt,time,content FROM event_history INNER JOIN event ON event_history.id_event = event.id WHERE event.user_name != 'admin' ORDER BY event_history.id DESC");
                while($noti = mysqli_fetch_assoc($getnoti)){
                ?>
                <span class="h4" style="padding-right:150px"><?php echo $noti['content']; ?> vào lúc <b><?php echo date('d/m/y - H:i:s',$noti['time']); ?></b></span>
                <?php } ?>
            </marquee>
        </div>
        <div class="col-md-6" style="overflow: scroll">
             <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><img src="Event/css/icon.png" alt="icon halloween" style="width:20px;height:20px" /> Vòng quay Halloween</h3>
            </div>
            </div>
    <div class="turntable-bg">
        <!-- Không bug được đâu -->
        <div class="pointer" onclick="getReward('<?php echo isset($rule) ? $rule : 'undefined'; ?>','<?php echo isset($uname) ? $uname : 'undefined'; ?>','<?php echo isset($id) ? $id : 'undefined'; ?>','<?php echo isset($idctv) ? $idctv : 'undefined'; ?>','<?php echo isset($turn) ? $turn : 'undefined'; ?>')"><img class="img-responsive" src="Event/images/click.png" alt="pointer"/></div>
        <div class="rotate" ><img id="rotate" class="img-responsive" src="Event/images/vongquay.png" alt="turntable"/></div>
        <!-- Đã bảo là không bug được đâu -->
    </div>
    </div>
    <div class="col-md-6">
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-spinner fa-spin"></i>

              <h3 class="box-title">Số lượt quay còn lại: <span style="color:red"><?php echo $turn; ?></span></h3>
            </div>
            </div>
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lịch sử quay ( TOP sẽ được cập nhật khi đủ dữ liệu ! )</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                  <th>Nội dung</th>
                  <th>Thời gian</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        //$i = 1;
                        $gethis = mysqli_query($conn, "SELECT event_history.id as stt,time,content FROM event_history INNER JOIN event ON event_history.id_event = event.id WHERE user_name != 'admin'");
                        while($his = mysqli_fetch_assoc($gethis)){
                            $time = date('d/m/Y - H:i:s', $his['time']);
                            $content  = $his['content'];
                            //$i++;
                    ?>
                <tr>
                    <td><?php echo $his['stt']; ?></td>
                  <td><?php echo $content; ?></td>
                  <td><?php echo $time; ?></td>
                </tr>
                <?php } ?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        </div>
    </div>
    <script>
        $('#example1').dataTable({
            "pageLength": 10
        });
    </script>