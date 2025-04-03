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
$customer = $db->getOne('user_info', ['name', 'voucher_id', 'vouchers_code']); 

if (!$customer) {
    echo json_encode(['success' => false, 'message' => 'No customer found with this phone number.']);
    exit;
}

$customerName = $customer['name'];
$voucherId = $customer['voucher_id'];
$vouchersCode = $customer['vouchers_code'];

// Fetch available vouchers
$vouchers = $db->get("customer_vouchers");

$voucherList = [];
foreach ($vouchers as $voucher) {
    $voucherList[] = [
        'voucher_id' => $voucher['id'],
        'voucher_image' => $voucher['voucher_photo'],
        'voucher_para_image' => $voucher['voucher_para_pic']
    ];
}

echo json_encode([
    'success' => true,
    'data' => [
        'customerName' => $customerName,
        'vouchersCode' => $vouchersCode,
        'voucherList' => $voucherList
    ]
]);
exit;
