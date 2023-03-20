<?php
require_once('functions.inc.php');
unset($_SESSION['user']);
header('location:index.php');
exit();  