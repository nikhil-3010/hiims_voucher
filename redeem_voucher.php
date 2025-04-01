<?php
session_start();
//first check phone number is in seesion if not then signup and if it is avail but not in session then login
if (isset($_SESSION['phoneNumber'])) {
$phoneNumber = $_SESSION['phoneNumber'];}
require_once './config/config.php';  

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $phoneNumber = $_SESSION['phoneNumber'];
    $voucherId = $_POST['voucherID'];
    $db = getDbInstance();

    $uniquecode = rand(100000, 999999);

    $db->where('phone', $phoneNumber);
    $customer = $db->getOne('user_info'); 

    if($customer){
        $data_to_insert = [
            'voucher_id' => $voucherId,
            'vouchers_code' => $uniquecode,
        ];
        $db->where('phone', $phoneNumber);
        $last_id = $db->update('user_info', $data_to_insert);
        if ($last_id) {
            echo json_encode(['success' => true, 'redeem_code' => $uniquecode]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save data.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Phone number not found.']);
    }
}




?>