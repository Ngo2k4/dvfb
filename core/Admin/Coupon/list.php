<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php if($rule != 'admin') header('Location: trang-chu.html'); ?>
<script>
    function xoa(id) {
        if (confirm('Bạn có chắc chắn xóa coupon này?') == true) {
            window.location = 'index.php?DS=Del_Coupon&id='+id;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách Coupon</h3>
    </div>
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Sale OFF</th>
                    <th>Giá trị ĐH tối thiểu</th>
                    <th>Type</th>
                    <th>Công cụ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_coupon = mysqli_query($conn, "SELECT id, code, sale_off, type,min_price FROM coupon");
                while ($x = mysqli_fetch_assoc($get_coupon)) {
                    $id = $x['id'];
                    $update = "<a href='index.php?DS=Update_Coupon&id=$id' class='btn btn-info'>Cập nhật </a>";
                    $type = 'Tất cả';
                    ?>
                    <tr style="font-weight: bold">
                        <td><?php echo $x['id']; ?></td>
                        <td><?php echo $x['code']; ?></td>
                        <td><?php echo $x['sale_off']; ?> %</td>
                        <td><?php echo number_format($x['min_price']); ?> VNĐ</td>
                        <td><?php echo $type; ?></td>
                        <td style="text-align:center">
                            <?php echo $update; ?> <a href="#" onclick="xoa(<?php echo $id; ?>);" class="btn btn-danger">Xóa</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>