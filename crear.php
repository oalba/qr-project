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
    
    $fichero = 'codes/'.$nombre.'.png';

    if (file_exists($fichero)) {
        if ($_POST['action'] == 'Mostrar') {
            header('Content-Type: image/png');
            header('Content-Disposition: inline; filename='.$fichero);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            readfile($fichero);
            unlink($fichero);
        } else if ($_POST['action'] == 'Descargar') {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fichero));
            readfile($fichero);
            unlink($fichero);
            header("location:index.html");
        }
    }
?>