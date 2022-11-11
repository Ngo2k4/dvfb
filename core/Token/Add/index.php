
<script>
    function add(){
        $('#submit').removeClass('btn btn-primary').addClass('btn btn-info').html('<i class="fa fa-spinner fa-spin">Đang thêm token...').attr('disabled','disabled');
        var table = $('#table').val();
        var token = $('#token').val().split("\n");
        var success = 0; fail = 0;
        $('#total').fadeIn('slow').text('Total: '+token.length);
        for(let i = 0; i < token.length; i++){
            if(table != 'token_share1' && table != 'token_share2' && table != 'token_share3' && table != 'token_share4' && table !='autoshare'){
                $.getJSON('https://graph.fb.me/me?access_token='+token[i]+'&fields=id,name,gender&method=get',function(ds){
                    $.post('/core/Token/Add/progress.php', {gender: ds.gender, tb: table, uid: ds.id, name: encodeURIComponent(ds.name), t: token[i]}, function(response){
                        if(response == 'success'){
                            success++;
                            $('#success').fadeIn('slow').text('Success: '+success);
                        }else{
                            fail++;
                            $('#fail').fadeIn('slow').text('Fail: '+fail);
                        }
                    })
                }).fail(function(){
                    fail++;
                    $('#fail').fadeIn('slow').text('Fail: '+fail);
                });
                if((i+1) == token.length){
                    $('#token').val('');
                    $('#submit').removeClass('btn btn-info').addClass('btn btn-primary').text('Thêm tiếp').removeAttr('disabled');
                }
            }else{
                $.getJSON('https://graph.fb.me/me?access_token='+token[i]+'&fields=id,name&method=get',function(ds){
                    $.post('/core/Token/Add/progress.php', {tb: table, uid: ds.id, name: encodeURIComponent(ds.name), t: token[i]}, function(response){
                        if(response == 'success'){
                            success++;
                            $('#success').fadeIn('slow').text('Success: '+success);
                        }else{
                            fail++;
                            $('#fail').fadeIn('slow').text('Fail: '+fail);
                        }
                    })
                }).fail(function(){
                    fail++;
                    $('#fail').fadeIn('slow').text('Fail: '+fail);
                });
                if((i+1) == token.length){
                    $('#token').val('');
                    $('#submit').removeClass('btn btn-info').addClass('btn btn-primary').text('Thêm tiếp').removeAttr('disabled');
                }
            }
        }
    }
</script>
<?php
$getlike = mysqli_query($conn,"SELECT COUNT(*) FROM autolike");
$like = mysqli_fetch_assoc($getlike)['COUNT(*)'];
$getcmt = mysqli_query($conn,"SELECT COUNT(*) FROM autocmt");
$cmt = mysqli_fetch_assoc($getcmt)['COUNT(*)'];
$getsub = mysqli_query($conn,"SELECT COUNT(*) FROM autosub");
$sub = mysqli_fetch_assoc($getsub)['COUNT(*)'];
$getshare = mysqli_query($conn,"SELECT COUNT(*) FROM autoshare");
$share = mysqli_fetch_assoc($getshare)['COUNT(*)'];
?>
<?php
    if(isset($_POST['submit'])){
        $table = $_POST['table'];
        $token = explode("\n", $_POST['token']);
        $c = count($token);
        $i = 0;
        for(;$i<$c;){
            $t = trim($token[$i]);
            echo "<script>duy('$t','$table');</script>";
            ++$i;
        }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border" style="text-align:center">
                <h3 class="box-title">Add Token To Database</h3>
            </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <select name="table" id="table" class="form-control">
                                <option value="autolike" <?php echo (isset($_POST['table']) && $_POST['table'] == 'autolike') ? 'selected' : ''; ?>>Token Like: <?php echo $like; ?></option>
                                <option value="autocmt" <?php echo (isset($_POST['table']) && $_POST['table'] == 'autocmt') ? 'selected' : ''; ?>>Token CMT: <?php echo $cmt; ?></option>
                                <option value="autosub" <?php echo (isset($_POST['table']) && $_POST['table'] == 'autosub') ? 'selected' : ''; ?>>Token Sub: <?php echo $sub; ?></option>
                                <option value="autoshare" <?php echo (isset($_POST['table']) && $_POST['table'] == 'autoshare') ? 'selected' : ''; ?>>Token Share: <?php echo $share; ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <center><span class="h4">List Token</span></center>
                            <textarea name="token" id="token" class="form-control" rows="20" placeholder="Mỗi token 1 dòng"></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer" style="text-align:center">
                    <button type="button" onclick="add()" id="submit" class="btn btn-primary">Add Token</button>
                    <button type="button" id="total" class="btn btn-default" style="display:none"></button>
                    <button type="button" id="success" class="btn btn-success" style="display:none"></button>
                    <button type="button" id="fail" class="btn btn-danger" style="display:none"></button>
                </div>
        </div>
    </div>
</div>
