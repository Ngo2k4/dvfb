<?php
	$sql = "SELECT id, end FROM vip ORDER BY RAND()";
	$result = mysqli_query($conn, $sql);
	while($like = mysqli_fetch_assoc($result)){
		if($like['end'] <= time()){
			mysqli_query($conn, "DELETE FROM vip WHERE id={$like['id']}");
		}
	}

	$sql1 = "SELECT id, end FROM vipcmt ORDER BY RAND()";
	$result1 = mysqli_query($conn, $sql1);
	while($cmt = mysqli_fetch_assoc($result1)){
		if($cmt['end'] <= time()){
			mysqli_query($conn, "DELETE FROM vipcmt WHERE id={$cmt['id']}");
		}
	}

	$sql2 = "SELECT id, end FROM vipreaction ORDER BY RAND()";
	$result2 = mysqli_query($conn, $sql2);
	while($react = mysqli_fetch_assoc($result2)){
		if($react['end'] <= time()){
			mysqli_query($conn, "DELETE FROM vipreaction WHERE id={$react['id']}");
		}
	}

	$sql3 = "SELECT id, end FROM vipshare ORDER BY RAND()";
	$result3 = mysqli_query($conn, $sql3);
	while($share = mysqli_fetch_assoc($result3)){
		if($share['end'] <= time()){
			mysqli_query($conn, "DELETE FROM vipshare WHERE id={$share['id']}");
		}
	}


?>