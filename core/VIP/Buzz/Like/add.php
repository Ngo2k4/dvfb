<?php $rate = 30; ?>
<script src="plugins/iCheck/icheck.min.js"></script>
<link rel="stylesheet" href="plugins/iCheck/all.css">
<script>
    function _Like() {
        var like = $('#max_like').val();
        if (like >= 10) {
            var price = like * <?= $rate; ?>;
            var x = price.toFixed(0).replace(/./g, function (c, i, a) {
                return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
            });
            $('#result').html(x + ' VNĐ');
        } else {
            alert('Mua tối thiểu 10 Like');
            $('#max_like').val('10');
        }
    }
</script>
<?php
if (isset($_POST['submit'])) {
    $post_id = htmlspecialchars(addslashes($_POST['post_id']));
    $checkne = json_decode(file_get_contents('https://graph.fb.me/' . $post_id . '?access_token=' . $tokenx), true);
    $likes = intval($_POST['likes']);
    $max_like = intval($_POST['max_like']);
    $price = $rate * $max_like;
    $checkid = mysqli_query($conn, "SELECT COUNT(post_id) FROM buzz_like WHERE post_id='$post_id'");
    $check = mysqli_fetch_assoc($checkid);
    $loi = array();
    if ($checkne['category']) {
        $loi['page'] = 'Không thể sử dụng ID Page';
    }
    if (!isset($_POST['type'])) {
        $loi['type'] = 'Vui lòng chọn ít nhất 1 loại cảm xúc';
    }
    if ($check['COUNT(post_id)'] == 1) {
        $loi['exists'] = 'Đã tồn tại Post ID này trên hệ thống';
    }
    if (empty($loi)) {
        if ($rule != 'freelancer') {
            $check_bill = mysqli_query($conn, "SELECT bill FROM member WHERE id_ctv=$idctv");
        } else {
            $check_bill = mysqli_query($conn, "SELECT bill FROM ctv WHERE id_ctvs=$idctv");
        }
        $bill = mysqli_fetch_assoc($check_bill)['bill'];
        if ($bill - $price >= 0) {
            if ($max_like >= 10 && $max_like <= 1000) {
                if ($likes <= $max_like) {
                    $list_type = $_POST['type'];
                    $type = implode("\n", $list_type);
                    echo $ins = mysqli_query($conn, "INSERT INTO buzz_like(post_id, likes, max_like, type, pay, id_ctv, liked) VALUES('$post_id','$likes','$max_like','$type','$price',$idctv, 0)");
                    if ($ins) {
                        if ($rule != 'freelancer') {
                            $up = mysqli_query($conn, "UPDATE member SET bill = bill - $price, payment = payment + $price WHERE id_ctv=$idctv");
                        }else{
                            $up = mysqli_query($conn, "UPDATE ctv SET bill = bill - $price, payment = payment + $price WHERE id_ctvs=$idctv");
                        }
                        if ($up) {
                            $content = "<b>$uname</b> vừa thêm VIP Buzz <b>$max_like</b> Like cho Post ID <b>$post_id</b>. Tổng thanh toán: <b>" . number_format($price) . "</b> VNĐ";
                            $time = time();
                            $his = mysqli_query($conn, "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)");
                            if ($his) {
                                //echo "<script>alert('Thêm thành công!!!');window.location='buzz-like.html';</script>";
                            }
                        }
                    }
                } else {
                    echo "<script>alert('Likes/Cron phải <= Max Like nha !!');window.location='them-buzz-like.html';</script>";
                }
            } else {
                echo "<script>alert('Tối thiểu 10 Likes, tối đa 1000 Like!');window.location='them-buzz-like.html';</script>";
            }
        } else {
            echo "<script>alert('Không đủ tiền rùi, nạp thêm đi nha');window.location='them-buzz-like.html';</script>";
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm ID VIP Buzz Like</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Post ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập PostID cần tăng Like/Cảm xúc"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo isset($_POST['post_id']) ? $_POST['post_id'] : ''; ?>" id="post_id" name="post_id" placeholder="Post ID" required>
                            <?php echo isset($loi['exists']) ? $loi['exists'] : ''; ?>
                            <?php echo isset($loi['page']) ? $loi['page'] : ''; ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="likes" class="col-sm-2 control-label">Số CX / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng cảm xúc tăng sau mỗi lần chạy!"></span></label>

                        <div class="col-sm-10">
                            <select name="likes" class="form-control">
                                <option value="10">10 CX/Cron</option>
                                <option value="30">30 CX/Cron</option>
                                <option value="50">50 CX/Cron</option>
                                <option value="100">100 CX/Cron</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Số Like/CX cần tăng: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số Like/CX cần tăng"></span></label>

                        <div class="col-sm-10">
                            <input name="max_like" id="max_like" class="form-control" placeholder="Nhập max like/cx cần tăng" onblur="_Like()" type="number" value="10" min="10" max="1000"/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label">Loại: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Chọn các loại cảm xúc cần tăng ch bài viết của bạn"></span></label>
                        <div class="col-sm-10">
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="LIKE" class="flat-red" checked> <img src="core/VIP/LIKE/icon/like.png" style="width:24px" data-toggle="tooltip" title="Thích"/>
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="LOVE" class="flat-red"> <img src="core/VIP/LIKE/icon/love.png" style="width:24px" data-toggle="tooltip" title="Yêu Thích" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="HAHA" class="flat-red"> <img src="core/VIP/LIKE/icon/haha.png" style="width:24px" data-toggle="tooltip" title="Cười lớn" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="WOW" class="flat-red"> <img src="core/VIP/LIKE/icon/wow.png" style="width:24px" data-toggle="tooltip" title="Ngạc nhiên" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="SAD" class="flat-red"> <img src="core/VIP/LIKE/icon/sad.png" style="width:24px" data-toggle="tooltip" title="Buồn" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="ANGRY" class="flat-red"> <img src="core/VIP/LIKE/icon/angry.png" style="width:24px" data-toggle="tooltip" title="Phẫn nộ" />
                            </label><br />
                            <?php echo isset($loi['type']) ? $loi['type'] : ''; ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Thành tiền: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Tổng số tiền cần thanh toán!"></span></label>

                        <div class="col-sm-10">
                            <span style="background:red; color:yellow" class="h4" id="result"><script>_Like();</script></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('input[type="checkbox"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    });
</script>

