<?php
    if($rule != 'admin' || $idctv != 1){
        echo "<script>alert('CÚT'); window.location = 'index.php';</script>";
    }
?>
<?php
	if(isset($_GET['id'])){
		$getinfo = "SELECT name, user_name, payment FROM member WHERE id_ctv={$_GET['id']}";
		$result = mysqli_query($conn, $getinfo);
		$info = mysqli_fetch_assoc($result);
	}else if(isset($_GET['id_ctv'])){
		$getinfo = "SELECT name, user_name, payment FROM ctv WHERE id_ctvs={$_GET['id_ctv']}";
		$result = mysqli_query($conn, $getinfo);
		$info = mysqli_fetch_assoc($result);
	}
    if(isset($_POST['submit'])){
        $pay = $_POST['pay'];
        if(isset($_GET['id'])){
        	$id = $_GET['id'];
        	$update = "UPDATE member SET payment = '$pay' WHERE id_ctv=$id";
        }else if(isset($_GET['id_ctv'])){
        	$id_ctv = $_GET['id_ctv'];
        	$update = "UPDATE ctv SET payment = '$pay' WHERE id_ctvs=$id_ctv";
        }
        if(mysqli_query($conn, $update)){
        	echo "<script>alert('Thành công');window.location='index.php?DS=Statics';</script>";
    	}
    }
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật doanh thu</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Username:</label>

                        <div class="col-sm-10">
                            <input class="form-control" value="<?php echo isset($info['user_name']) ? $info['user_name'] : ''; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Số tiền:</label>

                        <div class="col-sm-10">
                            <input class="form-control" value="<?php echo isset($info['payment']) ? $info['payment'] : ''; ?>" name="pay">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
