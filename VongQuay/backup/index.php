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
    /* 
        - Beta Code By DuySexy
        - FB: /DuySexyZ
        - Thank To : The Bro in China For Rotate JS&IMG
    */
    function sendAjax(url,types,idevent,idaccount,username,rules, timeout){
        $.post(url, {id: idevent, idacc: idaccount, type: types, uname: username, rule: rules},function(data){setTimeout(function(){$('#event_result').html(data);},timeout);});
    }
    function rnd(n, m){
    	return Math.floor(Math.random()*(m-n+1)+n)
    }
    function getReward(rules, username, idevent, idaccount, turn){
        if(turn > 0){
        	var bRotate = false;
        	var rotateFn = function (awards, angles){
        		bRotate = !bRotate;
        		$('#rotate').stopRotate();
        		$('#rotate').rotate({                
        			angle:0,
        			animateTo:angles+3600,
        			duration:9000,
        			callback:function (){
        				bRotate = !bRotate;
        			}
        		})
        	};
    		if(bRotate) return;
    		var item = rnd(0,7);
    		switch (item) {
    			case 0:
    				rotateFn(0, 337);
    				sendAjax('Event/progress.php', 'lose-turn', idevent, idaccount, username, rules, 9000);
    				break;
    			case 1:
    				rotateFn(1, 26);
    				sendAjax('Event/progress.php', 'money', idevent, idaccount, username, rules, 9000);
    				break;
    			case 2:
    				rotateFn(2, 137);
    			    sendAjax('Event/progress.php', 'new-turn', idevent, idaccount, username, rules, 9000);
    				break;
    			case 3:
    				rotateFn(3, 137);
    				sendAjax('Event/progress.php', 'new-turn', idevent, idaccount, username, rules, 9000);
    				break;
    			case 4:
    				rotateFn(4, 190);
    				sendAjax('Event/progress.php', 'money', idevent, idaccount, username, rules, 9000);
    				break;
    			case 5:
    				rotateFn(5, 190);
    				sendAjax('Event/progress.php', 'money', idevent, idaccount,  username, rules, 9000);
    				break;
    			case 6:
    				rotateFn(6, 235);
    				sendAjax('Event/progress.php', 'new-turn', idevent, idaccount,  username, rules, 9000);
    				break;
    			case 7:
    				rotateFn(7, 235);
    				sendAjax('Event/progress.php', 'new-turn', idevent, idaccount,  username, rules, 9000);
    				break;
    		}
        }else{
            alert('Bạn đã hết lượt quay!!');
            return false;
        }
	}
</script>
    <div class="row">
        <div class="alert alert-success">
            <marquee onmouseover="this.stop();" onmouseout="this.start();">
                <?php 
                $getnoti = mysqli_query($conn, "SELECT event_history.id as stt,time,content FROM event_history INNER JOIN event ON event_history.id_event = event.id ORDER BY event_history.id DESC");
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
        <div class="pointer"  onclick="getReward('<?php echo isset($rule) ? $rule : 'undefined'; ?>','<?php echo isset($uname) ? $uname : 'undefined'; ?>','<?php echo isset($id) ? $id : 'undefined'; ?>','<?php echo isset($idctv) ? $idctv : 'undefined'; ?>','<?php echo isset($turn) ? $turn : 'undefined'; ?>')"><img class="img-responsive" src="Event/images/click.png" alt="pointer"/></div>
        <div class="rotate" ><img id="rotate" class="img-responsive" src="Event/images/vongquay.png" alt="turntable"/></div>
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
                        $gethis = mysqli_query($conn, "SELECT event_history.id as stt,time,content FROM event_history INNER JOIN event ON event_history.id_event = event.id");
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