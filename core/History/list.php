<script>
    function check(id) {
        if (confirm('Bạn có chắc chắn muốn xóa lịch sử  này ?') == true) {
            window.location = 'index.php?DS=Delete_History&id_his=' + id;
        } else {
            return false;
        }
    }
    function check1(type) {
        if (confirm('Bạn có chắc chắn muốn xóa tất cả lịch sử type này?') == true) {
            window.location = 'index.php?DS=Delete_History&type='+type;
        } else {
            return false;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Lịch sử</h3>
    </div>
    <ul class="nav nav-tabs">
        <li class="active">
            <a  href="#ok0" data-toggle="tab">VIP ID</a>
        </li>
        <li><a href="#ok1" data-toggle="tab">Tài Khoản</a>
        </li>
        <li><a href="#ok2" data-toggle="tab">Số dư</a>
        </li>
        <li><a href="#ok3" data-toggle="tab">Gift Code</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="ok0">
        <?php if ($rule == 'admin' && $idctv == 1) { ?><a href="#" onClick="check1(0)" class="btn btn-danger">Xóa tất cả</a><?php } ?><hr />
            <div class="table-responsive">
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <?php if ($rule == 'admin' && $idctv == 1) { ?><th>Công cụ</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rule != 'admin') {
                        $get0 = "SELECT id, content, time FROM history WHERE id_ctv=$idctv AND type = 0";
                    } else if ($rule == 'admin' && $idctv != 1) {
                        $get0 = "SELECT id, content, time FROM history WHERE id_ctv != 1 AND type = 0 AND id_ctv >0";
                    } else {
                        $get0 = "SELECT id, content, time FROM history WHERE type = 0";
                    }
                    $result0 = mysqli_query($conn, $get0);
                    while ($x0 = mysqli_fetch_assoc($result0)) {
                        $id0= $x0['id'];
                        $t0 = $x0['time'];
                        $time0 = date("d/m/Y - H:i:s", $t0);
                        ?>
                        <tr>
                            <td><?php echo $x0['id']; ?></td>
                            <td><?php echo substr($x0['content'], 0, 300); ?></td>
                            <td><?php echo $time0; ?></td>
                            <?php if ($rule == 'admin' && $idctv == 1) { ?><td style="text-align:center"><a href="#" onclick="check(<?php echo $id0; ?>);" class="btn btn-danger">Xóa</a></td> <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <div class="tab-pane" id="ok1">
        <?php if ($rule == 'admin' && $idctv == 1) { ?><a href="#" onClick="check1(1)" class="btn btn-danger">Xóa tất cả</a><?php } ?><hr />
            <div class="table-responsive">
            <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <?php if ($rule == 'admin' && $idctv == 1) { ?><th>Công cụ</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rule != 'admin') {
                        $get1 = "SELECT id, content, time FROM history WHERE id_ctv=$idctv AND type = 1";
                    } else if ($rule == 'admin' && $idctv != 1) {
                        $get1 = "SELECT id, content, time FROM history WHERE id_ctv != 1 AND type = 1 AND id_ctv > 0";
                    } else {
                        $get1 = "SELECT id, content, time FROM history WHERE type = 1";
                    }
                    $result1 = mysqli_query($conn, $get1);
                    while ($x1 = mysqli_fetch_assoc($result1)) {
                        $id1 = $x1['id'];
                        $t1 = $x1['time'];
                        $time1 = date("d/m/Y - H:i:s", $t1);
                        ?>
                        <tr>
                            <td><?php echo $x1['id']; ?></td>
                            <td><?php echo $x1['content']; ?></td>
                            <td><?php echo $time1; ?></td>
                            <?php if ($rule == 'admin' && $idctv == 1) { ?><td style="text-align:center"><a href="#" onclick="check(<?php echo $id1; ?>);" class="btn btn-danger">Xóa</a></td> <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <div class="tab-pane" id="ok2">
        <?php if ($rule == 'admin' && $idctv == 1) { ?><a href="#" onClick="check1(2)" class="btn btn-danger">Xóa tất cả</a><?php } ?><hr />
            <div class="table-responsive">
            <table id="example3" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <?php if ($rule == 'admin' && $idctv == 1) { ?><th>Công cụ</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rule != 'admin' || ($rule == 'admin' && $idctv != 1)) {
                        $get2 = "SELECT id, content, time FROM history WHERE id_ctv=$idctv AND type = 2";
                    }
                    // else if ($rule == 'admin' && $idctv != 1) {
                    //     $get2 = "SELECT id, content, time FROM history WHERE id_ctv != 1 AND type = 2 AND id_ctv >0";
                    // }
                    else {
                        $get2 = "SELECT id, content, time FROM history WHERE type = 2";
                    }
                    $result2 = mysqli_query($conn, $get2);
                    while ($x2 = mysqli_fetch_assoc($result2)) {
                        $id2 = $x2['id'];
                        $t2 = $x2['time'];
                        $time2 = date("d/m/Y - H:i:s", $t2);
                        ?>
                        <tr>
                            <td><?php echo $x2['id']; ?></td>
                            <td><?php echo $x2['content']; ?></td>
                            <td><?php echo $time2; ?></td>
                            <?php if ($rule == 'admin' && $idctv == 1) { ?><td style="text-align:center"><a href="#" onclick="check(<?php echo $id2; ?>);" class="btn btn-danger">Xóa</a></td> <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <div class="tab-pane" id="ok3">
        <?php if ($rule == 'admin' && $idctv == 1) { ?><a href="#" onClick="check1(3)" class="btn btn-danger">Xóa tất cả</a><?php } ?><hr />
            <div class="table-responsive">
            <table id="example4" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <?php if ($rule == 'admin' && $idctv == 1) { ?><th>Công cụ</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rule != 'admin') {
                        $get3 = "SELECT id, content, time FROM history WHERE id_ctv=$idctv AND type = 3";
                    } else if ($rule == 'admin' && $idctv != 1) {
                        $get3 = "SELECT id, content, time FROM history WHERE id_ctv != 1 AND type = 3 AND id_ctv >0";
                    } else {
                        $get3 = "SELECT id, content, time FROM history WHERE type = 3";
                    }
                    $result3 = mysqli_query($conn, $get3);
                    while ($x3 = mysqli_fetch_assoc($result3)) {
                        $id3 = $x3['id'];
                        $t3 = $x3['time'];
                        $time3 = date("d/m/Y - H:i:s", $t3);
                        ?>
                        <tr>
                            <td><?php echo $x3['id']; ?></td>
                            <td><?php echo $x3['content']; ?></td>
                            <td><?php echo $time3; ?></td>
                            <?php if ($rule == 'admin' && $idctv == 1) { ?><td style="text-align:center"><a href="#" onclick="check(<?php echo $id3; ?>);" class="btn btn-danger">Xóa</a></td> <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>


    </div>

</div>