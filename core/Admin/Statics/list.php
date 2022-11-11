<?php if($rule != 'admin'){
    header('Location: index.php');
}
?>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Thống kê doanh thu tháng <?php echo date('m/Y'); ?> </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <ul class="nav nav-tabs">
        <li class="active">
            <a  href="#ok0" data-toggle="tab">Admin</a>
        </li>
        <li><a href="#ok1" data-toggle="tab">Cộng tác viên không vốn</a>
        </li>
    </ul>
    <div class="tab-content">
    <div class="tab pane active" id="ok0">
    <div class="table-responsive">
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Admin</th>
                        <th>User Name</th>
                        <th>ID Facebook</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Doanh Thu Tháng <?php echo date('m/Y'); ?></th>
                        <?php if($idctv == 1) {?><th>Thao tác</th> <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getvip = "SELECT id_ctv, name, user_name, profile, num_id, payment, email, phone FROM member WHERE rule = 'admin' AND id_ctv != 1 AND id_ctv != -69";
                    $result = mysqli_query($conn, $getvip);
                    while ($x = mysqli_fetch_assoc($result)) {
                            $id = $x['id_ctv'];
                            $name = $x['name'];
                            $u_name = $x['user_name'];
                            $idfb = $x['profile'];
                            $num = $x['num_id'];
                            $pay = $x['payment'];
                            $email = $x['email'];
                            $phone = $x['phone'];
                        ?>
                        <tr style="font-weight: bold">
                            <td><?php echo $id; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $u_name; ?></td>
                            <td><?php echo $idfb; ?> </td>
                            <td><?php echo $email; ?> </td>
                            <td><?php echo $phone; ?> </td>
                        
                            <td style="color:red"><?php echo number_format($pay). ' VNĐ'; ?></td>
                            <?php if($idctv == 1){ ?> <td><a href="index.php?DS=Reset_Statics&id=<?php echo $id; ?>" class="btn btn-danger">Reset</a> <a href="index.php?DS=Update_Statics&id=<?php echo $id; ?>" class="btn btn-info">Cập nhật</a></td><?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
            </div>
        <div class="tab-pane" id="ok1">
            <div class="table-responsive">
            <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên CTV</th>
                        <th>User Name</th>
                        <th>ID Facebook</th>
                        <th>Email</th>
                        <th>Phone</th>
                    
                        <th>Doanh Thu Tháng <?php echo date('m/Y'); ?></th>
                        <?php if($idctv == 1) {?><th>Thao tác</th> <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getvip = "SELECT id_ctvs, name, user_name, profile, num_id, payment, email, phone FROM ctv WHERE id_agency = -1 AND id_ctvs > 0";
                    $result = mysqli_query($conn, $getvip);
                    while ($x = mysqli_fetch_assoc($result)) {
                            $id = $x['id_ctvs'];
                            $name = $x['name'];
                            $u_name = $x['user_name'];
                            $idfb = $x['profile'];
                            $num = $x['num_id'];
                            $pay = $x['payment'];
                            $email = $x['email'];
                            $phone = $x['phone'];
                        ?>
                        <tr style="font-weight: bold">
                            <td><?php echo $id; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $u_name; ?></td>
                            <td><?php echo $idfb; ?> </td>
                            <td><?php echo $email; ?> </td>
                            <td><?php echo $phone; ?> </td>
                           
                            <td style="color:red"><?php echo number_format($pay). ' VNĐ'; ?></td>
                            <?php if($idctv == 1){ ?> <td><a href="index.php?DS=Reset_Statics&id_ctv=<?php echo $id; ?>" class="btn btn-danger">Reset</a> <a href="index.php?DS=Update_Statics&id_ctv=<?php echo $id; ?>" class="btn btn-info">Cập nhật</a></td><?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
            </div>
            </div>
            </div>
            <p class="alert alert-success" style="text-align: justify;"><span class="h4">Doanh thu tự động được cộng khi thêm ID VIP mới, khi chuyển tiền cho thành viên ( Đại lí, CTV ) khác, khi tạo gift code (khi muốn tạo gift code cho event gì đó thì liên hệ Admin Full để tạo, hoặc tự tạo thì sẽ tính vào doanh thu). Mọi giao dịch đều được lưu vào lịch sử. Không gian lận tạo clone, tạo gift.. đều được ghi vào lịch sử và doanh thu nhé :)</span></p>
        </div>