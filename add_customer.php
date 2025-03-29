<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

// Handle POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_dir = './assets/images/';  // Add trailing slash
    $voucher_pic_path = '';
    $para_pic_path = '';
    $expiry_date = '';

    // Handle Voucher Picture Upload
    if (isset($_FILES['voucher_photo']) && $_FILES['voucher_photo']['error'] === UPLOAD_ERR_OK) {
        $file_name =  basename($_FILES['voucher_photo']['name']);
        $voucher_pic_path = $upload_dir . $file_name;
        move_uploaded_file($_FILES['voucher_photo']['tmp_name'], $voucher_pic_path);
    } else {    
        echo json_encode(['success' => false, 'message' => 'Error uploading voucher picture.']);
        exit();
    }

    // Handle Para Picture Upload
    if (isset($_FILES['voucher_para_pic']) && $_FILES['voucher_para_pic']['error'] === UPLOAD_ERR_OK) {
        $file_name1 = basename($_FILES['voucher_para_pic']['name']);
        $para_pic_path = $upload_dir . $file_name;

        move_uploaded_file($_FILES['voucher_para_pic']['tmp_name'], $para_pic_path);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading para picture.']);
        exit();
    }

    //expiry date
  

    // Prepare data for database insertion
    $db = getDbInstance();
    $data_to_store = array_filter($_POST);
    $data_to_store['voucher_photo'] = $file_name;        // Ensure column matches DB
    $data_to_store['voucher_para_pic'] = $file_name1;
    $data_to_store['created_at'] = date('Y-m-d ');
    $data_to_store['expiry_date'] = date('Y-m-d', strtotime('+30 days', strtotime($data_to_store['created_at'])));
    print_r($data_to_store['expiry_date']);die;
    
   

    $last_id = $db->insert('customer_vouchers', $data_to_store);

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
