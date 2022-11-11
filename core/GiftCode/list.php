<?php
if ($rule != 'admin' && $rule != 'agency') {
     header('Location: /trang-chu.html');
}
?>
<script>
    function check(id, stt) {
        if (stt == 0) {
            if (confirm('Code này vẫn chưa được sử dụng, Nếu xóa bạn sẽ vẫn không được cộng lại tiền đã tạo gift.Bạn có chắc chắn xóa?') == true) {
                window.location = 'index.php?DS=Delete_GiftCode&id_gift=' + id;
            }
        }
        else if (confirm('Bạn có chắc chắn muốn xóa gift code này?') == true) {
            window.location = 'index.php?DS=Delete_GiftCode&id_gift=' + id;
        } else {
            return false;
        }
    }
    function xoa(){
        if (confirm('Bạn có chắc chắn xóa hết giftcode?') == true) {
                window.location = 'index.php?DS=Delete_GiftCode';
            }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách GIFT CODE | <?php if($rule == 'admin' || $rule =='agency'){ ?><a class="btn btn-danger" onclick="xoa()">Xóa tất cả</a> <a class="btn btn-info" onclick="showGift()">Copy List Gift Code</a> <?php }?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Billing</th>
                    <th>Trạng thái</th>
                    <?php if ($rule == 'admin') { ?><th>Người thêm</th><?php } ?>
                    <th>Công cụ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rule == 'admin') {
                    $get = "SELECT gift.id, gift.code, billing, gift.status, member.name, user_name FROM gift INNER JOIN member ON member.id_ctv = gift.id_ctv";
                } else {
                    $get = "SELECT gift.id, gift.code, billing, gift.status, member.name, user_name FROM gift INNER JOIN member ON member.id_ctv = gift.id_ctv WHERE member.id_ctv=$idctv";
                }
                $result = mysqli_query($conn, $get);
                while ($x = mysqli_fetch_assoc($result)) {
                    $id = $x['id'];
                    $status = $x['status'];
                    $z = '';
                    if ($status == 0) {
                        $z = "<a href='index.php?DS=Edit_GiftCode&id_gift=$id' class='btn btn-info'>Cập nhật </a>";
                        $tt = '<font color="green">Chưa được sử dụng</font>';
                    } else if ($status == 1) {
                        $z = '';
                        $tt = '<font color="red">Đã được sử dụng</font>';
                    }
                    ?>
                    <tr style="font-weight: bold">
                        <td><?php echo $x['id']; ?></td>
                        <td><?php echo $x['code']; ?></td>
                        <td><?php echo number_format($x['billing']); ?> VNĐ</td>
                        <td><?php echo $tt; ?></td>
                        <?php if ($rule == 'admin') { ?><td><?php echo "{$x['user_name']} ( {$x['name']} )"; ?><?php } ?>
                        <td style="text-align:center">
                            <?php echo $z; ?> <a href="#" onclick="check(<?php echo $id . ',' . $status; ?>);" class="btn btn-danger">Xóa</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="id" value="<?php echo $idctv; ?>" />
<textarea id="gift" class="form-control" rows="20" style="display:none"></textarea>
<script>
function showGift(){
    $.post('core/GiftCode/show.php', { id : $('#id').val() }, function(result){$('#gift').val(result);$('#gift').show();});
}
</script>