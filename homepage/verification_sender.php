<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Change the directory
require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';



function send_verification($mailer, $email_address, $Verification_Token)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'scholarshipsystem1@gmail.com';
        $mail->Password   = 'tmpn yszw tasf wfue';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom("scholarshipsystem1@gmail.com", $mailer);
        $mail->addAddress($email_address, 'student');
        $mail->isHTML(true);
        $mail->Subject = "Email Verification From Scholarship System";

        // Construct dynamic base URL
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['SERVER_NAME'];
        $port = $_SERVER['SERVER_PORT'];
        $baseUrl = $protocol . "://" . $host . ($port != '80' && $port != '443' ? ":$port" : '') . dirname($_SERVER['SCRIPT_NAME']);

        // Ensure the base URL ends with a slash
        if (substr($baseUrl, -1) != '/') {
            $baseUrl .= '/';
        }

        // Generate the verification link
        $verificationLink = $baseUrl . "email_verification.php?token=$Verification_Token";

        // Debugging: print the verification link
        error_log("Verification Link: $verificationLink");

        $email_Template = "<h2>Account Registration Confirmation</h2>
                   <p>Dear Valued User,</p>
                   <p>Thank you for registering with the Scholarship System. To complete your registration process, please verify your email address by clicking the link below:</p>
                   <p><a href='$verificationLink'>Verify Your Email Address</a></p>
                   <p>If you did not create an account with us, please disregard this message. For any assistance or inquiries, feel free to contact our support team.</p>
                   <p>Best regards,</p>
                   <p>The Scholarship System Team</p>";


        $mail->Body = $email_Template;

        $mail->send();
    } catch (Exception $e) {
    }
}

function otp_verification($otp_value, $email_address)
{

    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'scholarshipsystem1@gmail.com';
        $mail->Password   = 'tmpn yszw tasf wfue';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom("scholarshipsystem1@gmail.com", "Mailer");
        $mail->addAddress($email_address, 'student');
        $mail->isHTML(true);
        $mail->Subject = "Password Reset From Scholarship System";


        $email_Template = "<h2>Password Change Verification</h2>
        <p>Dear User,</p>
        <p>We have received a request to change the password for your account. To proceed with the password change, please use the one-time password (OTP) provided below:</p>
        <h1>$otp_value</h1>
        <p>If you did not request this password change, please disregard this message. For any assistance or questions, please contact our support team.</p>
        <p>Best regards,</p>
        <p>The Scholarship System Team</p>";

        $mail->Body = $email_Template;

        $mail->send();
    } catch (Exception $e) {
    }
}
