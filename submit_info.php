<?php
session_start();
require_once './config/config.php';  // This should contain your database connection and MysqliDb setup

// Retrieve form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pincode = isset($_POST['pincode']) ? trim($_POST['pincode']) : '';


// Validate input (Simple validation, you can enhance it)
if (empty($name) || empty($phone) || empty($email) || empty($pincode)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

try {
    $db = getDbInstance(); // Make sure your config file defines this function properly
    
    $db->where('phone', $phone);
    $existingUser = $db->getOne('user_info');

    if ($existingUser) {
        echo json_encode(['success' => false, 'message' => 'Phone number already exists.']);
        exit;
    }

    $data_to_insert = [
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'pincode' => $pincode,
        'created_at' => date('Y-m-d H:i:s')
    ];

    
    $last_id = $db->insert('user_info', $data_to_insert);


    if ($last_id) {
        echo json_encode(['success' => true, 'message' => 'Information saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save information.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>