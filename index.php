<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// $selectedLanguage = 'English';

if (!isset($_SESSION['language'])) {
    if (isset($_COOKIE['language'])) {
        $_SESSION['language'] = $_COOKIE['language'];
    } else {
        $_SESSION['language'] = 'English'; // Default language
    }
}


$selectedLanguage = $_SESSION['language'];
// print_r($selectedLanguage);


include BASE_PATH.'/includes/header.php';
if(!$selectedLanguage) {
   include BASE_PATH.'/select_lang.php';
}

// include_once BASE_PATH.'/select_lang.php'; 

if($selectedLanguage == 'English') {
    include BASE_PATH.'/signin_eng.php';
} else {
    include BASE_PATH.'/login.php';
}











include BASE_PATH.'/includes/footer.php'; ?>
