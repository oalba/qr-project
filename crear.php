<?php
    require __DIR__ . '/vendor/autoload.php';
    
    //require 'PHPMailerAutoload.php';
    //require("class.phpmailer.php");
    
    $nombre = $_POST["nombre"];
    $texto = $_POST["texto"];
    //$email = $_POST["email"];
    //$pass = $_POST["pass"];
    
    //Crear un codigo QR
    $renderer = new BaconQrCode\Renderer\Image\Png();
    $renderer->setHeight(256);
    $renderer->setWidth(256);
    $writer = new BaconQrCode\Writer($renderer);
    $writer->writeFile($texto, 'codes/'.$nombre.'.png');
    
    $fichero = 'codes/'.$nombre.'.png';

    if (file_exists($fichero)) {
        if ($_POST['action'] == 'Descargar') {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fichero));
            readfile($fichero);
            unlink($fichero);
            exit;
            header("location:index.html");
        } else if ($_POST['action'] == 'Mostrar') {
            header('Content-Type: image/png');
            header('Content-Disposition: inline; filename='.$fichero);
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            readfile($fichero);
            unlink($fichero);
        } /*else if ($_POST['action'] == 'Email') {
            $mail = new PHPMailer;
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = false;                               // Enable SMTP authentication
            $mail->Username = 'odeialba@yahoo.es';                 // SMTP username
            $mail->Password = $pass;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->setFrom('odeialba@yahoo.es', 'Odei Alba');
            //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress($email);               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            $mail->addAttachment($fichero);         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Código QR';
            $mail->Body    = 'El código QR está adjunto';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                unlink($fichero);
            } else {
                echo 'Message has been sent';
                unlink($fichero);
            }
        }*/
    }
?>