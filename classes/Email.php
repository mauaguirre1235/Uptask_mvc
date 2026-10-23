<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'a1d64a0af1781b';
        $mail->Password = 'd687d9b7772b68';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'Uptask.com');
        $mail->Subject = 'Confirma tu cuenta';

        // set HTML 
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Uptask , solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar?token=" . 
        $this->token. "'>Confirmar cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // enviar el email 
        $mail->send();



    }
}