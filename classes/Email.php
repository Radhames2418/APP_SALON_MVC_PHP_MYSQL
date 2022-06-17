<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {

        //Crear el objeto de email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'f30bcc3bcdff96';
            $mail->Password = '40fd5e65e5b7e3';

            //Recipients
            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');


            //Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Confirma tu cuenta';
            $mail->Body    = '<html>
            
            <p><strong>Hola ' . $this->nombre . ' </strong> Has creado tu cuenta en App salon, solo debe confirmala presionando el siguiente enlace</p>
            
            <p>Preciona aqui: <a href="http:localhost:5000/confirmar-cuenta?token=' . $this->token  . ' ">Confirmar cuenta</a></p>

            <p>Si tu no solicistaste esta cuenta, puede ignorar el mensaje</p>
            
            </html>';

            $mail->AltBody = 'Confirmacion de cuenta';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function enviarInstrucciones()
    {

        //Crear el objeto de email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'f30bcc3bcdff96';
            $mail->Password = '40fd5e65e5b7e3';

            //Recipients
            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');


            //Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Restablece tu password';
            $mail->Body    = '<html>
            
            <p><strong>Hola ' . $this->nombre . ' </strong> Has solicitado restablecer tu password, presiona el siguiente enlace para restablecerlo</p>
            
            <p>Preciona aqui: <a href="http:localhost:5000/recuperar?token=' . $this->token  . ' ">Restablecer Password</a></p>

            <p>Si tu no solicistaste este cambio, puede ignorar el mensaje</p>
            
            </html>';

            $mail->AltBody = 'Confirmacion de cuenta';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
