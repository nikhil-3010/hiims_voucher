<?php
session_start();
require_once './config/config.php';  // Ensure this contains your database connection and MysqliDb setup

$response = ['success' => false, 'data' => []];

if (isset($_POST['phoneNumber'])) {
    $phoneNumber = $_POST['phoneNumber'];

    $db = getDbInstance(); 
    $db->where('phone', $phoneNumber);
    $existingUser = $db->getOne('user_info', ['name', 'email', 'pincode']);

    if ($existingUser) {
        $response['success'] = true;
        $response['data'] = $existingUser;
    } else {
        $response['success'] = true;
        $response['data'] = ['name' => '', 'email' => '', 'pincode' => '']; 
    }
} 

echo json_encode($response);
?>