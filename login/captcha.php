<?php
session_start();
$string = md5(time());
$string = substr($string, 0, 4);
$_SESSION['captcha'] = $string;
$img = imagecreate(45,20);
$background = imagecolorallocate($img, 0,0,0);
$text_color = imagecolorallocate($img, 255,255,255);
imagestring($img, 10 ,5, 2, $string, $text_color);
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
?>