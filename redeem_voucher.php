<?php
session_start();
$phoneNumber = $_SESSION['phoneNumber'];
require_once './config/config.php';  

$db = getDbInstance();

$db->where('phone', $phoneNumber);
$customer = $db->get('user_info'); 

?>