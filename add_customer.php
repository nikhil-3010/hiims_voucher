<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';
require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Handle POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_dir = './assets/images/';  // Add trailing slash
    $voucher_pic_path = '';
    $para_pic_path = '';
    $expiry_date = '';

    // Handle Voucher Picture Upload
    if (isset($_FILES['voucher_photo']) && $_FILES['voucher_photo']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['voucher_photo']['name']);
        $voucher_pic_path = $upload_dir . $file_name;
        move_uploaded_file($_FILES['voucher_photo']['tmp_name'], $voucher_pic_path);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading voucher picture.']);
        exit();
    }

    // Handle Para Picture Upload
    if (isset($_FILES['voucher_para_pic']) && $_FILES['voucher_para_pic']['error'] === UPLOAD_ERR_OK) {
        $file_name1 = basename($_FILES['voucher_para_pic']['name']);
        $para_pic_path = $upload_dir . $file_name1;  // Corrected variable ($file_name1)
        move_uploaded_file($_FILES['voucher_para_pic']['tmp_name'], $para_pic_path);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading para picture.']);
        exit();
    }

    if (isset($_FILES['voucher_photo_hindi']) && $_FILES['voucher_photo_hindi']['error'] === UPLOAD_ERR_OK) {
        $file_name2 = basename($_FILES['voucher_photo_hindi']['name']);
        $para_pic_path = $upload_dir . $file_name1;  // Corrected variable ($file_name1)
        move_uploaded_file($_FILES['voucher_photo_hindi']['tmp_name'], $para_pic_path);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading para picture.']);
        exit();
    }

    // Prepare data for database insertion
    $db = getDbInstance();
    $data_to_store = array_filter($_POST);
    $data_to_store['voucher_photo'] = $file_name;        // Ensure column matches DB
    $data_to_store['voucher_para_pic'] = $file_name1;
    $data_to_store['voucher_photo_hin'] = $file_name2;  
    $data_to_store['voucher_para_pic_hin'] = $file_name1;

    $data_to_store['created_at'] = date('Y-m-d');
    // $data_to_store['expiry_date'] = date('Y-m-d', strtotime('+30 days', strtotime($data_to_store['created_at'])));

    // Generate a Unique QR Code Value and Save it in the DB
    $qr_code_value = uniqid('voucher_', true);  // Generate unique identifier
    $data_to_store['qr_code'] = $qr_code_value;  // Save QR value (not image path yet)

    // Insert the data into the database
    $last_id = $db->insert('customer_vouchers', $data_to_store);
    $base_url = 'https://hiims.in/';
    $qr_code = QrCode::create($base_url . $last_id);

    if ($last_id) {
        $writer = new PngWriter();
        $result = $writer->write($qr_code);
        $qr_code_path = $upload_dir . 'qr_code_' . $last_id . '.png';
        file_put_contents($qr_code_path, $result->getString());

        // Update the database with the QR code image path
        $db->where('id', $last_id)->update('customer_vouchers', ['qr_code' => $qr_code_path]);
    }

    if ($last_id) {
        $_SESSION['success'] = "Customer added successfully!";
        header('location: customers.php');
        exit();
    } else {
        echo 'Insert failed: ' . $db->getLastError();
        exit();
    }
}

// Declare $edit = false for create form
$edit = false;
require_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add vouchers</h2>
        </div>
    </div>
    <form class="form" action="" method="post" id="customer_form" enctype="multipart/form-data">
        <?php include_once('./forms/customer_form.php'); ?>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#customer_form").validate({
        rules: {
            f_name: {
                required: true,
                minlength: 3
            },
            l_name: {
                required: true,
                minlength: 3
            }
        }
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>
