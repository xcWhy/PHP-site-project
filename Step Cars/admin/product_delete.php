<?php
require_once('functions.inc.php');

if ($_GET) {
 

    $id = (int)$_GET['id'];

    $query = "DELETE FROM product WHERE id = $id";    
    
    mysqli_query($conn, $query);    

    header('location:product_list.php');
    exit();
    
}