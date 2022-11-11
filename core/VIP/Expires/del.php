<?php
if($rule != 'admin' || $idctv != 1)
{
    header('Location: index.php');
}else{
	if(isset($_POST['submit'])){
	    $i = 0;
		$table = $_POST['table'];
		$time = time();
// 		$sql = "DELETE FROM $table WHERE end <= $time";
// 		if(mysqli_query($conn, $sql)){
// 		    $num = mysqli_affected_rows();
// 		    if(mysqli_query($conn, "UPDATE "))
// 		    echo "<script>alert('Thành Công');location.href='xoa-vipid-het-han.html';</script>";
// 		}
        $get_id = mysqli_query($conn, "SELECT id, id_ctv FROM $table WHERE end <= $time");
        while($x = mysqli_fetch_assoc($get_id)){
            $y = mysqli_query($conn, "DELETE FROM $table WHERE id = {$x['id']}");
            if($y){
                $check_memb = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS memb FROM member WHERE id_ctv = {$x['id_ctv']}"));
                $check_ctv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS freelancer FROM ctv WHERE id_ctvs = {$x['id_ctv']}"));
                if($check_memb['memb'] > 0){
                    $z = mysqli_query($conn, "UPDATE member SET num_id = num_id - 1 WHERE id_ctv = {$x['id_ctv']}");
                }
                if($check_ctv['freelancer'] > 0){
                    $z = mysqli_query($conn, "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs = {$x['id_ctv']}");
                }
            }
        }
	}
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Xóa VIP ID hết hạn</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
            
                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Chọn Loại VIP:</label>

                        <div class="col-sm-10">
                            <select name="table" class="form-control" style="display: inline;width:200px">
								<option value="vip">VIP Cảm Xúc</option>
								<option value="vipcmt">VIP CMT</option>
								<option value="vipshare">VIP Share</option>
								<option value="vipreaction">Bot Cảm Xúc</option>
							</select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div id="del" style="color:red"></div>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Xóa</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>