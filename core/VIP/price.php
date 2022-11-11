<?php
if(isset($_POST['han'], $_POST['goi'], $_POST['rule'])){
	if($_POST['han'] < 0 || $_POST['goi'] < 0){
		echo 'Không hợp lệ, chú định bug à, quên mẹ cái mùa xuân ấy đê :)))';
	}else if($_POST['han'] == 'one'){
		echo 'Free Test!';
	}else if($_POST['han'] == 'three'){
		echo 'Free Event';
	}else if($_POST['han'] == 'seven'){
		$price = ($_POST['goi'] /30 ) * 10;
		if($_POST['rule'] == 'agency'){
			$price -= $price * 10 / 100;
		}else if($_POST['rule'] == 'freelancer'){
			$price -= $price * 5 / 100;
	    }
		echo number_format($price). ' VNĐ';
	}else{
		$price = $_POST['han'] * $_POST['goi'];
		if($_POST['rule'] == 'agency'){
	    	$price -= $price * 10 / 100;
	    }else if($_POST['rule'] == 'freelancer'){
			$price -= $price * 5 / 100;
	    }
	    echo number_format($price).' VNĐ';
	}
}
?>