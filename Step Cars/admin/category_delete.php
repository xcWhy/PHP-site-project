<?php
require_once('functions.inc.php');

if ($_GET) {

    // TO DO: Check if there are products in that category 

    $id = (int)$_GET['id'];

    $query = "DELETE FROM category WHERE id = $id";    
    
    mysqli_query($conn, $query);    

    header('location:category_list.php');
    exit();
    
}