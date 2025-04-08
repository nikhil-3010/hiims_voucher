<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';
require "vendor/autoload.php";


$db = getDbInstance();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $db->where('link', '%' . $search . '%', 'LIKE');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $link = trim($_POST['link']);

    if (!empty($link)) {
        $data_to_store = [
            'link' => $link,
            'status' => 1, // default status is active
            'created_at' => date('Y-m-d')
        ];

        $last_id = $db->insert('whatsapp_links', $data_to_store);

        if ($last_id) {
            $_SESSION['success'] = "Link added successfully!";
            header("Location: " . $_SERVER['PHP_SELF']); // refresh to show updated list
            exit();
        } else {
            echo 'Insert failed: ' . $db->getLastError();
            exit();
        }
    } else {
        echo 'Link field is required.';
        exit();
    }
}

if (isset($_GET['toggle_id'])) {
    $id = (int)$_GET['toggle_id'];
    $current = $db->where('id', $id)->getOne('whatsapp_links', 'status');
    if ($current) {
        $newStatus = $current['status'] ? 0 : 1;
        $db->where('id', $id)->update('whatsapp_links', ['status' => $newStatus]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch all records
$links = $db->get('whatsapp_links');

$edit = false;
require_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
        
        <div class="col-lg-12">
            <h2 class="page-header">Add WhatsApp Link</h2>
        </div>
    </div>

    <form class="form" action="" method="post" id="customer_form">
        <fieldset>
            <div class="form-group">
                <label for="linkId">New WhatsApp Link*</label>
                <input type="text" name="link" class="form-control" required id="linkId" placeholder="Enter WhatsApp Group Link">
            </div> 

            <div class="form-group text-center">
                <button type="submit" class="btn btn-warning">Save <span class="glyphicon glyphicon-send"></span></button>
            </div>            
        </fieldset>
    </form>

    <!-- Divider -->
    <hr>

    <div class="row">
        <div class="col-lg-12">
        <form method="GET" class="form-inline mb-3">
    <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Search link..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary ml-2">Search</button>
        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-outline-secondary ml-1">Reset</a>
    </div>
</form>

            <h3>Saved WhatsApp Links</h3>
            <?php if (!empty($links)) : ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Link</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>On/Off</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php $i = 1; foreach ($links as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <?php if ($row['status']): ?>
                        <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank"><?= htmlspecialchars($row['link']) ?></a>
                    <?php else: ?>
                        <span class="text-muted"><?= htmlspecialchars($row['link']) ?> (Disabled)</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <?= $row['status'] ? 'Active' : 'Inactive' ?>
                </td>
                <td>
                    <a href="?toggle_id=<?= $row['id'] ?>" class="btn btn-sm <?= $row['status'] ? 'btn-danger' : 'btn-success' ?>">
                        <?= $row['status'] ? 'Disable' : 'Enable' ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
                </table>
            <?php else : ?>
                <p>No links found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
