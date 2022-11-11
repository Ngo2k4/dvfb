<?php defined('COPYRIGHT') or exit('hihi'); ?>
<?php
if($rule = 'admin' && $idctv ==1){
    if(isset($_POST['submit'])){
        $content = explode("\n", trim($_POST['noi_dung']));
        $up1 = mysqli_query($conn, "UPDATE notification SET content = '$content[0]' WHERE id = 1");
        $up2 = mysqli_query($conn, "UPDATE notification SET content = '$content[1]' WHERE id = 2");
        header('Location: notify.html');
    }  
}else{
    header('Location: /index.html');
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật thông báo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Nội dung:</label>
                
                        <div class="col-sm-10">
                            <textarea name="noi_dung" class="form-control" rows="20">
                                <?php
                                    $get = mysqli_query($conn, 'SELECT content FROM notification');
                                    while($c = mysqli_fetch_assoc($get)){ ?>
                                        <?= trim($c['content'])."\n"; ?>
                                    <?php } ?>
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>