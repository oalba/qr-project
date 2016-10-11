<?php
    require __DIR__ . '/vendor/autoload.php';
    
    $nombre = $_POST["nombre"];
    
    //Leer un codigo QR
    $QRCodeReader = new Libern\QRCodeReader\QRCodeReader();
    $qrcode_text = $QRCodeReader->decode("codes/".$nombre.".png");
    echo $qrcode_text;
?>