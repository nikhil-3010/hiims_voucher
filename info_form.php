<?php
require_once './config/config.php';  // This should contain your database connection and MysqliDb setup

session_start();
if (isset($_SESSION['phoneNumber'])) {
    $phoneNumber = $_SESSION['phoneNumber'];

    $db = getDbInstance(); // Make sure your config file defines this function properly
    
    $db->where('phone', $phoneNumber);
    $existingUser = $db->getOne('user_info', ['name', 'email', 'pincode']);

    if (!$existingUser) {
        $existingUser = ['name' => '', 'email' => '', 'pincode' => '']; // Initialize as empty if not found
    }
}else{
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jeena Sikho Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      

    </style>
</head>
<body>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
             
        });
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
