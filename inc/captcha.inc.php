<?php

include_once('config.inc.php');
$random = rand(1, 9) . rand(1, 9) . rand(1, 9);

$_SESSION['captcha'] = $random;

// Define the path to the image file
$imagePath = "../img/captcha.JPG";


// Check if the image file exists
if (file_exists($imagePath)) {
    // Create image resource from JPEG
    $captcha = imagecreatefromjpeg($imagePath);
    $color = imagecolorallocate($captcha, 0, 0, 0);
    $font = 'code.otf';
    imagettftext($captcha, 20, 0, rand(30, 200), rand(20, 70), $color, $font, $random);

    // Output image as PNG
    header('Content-type: image/png');
    imagepng($captcha);

    // Clean up resources
    imagedestroy($captcha);
} else {
    echo "Error: Image file not found.";
}
