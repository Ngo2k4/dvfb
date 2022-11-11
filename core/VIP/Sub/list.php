<script>
    function check(id) {
        if (confirm('Bạn có chắc chắn muốn xóa VIP ID này ?') == true) {
            window.location = 'index.php?DS=Del_Sub&id=' + id;
        } else {
            return false;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách ID VIP Sub - Tự động xóa khi Hoàn thành</h3>
    </div>
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Tên</th>
                    <th style="color:violet">Số Sub mua</th>
                    <th style="color:green">Sub đã tăng</th>
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
                if ($rule != 'admin') {
                    $get = "SELECT id, name, user_id, subs, max_sub, delay FROM vipsub WHERE id_ctv=$idctv";
                } else {
                    $get = "SELECT vipsub.id,vipsub.name, vipsub.user_id, vipsub.subs, vipsub.max_sub, vipsub.delay, member.name AS ctv_name,member.user_name,member.rule FROM vipsub INNER JOIN member ON vipsub.id_ctv = member.id_ctv";
                }
                $result = mysqli_query($conn, $get);
                while ($x = mysqli_fetch_assoc($result)) {
                    // $checksub = json_decode(file_get_contents('https://graph.fb.me/' . $x['user_id'] . '/subscribers?access_token=' . $tokenx . '&method=get'), true);
                    // $cur_sub = $checksub['summary']['total_count'];
                    // $subed = $cur_sub - $x['current_sub'];
                    if ($x['subs'] >= $x['max_sub']) {
                        $tt = "<font color='green'>Hoàn thành</font>";
                    } else {
                        $tt = "<font color='blue'>Đang chạy</font>";
                    }
                    $rl = '';
                    if (isset($x['rule']) && $x['rule'] == 'member') {
                        $rl = '<font color="blue">Member</font>';
                    } else if (isset($x['rule']) && $x['rule'] == 'agency') {
                        $rl = '<font color="violet">Đại lí</font>';
                    } else if (isset($x['rule']) && $x['rule'] == 'freelancer') {
                        $rl = '<font color="blue">Cộng tác viên</font>';
                    } else {
                        $rl = '<font color="red">Admin</font>';
                    }
                    $id = $x['id'];
                    $handle = '';
                    $ctv_name = '';
                    if (isset($x['ctv_name'])) {
                        $ctv_name = $x['ctv_name'];
                    }
                    if ($rule == 'admin') {
                        $handle = " <a onClick='check($id);' class='btn btn-danger'>Xóa</a>";
                    } else {
                        $handle = "<a onClick='check($id);' class='btn btn-danger'>Xóa</a>";
                    }
                    $sub_buy = $x['max_sub'] - $x['current_sub'];
                    ?>
                    <tr style="font-weight: bold">
                        <td><?php echo $x['id']; ?></td>
                        <td><a href="//fb.com/<?php echo $x['user_id']; ?>" target="_blank"><?php echo $x['user_id']; ?></a></td>
                        <td><?php echo $x['name']; ?></td>
                        <td><?php echo $x['max_sub']; ?> Sub</td>
                        <td><?php echo $x['subs']; ?> Sub</td>
                        <td><?= $tt; ?></td>
                        <?php if ($rule == 'admin') echo "<td>$ctv_name ({$x['user_name']} - $rl )</td>"; ?>
                        <td style="text-align:center"><?php echo $handle; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>