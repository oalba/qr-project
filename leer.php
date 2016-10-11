<?php
    require __DIR__ . '/vendor/autoload.php';
    
    $nombre = $_FILES['nombre'];
    if(!empty($_FILES['nombre']['name'])){
        $temp = explode(".", $_FILES["nombre"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        move_uploaded_file($_FILES["nombre"]["tmp_name"], "codes/" . $newfilename);
        $code = $newfilename;
        
        //Leer un codigo QR
        $QRCodeReader = new Libern\QRCodeReader\QRCodeReader();
        $qrcode_text = $QRCodeReader->decode("codes/".$code);
        echo $qrcode_text;
        unlink("codes/".$code);
        echo "<br/><a href='index.html'>Volver</a>";
    } else {
        header("location:index.html");
    }
?>