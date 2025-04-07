<?php

header('Content-Type: application/json'); 
session_start();

function sendsmsmsg($phone, $sender, $tmp, $msg) {
    $username = 'jenamtrpg.trans';
    $password = '6t23r';
    $dltPrincipalEntityId = '1001523970180458628';

    $url = 'https://api.smartping.ai/fe/api/v1/send?username=' . $username . '&password=' . $password . '&dltPrincipalEntityId=' . $dltPrincipalEntityId;

    $postfields = array(
        'unicode' => true,
        'dltContentId' => $tmp,
        'from' => $sender,
        'to' => $phone,
        'text' => $msg
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($postfields),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    return $response; // Optional: return response for logging/debugging
}

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

    $sender = "SHUDHI";
    $tmp = "1707172967245948300";
    $msg = "Hi your OTP for SHUDDHI is only valid for 10 minutes " . $otp . ". TEAM SHUDDHI";

    // sendsmsmsg($phoneNumber, $sender, $tmp, $msg);

    // Return JSON response
    echo json_encode([
        "success" => true,
        "message" => "OTP sent successfully!",
        "otp" => $otp  
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method. Only POST is allowed."
    ]);
}
?>