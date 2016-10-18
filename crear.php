<?php
    require __DIR__ . '/vendor/autoload.php';
    
    //PHPMailer
    /*require ("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
    require ("vendor/phpmailer/phpmailer/class.phpmailer.php");*/
    
    //Mailgun
    use Mailgun\Mailgun;
    
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
            //Mailgun
            /*$domain = "sandbox*****************************.mailgun.org";
            $client = new \Http\Adapter\Guzzle6\Client(); 
            $mailgun = new \Mailgun\Mailgun('key-********************', $client);
            $result = $mailgun->sendMessage($domain, array(
                'from'	=> 'Me <oalbaab14dw@ikzubirimanteo.com>',
                'to'      => 'Usuario <'.$email.'>',
                'subject' => 'Código QR',
                'text'    => 'El código QR está adjunto'), 
                array(
                    'attachment' => array($fichero)
                ));
            unlink($fichero);
            header("location:index.html");*/
            
            //PHPMailer
            $mail = new PHPMailerOAuth;
            $mail->SMTPDebug = 2;                              
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            //$mail->oauthUserEmail = "odeialba@gmail.com";
            $mail->oauthUserEmail = "oalbaab14dw@ikzubirimanteo.com";
            $mail->oauthClientId = "222546505251-cpspv8tniv3teu966t6alieje3bri88c.apps.googleusercontent.com";
            //$mail->oauthClientId = "40698488631-29b4ok7mau3ppj1vp7rip6p220n8a95e.apps.googleusercontent.com";
            $mail->oauthClientSecret = "ojo96Twzq_QEO3JHRCgjuDl1";
            //$mail->oauthClientSecret = "OPwzUH7CbfFzybH6uPXFTzuE";
            //$mail->oauthRefreshToken = "1/0hQtSrGZb-1W2Nv-OYUD8ReAWTh8hNmHXl85lLLkYP4";
            $mail->oauthRefreshToken = "1/NHhUiIbUZf2yJd4p565u7iKHxueWM_VFUnZCXYvtbAlakjOUJ7JnR1TJD5Pjvr3T";
            //$mail->oauthRefreshToken = "1/HzueEt-X0DicXYoOabuXwLV2OX2rw_1Y40AqDFd-Kp8";
            //$mail->oauthRedirectUri = 'http://qr-project-oalba.c9users.io/vendor/phpmailer/phpmailer/get_oauth_token.php';
            //$mail->Username = 'oalbaab14dw@ikzubirimanteo.com';                
            //$mail->Password = '';                           
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
            }
        }
    }
?>