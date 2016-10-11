<?php
require __DIR__ . '/vendor/autoload.php';

//Crear un codigo QR
$renderer = new BaconQrCode\Renderer\Image\Png();
$renderer->setHeight(256);
$renderer->setWidth(256);
$writer = new BaconQrCode\Writer($renderer);
$writer->writeFile('Hello World!', 'qrcode.png');

//Leer un codigo QR
$QRCodeReader = new Libern\QRCodeReader\QRCodeReader();
$qrcode_text = $QRCodeReader->decode("qrcode.png");
echo $qrcode_text;
?>