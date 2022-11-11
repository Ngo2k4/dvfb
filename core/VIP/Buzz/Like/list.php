<script>
    function xoa(id){
        if(confirm('Bạn có chắc chắn muốn xóa ID này???') == true){
            window.location = 'index.php?DS=Delete_Buzz_Like&id='+id;
        }else{
            return false;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách ID VIP Buzz Like</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Post ID</th>
                    <th>Loại CX</th>
                    <th>Số Like mua</th>
                    <th>Tốc độ</th>
                    <th>Like đã tăng</th>
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
                    $get_buzz = mysqli_query($conn, "SELECT id, post_id, likes, max_like, liked, type, pay FROM buzz_like WHERE id_ctv = $idctv");
                }else{
                    $get_buzz = mysqli_query($conn, "SELECT buzz_like.id, buzz_like.post_id, buzz_like.likes, buzz_like.max_like, buzz_like.liked, buzz_like.type, buzz_like.pay, member.rule, member.user_name, member.name FROM buzz_like INNER JOIN member ON buzz_like.id_ctv = member.id_ctv");
                }
                while ($x = mysqli_fetch_assoc($get_buzz)) {
                    // cột loại CX
                    $type = $x['type'];
                    if(strpos($type, "\n", 0)){
                        $type = str_replace("\n", "-", $x['type']);
                        $type = str_replace(array('LIKE', 'HAHA', 'LOVE', 'WOW', 'SAD', 'ANGRY'), array('L', 'H', 'LV', 'W', 'S', 'A'), $type);
                    }
                    
                    // cột trạng thái
                    $tt = "<font color=green>Đang chạy</font>";
                    if($x['liked'] >= $x['max_like']){
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
                        <td><?= $type; ?></td>
                        <td><?= $x['max_like']; ?> Like</td>
                        <td><?= $x['likes']; ?> CX/Cron</td>
                        <td><?php echo $x['liked']; ?> Like</td>
                        <td><?= number_format($x['pay']); ?> VNĐ</td>
                        <td><?= $tt; ?></td>
                        <?php if ($rule == 'admin') echo "<td>$ctv_name ({$x['user_name']} - $rl )</td>"; ?>
                        <td style="text-align:center"><a class="btn btn-info" href="index.php?DS=Update_Buzz_Like&id=<?= $x['id']; ?>">Cập nhật</a> <a onclick="xoa(<?= $x['id']; ?>)" class="btn btn-danger" href="javascript:void(0)">Xóa</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>