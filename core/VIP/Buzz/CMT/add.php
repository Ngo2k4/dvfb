<?php $rate = 50; ?>
<script>
    function _CMT() {
        var cmt = $('#max_cmt').val();
        if (cmt >= 5) {
            var price = cmt * <?= $rate; ?>;
            var x = price.toFixed(0).replace(/./g, function (c, i, a) {
                return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
            });
            $('#result').html(x + ' VNĐ');
        }else{
            alert('Mua tối thiểu 5 comment!!!');
            $('#max_cmt').val('5');
        }
    }
</script>
<?php
    if(isset($_POST['submit'])){
        $cmts = intval($_POST['cmts']);
        $post_id = htmlspecialchars(addslashes($_POST['post_id']));
        $max_cmt = intval($_POST['max_cmt']);
        $price = $rate * $max_cmt;
        $noi_dung = htmlspecialchars(addslashes($_POST['noi_dung']));
        $checkid = mysqli_query($conn, "SELECT COUNT(post_id) FROM buzz_cmt WHERE post_id='$post_id'");
        $check = mysqli_fetch_assoc($checkid);
        $loi = array();
        if($check['COUNT(post_id)'] == 1){
            $loi['exists'] = 'Đã tồn tại Post ID này trên hệ thống';
        }
        if(empty($loi)){
            if($rule != 'freelancer'){
                $check_bill = mysqli_query($conn, "SELECT bill FROM member WHERE id_ctv=$idctv");
            }else{
                $check_bill = mysqli_query($conn, "SELECT bill FROM ctv WHERE id_ctvs=$idctv");
            }
            $bill = mysqli_fetch_assoc($check_bill)['bill'];
            if($bill - $price >= 0){
                if($max_cmt >= 5 && $max_cmt <= 1000){
                    if($cmts >= 1 && $cmts <= 20 && $cmts <= $max_cmt){
                        $ins = mysqli_query($conn, "INSERT INTO buzz_cmt(post_id, cmts, max_cmt, noi_dung, pay, id_ctv, commented) VALUES('$post_id','$cmts','$max_cmt','$noi_dung','$price',$idctv, 0)");
                        if($ins){
                            if($rule != 'freelancer'){
                                $up = mysqli_query($conn, "UPDATE member SET bill = bill - $price, payment = payment + $price WHERE id_ctv=$idctv");
                            }else{
                                $up = mysqli_query($conn, "UPDATE ctv SET bill = bill - $price, payment = payment + $price WHERE id_ctvs=$idctv");
                            }
                            if($up){
                                $content = "<b>$uname</b> vừa thêm VIP Buzz <b>$max_cmt</b> CMT cho Post ID <b>$post_id</b>. Tổng thanh toán: <b>".number_format($price)."</b> VNĐ";
                                $time = time();
                                $his = mysqli_query($conn, "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)");
                                if($his){
                                    echo "<script>alert('Thêm thành công!!!');window.location='buzz-cmt.html';</script>";
                                }
                            }
                        }
                    }else{
                        echo "<script>alert('CMT/Cron phải hợp lệ và <= Max CMT nha !!');window.location='them-buzz-cmt.html';</script>";
                    }
                }else{
                    echo "<script>alert('Tối thiểu 5 CMT, tối đa 1000 CMT!');window.location='them-buzz-cmt.html';</script>";
                }
            }else{
                echo "<script>alert('Không đủ tiền rùi, nạp thêm đi nha');window.location='them-buzz-cmt.html';</script>";
            }
        }
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm ID VIP Buzz Comment</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Post ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập PostID cần tăng Comment"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo isset($_POST['post_id']) ? $_POST['post_id'] : ''; ?>" id="post_id" name="post_id" placeholder="Post ID" required>
                            <?php echo isset($loi['exists']) ? $loi['exists'] : ''; ?>
                        </div>
                    </div>

                
                    <div class="form-group">
                        <label for="cmts" class="col-sm-2 control-label">Số CMT / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng comment tăng sau mỗi lần chạy!"></span></label>

                        <div class="col-sm-10">
                            <select name="cmts" class="form-control">
                                <?php for($i=1; $i<=20; $i++){ ?>
                                    <option value="<?= $i; ?>"><?= $i; ?> CMT/Cron</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Số Comments cần tăng: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số Comments cần tăng"></span></label>

                        <div class="col-sm-10">
                            <input name="max_cmt" id="max_cmt" class="form-control" placeholder="Nhập Max số Comment cần tăng" onblur="_CMT()" type="number" value="5" min="5" max="1000"/>

                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Nội dung CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập nội dung comment, mỗi nội dung khác nhau cách nhau 1 dòng"></span></label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" placeholder="Nhập nội dung comment, mỗi dòng là 1 nội dung khác nhau" name="noi_dung"><?= isset($_POST['noi_dung']) ? $_POST['noi_dung'] : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Thành tiền: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Tổng số tiền cần thanh toán!"></span></label>

                        <div class="col-sm-10">
                            <span style="background:red; color:yellow" class="h4" id="result"><script>_CMT();</script></span>
                                            <hr />
                            <kbd>
                                - Post ID phải để ở chế độ Công khai ( Mọi người có thể bình luận )<br />
                                - Nhập chính xác Post ID, chúng tôi không chịu trách nhiệm  khi VIP không thể chạy vì  bạn nhập sai Post ID!<br />
                                - Các bạn có thể cập nhật lại sau khi thêm nên đừng lo lắng :d<br />
                                - Một số kí tự đặc biệt trong nội dung có thể không cài đặt được<br />
                                - Mua tối thiểu 5 CMT, tối đa 1000 CMT <br />
                                - Đang update thêm các tính năng khác !!!
                            </kbd>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm VIP Buzz CMT</button>
                </div>
            </form>
        </div>
    </div>
</div>
