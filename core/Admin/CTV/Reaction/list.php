<?php
    if($rule != 'admin' && $rule != 'agency'){
        echo "<script>alert('CÚT');window.location='trang-chu.html';</script>";
    }
?>
<script>
    function check(id) {
        if (confirm('Bạn có chắc chắn muốn xóa VIP ID này ?') == true) {
            window.location = 'index.php?DS=CTV_Delete_Reaction&id_react=' + id;
        } else {
            return false;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách ID VIP Reaction - Cộng tác viên</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Tên</th>
                    <th>Thời hạn</th>
                    <th>Reactions / Cron</th>
                    <th>Type</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Còn lại</th>
                    <th>Người thêm</th>
                    <th>Công cụ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rule != 'admin') {
                    $get = "SELECT vipreaction.id,user_id, vipreaction.name as name1, han, type, limit_react, start, end, pay,ctv.name as name2,ctv.user_name FROM vipreaction INNER JOIN ctv ON ctv.id_ctvs = vipreaction.id_ctv WHERE ctv.id_agency=$idctv";
                } else {
                    $get = "SELECT vipreaction.id,user_id, vipreaction.name as name1, han, type, limit_react, start, end, pay,ctv.name as name2,ctv.user_name FROM vipreaction INNER JOIN ctv ON ctv.id_ctvs = vipreaction.id_ctv ";
                }
                $result = mysqli_query($conn, $get);
                while ($x = mysqli_fetch_assoc($result)) {
                    $z = $x['end'] - time();
                    $id = $x['id'];
                    $ngay = date('z',$z);
                    $gio = date('H',$z);
                    if($z <= 0 ){
                        $conlai = '<font color=red>Đã hết hạn</font>';
                    }else if($ngay > 0){
                        $conlai = date('z \N\g\à\y H \g\i\ờ i \p\h\ú\t', $z);
                    }else if($ngay == 0 && $gio > 0){
                        $conlai = date('H \g\i\ờ i \p\h\ú\t', $z);
                    }else if($ngay == 0 && $gio == 0){
                        $conlai = date('i \p\h\ú\t', $z);
                    }
                    $handle = '';
                    if (isset($x['name2'])) {
                        $ctv_name = $x['name2'];
                    }
                    if ($rule == 'admin' || $rule == 'agency') {
                        if ($x['end'] >= time()) {
                            $handle = "<a href='index.php?DS=CTV_Update_Reaction&id=$id' class='btn btn-info'>Cập nhật</a> <a onClick='check($id);' class='btn btn-danger'>Xóa</a>";
                        }else{
                            $handle = "<a onClick='check($id);' class='btn btn-danger'>Xóa</a>";
                        }
                    } else {
                        if ($x['end'] >= time()) {
                            $handle = "<a href='index.php?DS=CTV_Update_Reaction&id=$id' class='btn btn-info'>Cập nhật</a>";
                        } else {
                            $handle = "<a onClick='check($id);' class='btn btn-danger'>Xóa</a>";
                        }
                    }
                    $tt = '<font color=green>Hoạt động</font>';
                    if($z <= 0){
                        $tt = '<font color=red>Tạm dừng</font>';
                    }else if($ngay <= 5){
                        $tt = '<font color=red>Sắp hết hạn</font>';
                    }
                    ?>
                    <tr style="font-weight: bold">
                        <td><?php echo $x['id']; ?></td>
                        <td><a href="//fb.com/<?php echo $x['user_id']; ?>" target="_blank"><?php echo $x['user_id']; ?></a></td>
                        <td><?php echo $x['name1']; ?></td>
                        <td><?php echo $han; ?> tháng</td>
                        <td><?php echo $x['limit_react']; ?> Reaction</td>
                        <td><?php echo $x['type']; ?></td>
                        <td><?php echo $tt; ?></td>
                        <td><?php echo number_format($x['pay']); ?> VNĐ</td>
                        <td><?php echo $conlai; ?> </td>
                    <?php if (isset($ctv_name)) echo "<td>$ctv_name ( {$x['user_name']} ) </td>"; ?>
                        <td style="text-align:center"><?php echo $handle; ?></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>