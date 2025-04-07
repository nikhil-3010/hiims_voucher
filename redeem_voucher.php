<?php
session_start();

require_once './config/config.php';  

$customerID  = $_POST['customerID']
$enteredCode = $_POST['enteredCode'];
$voucherID   = $_POST['voucherID'];

if (!$voucherID || !$enteredCode || !$customerID) {
    echo json_encode(['success' => false, 'message' => 'Invalid request. Missing parameters.']);
    exit;
}

$db = getDbInstance();

$db->where('coupon_code', $enteredCode);
$codedata = $db->getOne('coupen_codes')

if (!$codeData) {
    echo json_encode(['success' => false, 'message' => 'Invalid coupon code.']);
    exit;
}

if (!empty($codeData['coupon_id'])) {
    echo json_encode(['success' => false, 'message' => 'This coupon code has already been redeemed.']);
    exit;
}

$expiryDate = date('Y-m-d H:i:s', strtotime('+30 days'));

$updateData = [
    'customer_id' => $customerID,
    'coupon_id' => $voucherID,
    'expiry_date' => $expiryDate
];

$db->where('coupon_code', $enteredCode);
$updated = $db->update('coupen_codes', $updateData);

if ($updated) {
    echo json_encode([
        'success' => true,
        'message' => 'Coupon code redeemed successfully!',
        'expiry_date' => $expiryDate
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to redeem the coupon code. Please try again.'
    ]);
}
exit;


?>