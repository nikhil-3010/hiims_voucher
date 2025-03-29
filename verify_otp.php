<?php
header('Content-Type: application/json'); 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userOtp = $_POST['otp'] ?? '';
    $sessionOtp = $_SESSION['otp'] ?? null;


    if ($userOtp == $sessionOtp) {
        // unset($_SESSION['otp']); // Clear the OTP from the session after successful verification
        echo json_encode([
            "success" => true,
            "message" => "OTP verified successfully!"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid OTP. Please try again."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method. Only POST is allowed."
    ]);
}
?>