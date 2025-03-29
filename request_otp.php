<?php

header('Content-Type: application/json'); 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneNumber = $_POST['phoneNumber'];

    // Validate phone number
    if (strlen($phoneNumber) !== 10 || !ctype_digit($phoneNumber)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid phone number. Please enter a valid 10-digit number."
        ]);
        exit;
    }

    // Generate a random 4-digit OTP
    $otp = rand(1000, 9999);
    $_SESSION['otp'] = $otp;
    $_SESSION['phoneNumber'] = $phoneNumber;

    // Return JSON response
    echo json_encode([
        "success" => true,
        "message" => "OTP sent successfully!",
        "otp" => $otp  // Remove this in production, only for testing
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method. Only POST is allowed."
    ]);
}
?>