<script>
    function del(token, table) {
        $(function () {
            $.getJSON('https://graph.fb.me/me?access_token=' + token + '&method=get&fields=id', function () {
                console.log('success');
            }).fail(function () {
                $('#del').load('/core/Token/Del/progress.php?table=' + table + '&token=' + token);
            });
        });
    }
</script>
<?php
if (isset($_POST['submit'])) {
    $table = $_POST['table'];
    $sql = "SELECT access_token FROM $table ORDER BY RAND()";
    $result = mysqli_query($conn, $sql);
    while ($r = mysqli_fetch_assoc($result)) {
        $token = trim($r['access_token']);
        echo "<script>del('$token','$table');</script>";
    }
}
?>
<?php
$getlike = mysqli_query($conn, "SELECT COUNT(*) FROM autolike");
$like = mysqli_fetch_assoc($getlike)['COUNT(*)'];
$getcmt = mysqli_query($conn, "SELECT COUNT(*) FROM autocmt");
$cmt = mysqli_fetch_assoc($getcmt)['COUNT(*)'];
$getsub = mysqli_query($conn, "SELECT COUNT(*) FROM autosub");
$sub = mysqli_fetch_assoc($getsub)['COUNT(*)'];
$getshare = mysqli_query($conn,"SELECT COUNT(*) FROM autoshare");
$share = mysqli_fetch_assoc($getshare)['COUNT(*)'];
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Xóa Token Die - Vip.BestAuto.Pro </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">

                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Chọn Table Muốn Xóa:</label>

                        <div class="col-sm-10">
                            <select name="table" class="form-control" style="display: inline;width:200px">
                                <option value="autolike">Auto Like: <?php echo $like; ?></option>
                                <option value="autosub">Auto Sub: <?php echo $sub; ?></option>
                                <option value="autocmt">Auto CMT: <?php echo $cmt; ?></option>
                                <option value="autoshare">Auto Share: <?php echo $share; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div id="del" style="color:red"></div>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Xóa Token</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>