<?php
session_start();
require_once './config/config.php';  

if (!isset($_SESSION['phoneNumber'])) {
    echo json_encode(['success' => false, 'message' => 'Phone number not found in session.']);
    exit;
}

$phoneNumber = $_SESSION['phoneNumber'];
$db = getDbInstance();

// Fetch user information
$db->where('phone', $phoneNumber);
$customer = $db->getOne('user_info', ['id','name', 'vouchers_code']); 

if (!$customer) {
    echo json_encode(['success' => false, 'message' => 'No customer found with this phone number.']);
    exit;
}

$code = $customer['id'];

$redeemcode = $db->where('customer_id', $code)->getOne('coupen_codes', 
['coupon_id','customer_id','coupon_code','expiry_date']);

// Fetch available vouchers
$vouchers = $db->get("customer_vouchers");

$voucherList = [];
foreach ($vouchers as $voucher) {
    $voucherList[] = [
        'voucher_id' => $voucher['id'],
        'voucher_image' => $voucher['voucher_photo'],
        'voucher_para_image' => $voucher['voucher_para_pic'],
        'voucher_image_hin' => $voucher['voucher_photo_hin'],
        'voucher_para_image_hin' => $voucher['voucher_para_pic_hin'],
    ];
}

echo json_encode([
    'success' => true,
    'data' => [
        'customerName' => $customer,
        // 'vouchersCode' => $vouchersCode,
        'voucherList' => $voucherList,
        'redeemCode' => $redeemcode,
    ]
]);
exit;
