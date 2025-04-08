<?php
session_start();
require_once './config/config.php';

$db = getDbInstance();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db->where('status', 1);
    $db->orderBy('RAND()');
    $link = $db->getOne('whatsapp_links', ['link']);

    if ($link) {
        echo json_encode([
            'success' => true,
            'link' => $link['link']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No active links available.'
        ]);
    }
    exit;
}
