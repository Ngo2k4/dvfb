<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php
    include 'config.php';
    include 'card_charging_api.php';
	
	// Call lib
	try {
		$api = new Card_charging_api($config);
	}
	catch (Card_charging_Exception $e) {
		exit($e->getMessage());
	}	
	
	//lay danh sach cac loai the dang hoat dong
	$keys = $api->get_card_keys();
	$keys = is_array($keys) ? $keys : array();
?>
<form class="form-horizontal" action="Card/key24h/check_card.php" method="post">
     <div class="form-group">
        <label for="user" class="col-lg-2 control-label"><font color="red">Chọn loại thẻ: </font></label>
        <div class="col-lg-10">
             <select name="key" class="form-control">
                 <?php foreach ($keys as $key):?>
                  <?php $key_name = str_replace(array('viettel','vina','vcoin','oncash','bit','gate'), array('Viettel','Vinaphone','VTC vCoin','OnCash','Bit','FPT Gate'), $key); ?>
                  <option value="<?php echo $key?>"><?php echo $key_name?></option>
                 <?php endforeach;?>
             </select>
        </div>
     </div>
     <div class="form-group">
    <label for="rule" class="col-lg-2 control-label"><font color="red">Bạn là ? </font></label>
    <div class="col-lg-10">
        <input type="radio" class="rule" name="rulex" value="agency" data-toggle="tooltip" data-title="Click chọn nếu bạn là đại lí" onchange="check()" onmouseleave="check()" <?php if(isset($rule) && $rule == 'agency') echo 'checked'; ?> required> Đại lí <?php if($k>0){?><code>+ <?php echo $k; ?>%</code><?php }else{ ?><code>+10 %</code><?php } ?><br />
      <input type="radio" class="rule" name="rulex" value="freelancer" data-toggle="tooltip" data-title="Click chọn nếu bạn là cộng tác viên" onchange="check()" onmouseleave="check()" <?php if(isset($rule) && $rule == 'freelancer') echo 'checked'; ?> required> Cộng tác viên <?php if($k>0){?><code>+ <?php echo $k; ?>%</code><?php }else{ ?><code>+5 % </code> <?php } ?><br />
      <input type="radio" class="rule" name="rulex" value="member" data-toggle="tooltip" data-title="Click chọn nếu bạn là thành viên" onchange="check()" onmouseleave="check()" <?php if(isset($rule) && $rule == 'member') echo 'checked'; ?> required>Thành viên <?php if($k>0){?><code>+ <?php echo $k; ?>%</code><?php } ?>
    </div>
  </div>
  <div class="form-group">
    <label for="user" class="col-lg-2 control-label"><font color="red">Tài khoản: </font></label>
    <div class="col-lg-10">
      <input type="text" onchange="check();"  onkeyup="check();" id="user" style="width: 400px" class="form-control"  name="user" value="<?php echo isset($uname) ? $uname : ''; ?>" placeholder="Nhập chính xác tên tài khoản" data-toggle="tooltip" data-title="Nhập chính xác tên tài khoản" required <?php echo isset($uname) ? 'readonly' : ''; ?>/>
      <span id="check"></span>
    </div>
  </div>
     <div class="form-group">
        <label for="user" class="col-lg-2 control-label"><font color="red">Mã thẻ: </font></label>
        <div class="col-lg-10">
             <input type="text" name="code" id="code" class="form-control" placeholder="Nhập mã thẻ" >
        </div>
     </div>
     <div class="form-group">
        <label for="user" class="col-lg-2 control-label"><font color="red">Số seri: </font></label>
        <div class="col-lg-10">
             <input type="text" name="serial" id="serial" class="form-control" placeholder="Nhập số seri" >
    </div>
     </div>
     <center>
         <button type="submit" id="submit" class="btn btn-success">Đổi thẻ cào</button>
     </center>
</form>
<script>
 $('#submit').click(function(){
     if($('input[name=rulex]').val() && $('#user').val() && $('#code').val() && $('#serial').val()){
        $(this).addClass('btn btn-info').text('Đang xử lí thẻ....');
     }
 });
 function check(){
  if($('#user').val() != ''){
    $.get('Card/check.php', { user: $('#user').val(), rule: $('input[name=rulex]:checked').val() }, function(result){ $('#check').html(result); });
    }
  }
</script>