<?php
    if($rule != 'admin' && $rule !='agency'){
        echo "<script>alert('CÚT'); window.location = 'index.php';</script>";
    }
?>
<?php
    if(isset($_POST['submit'])){
        $id = $_POST['user_name'];
        $content = $_POST['noi_dung'];
        $time = time();
        $sql = "INSERT INTO noti(content, time, id_ctv) VALUES('$content', '$time', '$id')";
        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Gửi thành công'); window.location='index.php?DS=Notify';</script>";
        }
    }
?><div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Gửi thông báo Cho CTV</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">UserName:</label>

                        <div class="col-sm-10">
                            <select name="user_name" class="form-control">
                            <?php
                                if($rule == 'admin'){
                                    $get = "SELECT id_ctvs, user_name, name FROM ctv ORDER BY user_name ASC";
                                }else{
                                     $get = "SELECT id_ctvs, user_name, name FROM ctv WHERE id_agency=$idctv ORDER BY user_name ASC";
                                }
                                $result = mysqli_query($conn, $get);
                                while($x = mysqli_fetch_assoc($result)){
                                    $id = $x['id_ctvs'];
                                    $user_name = $x['user_name'];
                                    $name = $x['name'];
                                    echo "<option value='$id'>$name ($user_name)</option>";
                                }
                            ?>
                                
                            </select>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Nội dung:</label>

                        <div class="col-sm-10">
                            <textarea name="noi_dung" class="ckeditor form-control" rows="20"></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Gửi</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>

        <?php if($rule == 'admin'){ ?>
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Gửi thông báo Cho Đại Lí, Member</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">UserName:</label>

                        <div class="col-sm-10">
                            <select name="user_name" class="form-control">
                            <?php
                                $get = "SELECT id_ctv, user_name, name FROM member ORDER BY user_name ASC";
                                $result = mysqli_query($conn, $get);
                                while($x = mysqli_fetch_assoc($result)){
                                    $id = isset($x['id_ctv']) ? $x['id_ctv'] : $x['id_ctvs'];
                                    $user_name = $x['user_name'];
                                    $name = $x['name'];
                                    echo "<option value='$id'>$name ($user_name)</option>";
                                }
                            ?>
                                
                            </select>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Nội dung:</label>

                        <div class="col-sm-10">
                            <textarea name="noi_dung" class="ckeditor form-control" rows="20"></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Gửi</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <?php } ?>
    </div>
</div>
