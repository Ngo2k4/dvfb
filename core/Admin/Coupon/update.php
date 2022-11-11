<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php if($rule != 'admin') header('Location: trang-chu.html'); ?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $get_info = mysqli_query($conn, "SELECT code, type, sale_off,min_price FROM coupon WHERE id = $id");
    $info = mysqli_fetch_assoc($get_info);
}
if(isset($_POST['submit'])){
    $code = $_POST['code'];
    $sale = $_POST['sale'];
    $type = $_POST['type'];
    $min_price  = $_POST['min_price'];
    $up = mysqli_query($conn, "UPDATE coupon SET code='$code', type='$type', sale_off='$sale',min_price=$min_price WHERE id=$id");
    if($up){
        echo "<script>alert('Cập nhật thành công');window.location='coupon.html';</script>";
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật Coupon</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">Mã Coupon:</label>
                        <div class="col-sm-10">
                            <input type="text" name="code" id="code" placeholder="Nhập mã coupon" class="form-control" required="" value="<?= isset($info['code']) ? $info['code'] : '';?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Sale OFF:</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" min="1" max="100" name="sale" placeholder="Nhập giảm giá (%)" required="" value="<?= isset($info['sale_off']) ? $info['sale_off'] : '';?>"/>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Áp dụng cho:</label>

                        <div class="col-sm-10">
                            <select name="type" class="form-control">
                                <option value="all" <?= isset($info['type']) && $info['type'] == 'all' ? 'selected' : '';?>>Tất cả</option>
                            </select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Giá trị tối thiểu:</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" min="10000" max="10000000" name="min_price" placeholder="Nhập gía trị đơn hàng tối thiểu để áp dụng" required="" value="<?= isset($info['min_price']) ? $info['min_price'] : '';?>"/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>