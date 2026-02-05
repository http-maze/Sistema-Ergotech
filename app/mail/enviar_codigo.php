<?php
/*
    Función para enviar el código 2FA por correo
    Usa PHPMailer (recomendado)
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

function enviarCodigo($correo, $codigo) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tucorreo@gmail.com';
        $mail->Password = 'CLAVE_DE_APLICACION';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('tucorreo@gmail.com', 'Sistema');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Código de verificación';
        $mail->Body = "
            <h2>Verificación en dos pasos</h2>
            <p>Tu código es:</p>
            <h1>$codigo</h1>
            <p>Este código expira en 5 minutos.</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        // En proyecto escolar, solo ignoramos error
    }
}
