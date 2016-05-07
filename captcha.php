<?php
session_start(); // 开启session,必须处于最顶部

$image = imagecreatetruecolor(100, 30);  //生成一块画布，默认背景为黑色
$bgcolor = imagecolorallocate($image, 255, 255, 255); //生成白色
imagefill($image, 0, 0, $bgcolor);  //用白色填充画布

//简单的数字验证码 0-9
/*for ($i = 0; $i < 4; $i++) {
    $fontsize = 5;
    $fontcolor = imagecolorallocate($image, rand(80, 120), rand(80, 120), rand(80, 120));
    $fontcontent = rand(0, 9);

    $x = ($i * 100 / 4) + rand(0, 5);
    $y = rand(0, 5);

    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
}*/


//数字和字母混合验证码
$captcha_code = ''; //设定一个变量用于储存验证码
for($i=0;$i<4;$i++){
    $fontsize = 5;
    $fontcolor = imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
    $data = 'acdefhijkmnopqrstuvwxy34578';
    $fontcontent = substr( $data, rand( 0, strlen($data)-1), 1 );
    $captcha_code .= $fontcontent;

    $x = ($i * 100 / 4 )+ rand(5, 10);
    $y = rand(5, 10);

    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
}
    $_SESSION['authcode'] = $captcha_code;  //储存在  authcode  变量中

//添加干扰点
for ($i = 0; $i < 200; $i++) {
    $pointcolor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
    imagesetpixel($image, rand(1, 99), rand(1, 29), $pointcolor);
}

//添加干扰线
for ($i = 0; $i < 5; $i++) {
    $linecolor = imagecolorallocate($image, rand(80, 220), rand(80, 220), rand(80, 220));
    imageline($image, rand(1, 99), rand(1, 29), rand(1, 99), rand(1, 29), $linecolor);
}


header('content-type: image/png');
imagepng($image);


imagedestroy($image);
?>