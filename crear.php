<?php
    require __DIR__ . '/vendor/autoload.php';
    
    /*require ("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
    require ("vendor/phpmailer/phpmailer/class.phpmailer.php");*/
    use Mailgun\Mailgun;
    
    //require 'PHPMailerAutoload.php';
    //require("class.phpmailer.php");
    
    $nombre = $_POST["nombre"];
    $texto = $_POST["texto"];
    $email = $_POST["email"];
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
        } else if ($_POST['action'] == 'Email') {
            // Instantiate the client.
            $mgClient = new Mailgun('key-**********************************');
            $domain = "sandbox*********************************.mailgun.org";
            // Make the call to the client.
            $result = $mgClient->sendMessage($domain, array(
                // 'from'    => 'Excited User <mailgun@sandbox......mailgun.org>',
                'from'	=> 'Me <**************************************>',
                'to'      => 'Baz <'.$email.'>',
                'subject' => 'Hello',
                'text'    => 'Testing some Mailgun awesomness!'
                //'attachment' => $fichero
            ));
            unlink($fichero);
            /*$mail = new PHPMailer;
            $mail->SMTPDebug = 2;                              
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'oalbaab14dw@ikzubirimanteo.com';                
            $mail->Password = $pass;                           
            $mail->SMTPSecure = 'tls';                           
            $mail->Port = 587;                                    
            $mail->From = "oalbaab14dw@ikzubirimanteo.com";
            $mail->FromName = "Odei Alba";
            $mail->addAddress($email, "Odei");              
            $mail->addAttachment($fichero);        
            $mail->isHTML(true);                                
            $mail->Subject = 'Código QR';
            $mail->Body    = 'El código QR está adjunto';
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                unlink($fichero);
            } else {
                echo 'Message has been sent';
                unlink($fichero);
            }*/
        }
    }
?>