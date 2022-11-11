<?php
if ($rule != 'admin' || $idctv != 1) {
    echo "<script>alert('Ra chỗ khác chơi');window.location='index.php';</script>";
}
?>
<?php
   if(isset($_GET['id_package'])){
       $id = $_GET['id_package'];
       $get = "SELECT max, price, id_ctv FROM package WHERE id= $id AND type='CMT'";
       $result = mysqli_query($conn, $get);
       $x = mysqli_fetch_assoc($result);
       if($rule != 'admin'){
        if($x['id_ctv'] != $idctv){
            echo "<script>alert('CÚT'); window.location='index.php';</script>";
        }
       }
   }
   if(isset($_POST['submit'])){
      $max_cmt = $_POST['max_cmt'];
      $price = $_POST['price'];
      $sql = "UPDATE package SET price='$price', max='$max_cmt' WHERE id=$id";
      if(mysqli_query($conn, $sql)){
          $content = "<b>$uname</b> vừa cập nhật Package <b>VIP CMT</b>, Max CMT: <b> $max_cmt </b> CMTs, Giá tiền: <b> ".number_format($price)." VNĐ </b>";
          $time = time();
          $his = "INSERT INTO history(content, id_ctv, time) VALUES('$content', '$idctv','$time')";
          if(mysqli_query($conn, $his)){
              echo "<script>alert('Thành công'); window.location='index.php?DS=List_Package_CMT';</script>";
          }
      }
   }
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật Package VIP CMT</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">Max CMT:</label>

                        <div class="col-sm-10">
                           <input type="number" name="max_cmt" max="10000" class="form-control" value="<?php echo isset($x['max']) ? $x['max'] : ''; ?>" required="" />
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Giá tiền (VNĐ):</label>

                        <div class="col-sm-10">
                            <input type="number" name="price" class="form-control" max="1000000" value="<?php echo isset($x['price']) ? $x['price'] : ''; ?>" required="" />
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
