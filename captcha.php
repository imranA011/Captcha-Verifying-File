<?php 

$img_width = 200;
$img_height = 60;
$str1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$str2 = strtolower("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
$str3 = "123456789";
$str= str_shuffle($str1.$str2.$str3);
$captcha_code = substr($str, 0, 5);

session_start();
$_SESSION['captcha'] = $captcha_code;

$font_name = "assets/css/webfonts/OpenSans-Bold.ttf";
$font_size = 22;
$random_x = mt_rand(50 , 70);
$random_y = mt_rand(35 , 45);
$random_angle = mt_rand(-10 , 10);
$random_captcha_dots = 100;
$random_captcha_lines = 10;

$image = imagecreatetruecolor($img_width, $img_height);
$image_bg_clr = imagecolorallocate($image, 250, 250, 250);
$captcha_font_clr = imagecolorallocate($image, 110, 110, 110);
$noise_clr = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $image_bg_clr);
imagettftext($image, $font_size, $random_angle , $random_x, $random_y, $captcha_font_clr, $font_name, $captcha_code);

for( $count=0; $count<$random_captcha_dots; $count++ ) {
    imagefilledellipse( $image, mt_rand(0, $img_width),  mt_rand(0, $img_height), 2, 2, $noise_clr);
}

for( $count=0; $count<$random_captcha_lines; $count++ ) {
    imageline( $image, mt_rand(0, $img_width),  mt_rand(0, $img_height), mt_rand(0, $img_width),  mt_rand(0, $img_height), $noise_clr);
}

header('Content-type: image/jpeg');

imagejpeg($image);
imagedestroy($image);


?>