<?php
    require __DIR__ . '/vendor/autoload.php';
    
    $nombre = $_POST["nombre"];
    $texto = $_POST["texto"];
    
    //Crear un codigo QR
    $renderer = new BaconQrCode\Renderer\Image\Png();
    $renderer->setHeight(256);
    $renderer->setWidth(256);
    $writer = new BaconQrCode\Writer($renderer);
    $writer->writeFile($texto, 'codes/'.$nombre.'.png');
    header("location:index.html");
?>