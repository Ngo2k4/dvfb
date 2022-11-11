<ul class="nav nav-tabs">
                            <li class="active">
                                <a  href="#like" data-toggle="tab">VIP Cảm Xúc</a>
                            </li>
                            <li><a href="#cmt" data-toggle="tab">VIP CMT</a>
                            </li>
                            <li><a href="#reaction" data-toggle="tab">VIP BOT Cảm Xúc</a>
                            </li>
                            <!--<li><a href="#share" data-toggle="tab">VIP Share</a>-->
                            <!--</li>-->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="like">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Tối đa</th>
                                            <th>Tốc độ</th>
                                            <th>Loại CX</th>
                                            <th>Giới hạn bài viết</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>

                                        </tr>
<?php
$like = "SELECT max, price FROM package WHERE type='LIKE' AND max <= 800 ORDER BY price ASC";
$r_like = mysqli_query($conn, $like);
while ($x = mysqli_fetch_assoc($r_like)) {
    $member = $x['price'];
    $agency = $x['price'] - $x['price'] * 10 / 100;
    $ctv = $x['price'] - $x['price'] * 5 / 100;
    $range = $x['max'] . ' ~  '.($x['max']+=$x['max']*20/100);
    ?>
                                            <tr style="font-weight: bold">
                                                <td><?php echo $range . ' CX'; ?></td>
                                                <td>Tùy chỉnh</td>
                                                <td>Tùy chọn</td>
                                                <td>Không giới hạn</td>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
<?php } ?>
                                    </table>
                                    <blockquote>Hệ thống luôn tăng thêm số lượng VIP Cảm xúc lên tối đa <code>~20-30</code></blockquote>
                                </div>
                            </div>

                            <div class="tab-pane" id="cmt">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Tối đa</th>
                                            <th>Tốc độ</th>
                                            <th>Giới hạn bài viết</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>
                                        </tr>
<?php
$cmt = "SELECT max, price FROM package WHERE type='CMT'AND max <= 100 ORDER BY price ASC";
$r_cmt = mysqli_query($conn, $cmt);
while ($x = mysqli_fetch_assoc($r_cmt)) {
    $member = $x['price'];
    $agency = $x['price'] - $x['price'] * 10 / 100;
    $ctv = $x['price'] - $x['price'] * 5 / 100;
    ?>
                                            <tr style="font-weight: bold">
                                                <td><?php echo $x['max'] . ' CMT'; ?></td>
                                                <td>Tùy chỉnh</td>
                                                <td>Không giới hạn</td>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
<?php } ?>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="reaction">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="color:red">
                                            <th>Tối đa</th>
                                            <th>Loại Cảm Xúc</th>
                                            <th>Giới hạn bảng tin</th>
                                            <th>Giá(Member <font color="red">*</font>)</th>
                                            <th>Giá (CTV <font color="red">**</font>)</th>
                                            <th>Giá (Đại Lí <font color="red">***</font>)</th>
                                        </tr>
<?php
$react = "SELECT max, price FROM package WHERE type='REACTION' ORDER BY price ASC";
$r_react = mysqli_query($conn, $react);
while ($x = mysqli_fetch_assoc($r_react)) {
    $member = $x['price'];
    $agency = $x['price'] - $x['price'] * 10 / 100;
    $ctv = $x['price'] - $x['price'] * 5 / 100;
    ?>
                                            <tr style="font-weight: bold">
                                                <td>Automatic Detect</td>
                                                <td><?php echo "Tùy chọn"; ?></td>
                                                <th>Không giới hạn</th>
                                                <td><?php echo number_format($member) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($ctv) . ' VNĐ / Tháng'; ?></td>
                                                <td><?php echo number_format($agency) . ' VNĐ / Tháng'; ?></td>
                                            </tr>
<?php } ?>
                                    </table>
                                </div>
                            </div>

                            <!--<div class="tab-pane" id="share">-->
                            <!--    <div class="table-responsive">-->
                            <!--        <table class="table table-bordered">-->
                            <!--            <tr style="color:red">-->
                            <!--                <th>Max Share</th>-->
                            <!--                <th>Tốc độ</th>-->
                            <!--                <th>Limit Post</th>-->
                            <!--                <th>Giá(Member <font color="red">*</font>)</th>-->
                            <!--                <th>Giá (CTV <font color="red">**</font>)</th>-->
                            <!--                <th>Giá (Đại Lí <font color="red">***</font>)</th>-->
                            <!--            </tr>-->
<?php
// <!--            $react = "SELECT max, price FROM package WHERE type='SHARE' AND max <= 500 ORDER BY price ASC";-->
// <!--            $r_react = mysqli_query($conn, $react);-->
// <!--            while ($x = mysqli_fetch_assoc($r_react)) {-->
// <!--                $member = $x['price'];-->
// <!--                $agency = $x['price'] - $x['price'] * 20 / 100;-->
// <!--                $ctv = $x['price'] - $x['price'] * 10 / 100;-->
?>
                            <!--                <tr style="font-weight: bold">-->
                            <!--                    <td><?php //echo $x['max'] . ' Share'; ?></td>-->
                            <!--                    <td>Tùy chỉnh</td>-->
                            <!--                    <td>Không giới hạn</td>-->
                            <!--                    <td><?php //echo number_format($member) . ' VNĐ / Tháng';  ?></td>-->
                            <!--                    <td><?php //echo number_format($ctv) . ' VNĐ / Tháng';  ?></td>-->
                            <!--                    <td><?php //echo number_format($agency) . ' VNĐ / Tháng';  ?></td>-->
                            <!--                </tr>-->
<?php //}  ?>
                            <!--        </table>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <p>
                            <font color="red">(*)</font>: Giá này được áp dụng khi bạn là <b>Member thường </b>trên hệ thống<br />
                            <font color="red">(**)</font>: Giá này được áp dụng khi bạn là <b>Cộng tác viên</b> của hệ thống (Min 300K - 500K )</b><br />
                            <font color="red">(***)</font>: Giá này được áp dụng khi bạn là <b>Đại Lí</b> của hệ thống ( Min 1 - 3 triệu )</b><br />
                            <b>Tất cả đều được hệ thống <font color="red">Tự động giảm</font> khi Thêm VIP ID!<br />Nếu bạn muốn mua các <font color="red">gói Like, CMT, Share, Reaction</font> với <font color="red">số lượng</font> và <font color="red">thời hạn</font> khác tùy chọn, liên hệ Admin để trao đổi và được hỗ trợ!</b><br />
                            <b>Chú ý: Bảng giá trên được áp dụng với <font color="red">số dư tài khoản của bạn trên hệ thống</font>. Xem chi tiết cách thức nạp tiền click <a href="nap-tien.html" target="_blank"><font color="red">Vào đây</font></a></b>
                        </p>