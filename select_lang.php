<?php
if (isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];
    setcookie('language', $_POST['language'], time() + (86400 * 30), "/"); // Store for 30 days
    echo json_encode(['status' => 'success', 'language' => $_POST['language']]);
    exit;
}
?>

