<?php

namespace App\Logic;
use App\Models\Setting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    public function send($body){
        $mail = new PHPMailer(true);
        $setting = Setting::all()->keyBy('key')->toArray();

        try {

            $mail->SMTPDebug = 1;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = $setting['email_host']['value'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $setting['send_email']['value'];                     // SMTP username
            $mail->Password   = $setting['email_password']['value'];                               // SMTP password                                // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->setFrom($setting['send_email']['value'], $setting['send_email']['value']);                         // TCP port to connect to
            $mail->addAddress($setting['receiver_email']['value'], $setting['receiver_email']['value']);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = '您有新的客户信息到达';
            $mail->Body    = $body;
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
