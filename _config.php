<?php
    $conn = mysqli_connect('localhost','twxjvpwh_like','1252000@#','twxjvpwh_like') or die('Failed');
    mysqli_set_charset($conn, "utf8");
    $token_check = array('EAAAAUaZA8jlABAJdfheVbVQRE2WjDbUWKc8J7ZCRC01SZAWTJflsZAdA1Y9X1pU3sA4SVrkFIbt3eWZA3JauxQ4YHSMHjRTiKKL1VzAzyjgcnenQZAdmMULJGyrf1X0hjwDPYZAoGMv4cMByXmz3FjBgdh9pZAQQDNAZD','EAAAAUaZA8jlABAIeRhFwZCzCepZBq6dRFjyfb8ZCZCgIijPYHSoqjs5v7Jg4jTBl9iDWGIEFcrT6ZBF2qqroboSWzZCrfwtA68zc9bvf6S1QRHZBsTD9eyHpPXLwngHocaO5R2svlTT81QNXeZA8D4301A5B2SevZCTuOK7AHgs3BdzwZDZD'); //  thay 2 token vào  'TOKEN 1' , 'TOKEN 2'
    $tokenx = $token_check[array_rand($token_check)]; // lấy ra ngẫu nhiên 1 token 
?>