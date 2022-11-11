<?php
if (isset($_POST['submit'])) {
    $sub = $_POST['sub'];
    if ($sub >= 100) {
        $price = $sub * 15;
        if($rule != 'freelancer'){
            $get = mysqli_query($conn, "SELECT bill FROM member WHERE id_ctv = $idctv");
        }else{
            $get = mysqli_query($conn, "SELECT bill FROM ctv WHERE id_ctvs = $idctv");
        }
        $x = mysqli_fetch_assoc($get);
        if ($x['bill'] - $price >= 0) {
            if($rule != 'freelancer'){
                $minus = mysqli_query($conn, "UPDATE member SET num_sub = num_sub + $sub, bill = bill - $price, payment = payment+$price WHERE id_ctv=$idctv");
            }else{
                $minus = mysqli_query($conn, "UPDATE ctv SET num_sub = num_sub + $sub, bill = bill - $price, payment = payment+$price WHERE id_ctvs=$idctv");
            }
            if ($minus) {
                $content = "<b>$uname</b> vừa mua <b>$sub</b> sub. Tổng thanh toán <b>" . number_format($price) . " VNĐ</b>";
                $time = time();
                $his = mysqli_query($conn, "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)");
                if ($his) {
                    echo "<script>alert('Mua thành công!!!');window.location='them-sub.html';</script>";
                }
            }
        } else {
            echo "<script>alert('Không đủ tiền');window.location='mua-sub.html';</script>";
        }
    } else {
        echo "<script>alert('Số sub mua tối thiểu >= 100');window.location='mua-sub.html';</script>";
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Mua Subscribers</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="sub" class="col-sm-2 control-label">Nhập số sub muốn mua:</label>

                        <div class="col-sm-10">
                            <input type="number" name="sub" id="sub" onchange="tinh();" onkeyup="tinh();" class="form-control" placeholder="Nhập số sub muốn mua" min="1"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Thành tiền:</label>

                        <div class="col-sm-10">
                            <span style="background:red;color:yellow;font-size:17px" id="price">0 VNĐ</span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function tinh() {
        var sub = $('#sub').val();
        if (sub > 0) {
            price = sub * 15;
            var x = price.toFixed(0).replace(/./g, function (c, i, a) {
                return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
            });
            $('#price').html(x + ' VNĐ');
        }
    }
</script>