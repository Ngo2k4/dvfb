<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php if($rule != 'admin') header('Location: trang-chu.html'); ?>
<?php
if(isset($_POST['submit'])){
    $code = $_POST['code'];
    $sale = $_POST['sale'];
    $type = $_POST['type'];
    $min_price  = $_POST['min_price'];
    $ins = mysqli_query($conn, "INSERT INTO coupon(code, sale_off, type, min_price) VALUES('$code','$sale','$type','$min_price')");
    if($ins){
        echo "<script>alert('Thêm thành công');window.location='coupon.html';</script>";
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm Coupon</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">Mã Coupon:</label>
                        <div class="col-sm-10">
                            <input type="text" name="code" id="code" placeholder="Nhập mã coupon" class="form-control" required="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Sale OFF:</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" min="1" max="100" name="sale" placeholder="Nhập giảm giá (%)" required=""/>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Áp dụng cho:</label>

                        <div class="col-sm-10">
                            <select name="type" class="form-control">
                                <option value="all">Tất cả</option>
                            </select>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Giá trị tối thiểu:</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" min="10000" max="10000000" name="min_price" placeholder="Nhập gía trị đơn hàng tối thiểu để áp dụng" required=""/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>