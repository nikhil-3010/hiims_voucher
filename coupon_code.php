<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$DB = getDbInstance();

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of records
$total = $DB->getValue("
    coupen_codes c 
    JOIN customer_vouchers v ON c.coupon_id = v.id 
    JOIN user_info u ON c.customer_id = u.id
", "count(*)");

// Set page limit
$DB->pageLimit = $limit;

// Fetch paginated coupon data with required columns
$coupons = $DB->arraybuilder()->paginate("
    coupen_codes c 
    JOIN customer_vouchers v ON c.coupon_id = v.id 
    JOIN user_info u ON c.customer_id = u.id
", $page, "
    c.expiry_date, 
    c.coupon_code, 
    v.id as coupan_id, 
    v.voucher_photo, 
    v.voucher_para_pic, 
    v.qr_code, 
    u.id as customer_id, 
    u.name
");

$total_pages = ceil($total / $limit);
?>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .coupon-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-weight: 600;
            color: #343a40;
        }
        .table th {
            background-color: #0d6efd;
            color: white;
        }
        .no-records {
            font-size: 1.2rem;
            color: #dc3545;
        }
        .pagination {
            justify-content: center;
        }
        img.voucher-img {
            max-height: 50px;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="coupon-container">
        <h2 class="text-center mb-4">🎟️ Available Coupon Codes</h2>

        <?php if (!empty($coupons)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>Expiry Date</th>
                            <th>Coupon Code</th>
                            <th>Coupon ID</th>
                            <th>Voucher Photo</th>
                            <th>Voucher Para Pic</th>
                            <th>QR Code</th>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $row): ?>
                            <tr>
                            <td><?= htmlspecialchars($row['expiry_date'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['coupon_code']); ?></td>
                                <td><?= htmlspecialchars($row['coupan_id']); ?></td>
                                <td>
                                    <?php if (!empty($row['voucher_photo'])): ?>
                                        <img src="./assets/images/<?= htmlspecialchars($row['voucher_photo'] ?? '') ?>" alt="Photo" class="voucher-img">

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['voucher_para_pic'])): ?>
                                        <img src="./assets/images/<?= htmlspecialchars($row['voucher_para_pic'] ?? '') ?>" alt="Photo" class="voucher-img">

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['qr_code'])): ?>
                                        <img src="<?= htmlspecialchars($row['qr_code']); ?>" alt="QR Code" class="voucher-img">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['customer_id']); ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination mt-4 justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $page - 1; ?>" tabindex="-1">Previous</a>
                    </li>

                    <?php
                        $adjacents = 1;
                        $start = max(1, $page - $adjacents);
                        $end = min($total_pages, $page + $adjacents);

                        if ($page <= 2) {
                            $end = min(3, $total_pages);
                        }
                        if ($page >= $total_pages - 1) {
                            $start = max(1, $total_pages - 2);
                        }

                        for ($i = $start; $i <= $end; $i++):
                    ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Button -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php else: ?>
            <p class="text-center no-records">🚫 No records found in <strong>coupen_codes</strong>.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
