<script src="Event/css/sweetalert-dev.js"></script>
<script src="Event/css/sweetalert.min.js"></script>
<link rel="stylesheet" href="Event/css/sweetalert.css" type="text/css" />
<?php
include '../_config.php';
if(isset($_POST['type'], $_POST['rule'], $_POST['uname'], $_POST['id'], $_POST['idacc'])){
    $idacc = $_POST['idacc'];
    $type = $_POST['type'];
    $rule = $_POST['rule'];
    $uname = $_POST['uname'];
    $id = $_POST['id'];
    if($rule == 'freelancer'){
        $checkacc = mysqli_query($conn, "SELECT COUNT(*) FROM ctv WHERE user_name='$uname' AND id_ctvs=$idacc");
    }else{
        $checkacc = mysqli_query($conn, "SELECT COUNT(*) FROM member WHERE user_name='$uname' AND id_ctv=$idacc");
    }
    $result = mysqli_fetch_assoc($checkacc);
    $checkturn = mysqli_query($conn, "SELECT turn FROM event WHERE id=$id");
    $turn = mysqli_fetch_assoc($checkturn);
    if($turn['turn'] > 0 && $result['COUNT(*)'] == 1){
        switch($type){
            case 'money':
                $list_money = array('5000','10000','15000','25000','30000','35000','40000');
                $money = number_format($list_money[array_rand($list_money)]);
                $tien = str_replace(',','',$money);
                if($rule != 'freelancer'){
                    $add = mysqli_query($conn, "UPDATE member SET bill = bill + $tien WHERE user_name='$uname' AND id_ctv = $idacc");
                }else{
                     $add = mysqli_query($conn, "UPDATE ctv SET bill = bill + $tien WHERE user_name='$uname' AND id_ctvs=$idacc");
                }
                if($add){
                    $del = mysqli_query($conn, "UPDATE event SET turn = turn - 1, num_turn = num_turn + 1 WHERE id=$id");
                    if($del){
                        $time = time();
                        $content = "<b>$uname</b> nhận được <b>$money</b> VNĐ vào tài khoản!";
                        $his = mysqli_query($conn, "INSERT INTO event_history(time, content, id_event) VALUES('$time','$content','$id')");
                        if($his){
                            echo "<script>swal({
                                      html: true,
                                      title: 'GREAT!!!',
                                      text: '$content',
                                      type: 'success',
                                    },
                                    function(){
                                      location.reload();
                                    });</script>";
                        }
                    }
                }
                break;
            
            case 'new-turn':
                mysqli_query($conn, "UPDATE event SET turn = turn - 1, num_turn = num_turn + 1 WHERE id=$id");
                $add = mysqli_query($conn, "UPDATE event SET turn = turn + 1 WHERE id=$id");
                if($add){
                    $time = time();
                    $content = "<b>$uname</b> nhận được <b>1</b> lượt quay mới!";
                    $his = mysqli_query($conn, "INSERT INTO event_history(content, time, id_event) VALUES('$content', '$time', $id)");
                    if($his){
                        echo "<script>swal({
                                      html: true,
                                      title: 'GREAT!!!',
                                      text: '$content',
                                      type: 'success',
                                    },
                                    function(){
                                      location.reload();
                                    });</script>";
                    }
                }
                break;
            
            case 'lose-turn';
                $del = mysqli_query($conn, "UPDATE event SET turn = turn - 1,num_turn = num_turn + 1 WHERE id=$id");
                    if($del){
                        $time = time();
                        $content = "Ahihi, <b>$uname</b> đã mất cmn 1 lượt quay!!!";
                        $his = mysqli_query($conn, "INSERT INTO event_history(content, time, id_event) VALUES('$content', '$time', $id)");
                        if($his){
                            echo "<script>swal({
                                      html: true,
                                      title: 'GREAT!!!',
                                      text: '$content',
                                      type: 'success',
                                    },
                                    function(){
                                      location.reload();
                                    });</script>";
                        }
                    }
                break;
        }
    }else{
        echo "<script>swal({
              html: true,
              title: 'FUCK!!!',
              text: 'Còn lâu mới bug được nhé em yêuu!!!!',
              type: 'error',
            },
            function(){
              location.reload();
            });</script>";
    }
}else{
    echo 'BIẾN';
}
?>