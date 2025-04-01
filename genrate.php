<?php
require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$text = 'hi lagan';

$qr_code = QrCode::create($text);
$writer = new PngWriter();
$result = $writer->write($qr_code);
header("Content-Type:".$result->getMimeType());
echo $result->getString();
?>
