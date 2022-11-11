<script>
    function xoa(id){
        if(confirm('Bạn có chắc chắn muốn xóa ID này???') == true){
            window.location = 'index.php?DS=Delete_Buzz_CMT&id='+id;
        }else{
            return false;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách ID VIP Buzz CMT - Tự động xóa sau khi hoàn thành</h3>
    </div>
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Post ID</th>
                    <th>Số CMT mua</th>
                    <th>Tốc độ</th>
                    <th>CMT đã tăng</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <?php
                    if ($rule == 'admin') {
                        echo '<th>Người thêm</th>';
                    }
                    ?>
                    <th>Công cụ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($rule != 'admin'){
                    $get_buzz = mysqli_query($conn, "SELECT id, post_id, cmts, max_cmt, commented, pay FROM buzz_cmt WHERE id_ctv = $idctv");
                }else{
                    $get_buzz = mysqli_query($conn, "SELECT buzz_cmt.id, buzz_cmt.post_id, buzz_cmt.cmts, buzz_cmt.max_cmt, buzz_cmt.commented, buzz_cmt.pay, member.rule, member.user_name, member.name FROM buzz_cmt INNER JOIN member ON buzz_cmt.id_ctv = member.id_ctv");
                }
                while ($x = mysqli_fetch_assoc($get_buzz)) {
                    // cột trạng thái
                    $tt = "<font color=green>Đang chạy</font>";
                    if($x['commented'] >= $x['max_cmt']){
                        $tt = "<font color=red>Đã hoàn thành</font>";
                    }
                    
                    // cột người thêm (chỉ dành cho admin)
                    if($rule == 'admin'){
                        $ctv_name = $x['name'];
                        $rl = "<font color=black>Thành viên</font>";
                        if($x['rule'] == 'admin'){
                            $rl = "<font color=red>Quản trị viên</font>";
                        }else if($x['rule'] == 'agency'){
                            $rl = "<font color=violet>Đại lí</font>";
                        }else if($x['rule'] == 'freelancer'){
                            $rl = "<font color=blue>Cộng tác viên</font>";
                        }
                    }
                    
                    // cột công cụ
                    
                    ?>
                    <tr style="font-weight: bold">
                        <td><?php echo $x['id']; ?></td>
                        <td><a href="//fb.com/<?php echo $x['post_id']; ?>" target="_blank"><?php echo $x['post_id']; ?></a></td>
                        <td><?= $x['max_cmt']; ?> CMT</td>
                        <td><?= $x['cmts']; ?> CMT/Cron</td>
                        <td><?php echo $x['commented']; ?> CMT</td>
                        <td><?= number_format($x['pay']); ?> VNĐ</td>
                        <td><?= $tt; ?></td>
                        <?php if ($rule == 'admin') echo "<td>$ctv_name ({$x['user_name']} - $rl )</td>"; ?>
                        <td style="text-align:center"><a class="btn btn-info" href="index.php?DS=Update_Buzz_CMT&id=<?= $x['id']; ?>">Cập nhật</a> <a onclick="xoa(<?= $x['id']; ?>)" class="btn btn-danger" href="javascript:void(0)">Xóa</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>