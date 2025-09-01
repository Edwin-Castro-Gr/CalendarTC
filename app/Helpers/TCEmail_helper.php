<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (!function_exists('sendEmail')) {
    function sendEmail($mailConfig) 
    {
        // Usa rutas absolutas
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/SMTP.php';

        $debugEnabled = filter_var(env('EMAIL_DEBUG', false), FILTER_VALIDATE_BOOLEAN);

        $email = new PHPMailer(true);

        // capturar debug en variable
        $debugOutput = '';
        $email->Debugoutput = function ($str, $level) use (&$debugOutput) {
            $debugOutput .= "[$level] $str\n";
        };

        try {
            $email->SMTPDebug = $debugEnabled ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
            $email->isSMTP();

            $host = trim((string) 'sandbox.smtp.mailtrap.io');
            $username = trim((string) '3ba7f6ee98c499');
            $password = trim((string) 'c453e1e0b8a832');
            $port = 2525;
            $encryption = strtolower(trim((string) 'tls'));

            $email->Host = $host;
            $email->SMTPAuth = true;
            $email->Username = $username;
            $email->Password = $password;

            // Mapear cifrado a constantes PHPMailer
            // if ($encryption === 'ssl') {
            //     $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            //     if (!$port) $port = 465;
            // } elseif ($encryption === 'tls' || $encryption === 'starttls') {
            //     $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            //     if (!$port) $port = 587;
            // } else {
            //     // Sin cifrado explícito
            //     $email->SMTPSecure = false;
            //     if (!$port) $port = 2525;
            // }

            $email->Port = $port;
            $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            //$email->SMTPAutoTLS = ($email->SMTPSecure !== false);
            $email->Timeout = 15;
            $email->SMTPKeepAlive = false;
            $email->CharSet = 'UTF-8';

            // Opciones SSL: sólo para entorno de desarrollo/pruebas (NO recomendado en producción)
            $email->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            // remitente y destinatario
            $email->setFrom($mailConfig['mail_from_email'], $mailConfig['mail_from_name']);
            $email->addAddress($mailConfig['mail_to'], $mailConfig['mail_toName'] ?? '');

            $email->isHTML(true);
            $email->Subject = $mailConfig['mail_subject'];
            $email->Body = $mailConfig['mail_body'];
            $email->AltBody = strip_tags($mailConfig['mail_body']);

            if ($email->send()) {
                log_message('info', 'Email enviado exitosamente a: ' . $mailConfig['mail_to']);
                if ($debugEnabled) log_message('debug', "PHPMailer debug:\n" . $debugOutput);
                return true;
            } else {
                log_message('error', 'Error al enviar email: ' . $email->ErrorInfo);
                if ($debugEnabled) log_message('debug', "PHPMailer debug:\n" . $debugOutput);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Excepción PHPMailer: ' . $e->getMessage());
            if ($debugOutput) log_message('debug', "PHPMailer debug:\n" . $debugOutput);
            return false;
        }
    }
}
