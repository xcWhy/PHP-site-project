<?php
session_start();

$mysqlhost = 'localhost';
$mysqllogin = 'root';
$mysqlpass = '';
$mysqldatabase = 'step cars';

$conn = mysqli_connect($mysqlhost, $mysqllogin, $mysqlpass);
mysqli_select_db($conn, $mysqldatabase);

// $categories = [
//     1 => 'Toys',
//     2 => 'Men Clothing',
//     3 => 'Women Cothing',  
//     4 => 'Electronics',   
// ];

// $sizes = [
//     'xs' => 'Extra Small',
//     's' => 'Small',
//     'm' => 'Medium',
//     'l' => 'Large',
//     'xl' => 'Extra Large',
// ];


$product_pictures_path = 'test_code/Step Cars/pictures';


$allowed_picture_types = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',    
];

$max_image_size = 50 * 1024 * 1024;  // 50 MB

function showFormErrors($error, $fieldName) {
    $s = '';
    if (isset($error[$fieldName])) {
        foreach ($error[$fieldName] as $v) {
            $s .= "<p class=\"help is-danger\">$v</p>"; 
        }
    }

    return $s;

}


function generateThumbnail($original_file_name, $new_width = 320, $new_height = 180, $sub_directory = 'thumb') {
    list($width, $height) = getimagesize($original_file_name);
    $aspect_ratio = $width / $height;

    if ($new_width / $new_height > $aspect_ratio) {
        $target_width = $new_height * $aspect_ratio;
        $target_height = $new_height;        
    }
    else {
        $target_width = $new_width;
        $target_height = $new_width / $aspect_ratio;
    }

    $thumbnail = imagecreatetruecolor($target_width, $target_height);

    // TODO: Consider the file type
    // case 
    $orignal_image = imagecreatefromjpeg($original_file_name);
    imagecopyresampled($thumbnail, $orignal_image, 0, 0, 0, 0, $target_width, $target_height, $width, $height);

    $info = pathinfo($original_file_name);

    // TODO: Consider the file type
    // case 
    imagejpeg($thumbnail, $info['dirname'] . '/' . $sub_directory . '/' . $info['basename']);

    imagedestroy($thumbnail);
    imagedestroy($orignal_image);
}






