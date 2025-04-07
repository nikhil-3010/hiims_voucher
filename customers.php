<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/Costumers.php';
$costumers = new Costumers();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
    $page = 1;
}

// If filter types are not selected, we show latest added data first
if (!$filter_col) {
    $filter_col = 'id';
}
if (!$order_by) {
    $order_by = 'Desc';
}

// Get DB instance (i.e., instance of MYSQLiDB Library)
$db = getDbInstance();
$select = array('id', 'voucher_photo', 'voucher_para_pic','voucher_photo_hin', 'voucher_para_pic_hin','qr_code', 'expiry_date', 'created_at');

// Fetch data from the `customer_vouchers` table
$rows = $db->arraybuilder()->get('customer_vouchers', null, $select);

include BASE_PATH . '/includes/header.php';
?>

<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Customers</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_customer.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
                foreach ($costumers->setOrderingValues() as $opt_value => $opt_name):
                    ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                    echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                endforeach;
                ?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php echo ($order_by == 'Asc') ? 'selected' : ''; ?>>Asc</option>
                <option value="Desc" <?php echo ($order_by == 'Desc') ? 'selected' : ''; ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->

    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>
    </div>

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="30%">Voucher Photo</th>
                <th width="20%">Voucher Para Pic</th>
                <th width="30%">Voucher Photo(hindi)</th>
                <th width="20%">Voucher Para Pic (hindi)</th>
                <th width="20%">QR Code</th>
                <th width="15%">Expiry Date</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>

                <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo xss_clean($row['voucher_photo']); ?></td>
    <td><?php echo xss_clean($row['voucher_para_pic']); ?></td>
    <td><?php echo xss_clean($row['voucher_photo_hin']); ?></td>
    <td><?php echo xss_clean($row['voucher_para_pic_hin']); ?></td>

    <!-- Display QR Code Image -->
    <td>
        <img id="qr-code-<?php echo $row['id']; ?>" src="<?php echo $row['qr_code']; ?>" alt="QR Code" width="100" height="100">
        <br>
        <button class="btn btn-success mt-2" onclick="printQRCode('<?php echo $row['id']; ?>')">
            <i class="glyphicon glyphicon-print"></i> Print QR
        </button>
    </td>

    <td><?php echo xss_clean($row['expiry_date']); ?></td>
    <td>
        <a href="edit_customer.php?customer_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>">
            <i class="glyphicon glyphicon-trash"></i>
        </a>
    </td>
</tr>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_customer.php" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this row?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        
    </div>
    <!-- //Pagination -->
</div>
<script>
function printQRCode(id) {
    var qrCode = document.getElementById("qr-code-" + id).src;
    var newWindow = window.open('', '', 'width=300,height=300');
    newWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
    newWindow.document.write('<img src="' + qrCode + '" width="200" height="200">');
    newWindow.document.write('<script>window.onload = function() { window.print(); window.close(); }<\/script>');
    newWindow.document.write('</body></html>');
    newWindow.document.close();
}
</script>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
