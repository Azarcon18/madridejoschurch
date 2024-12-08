<?php
require_once('config.php');
require 'vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT user_id FROM registered_users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $token_expired_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour

        // Update the database with the token and expiration time
        $stmt = $pdo->prepare("UPDATE registered_users SET token = :token, token_expired_at = :token_expired_at WHERE email = :email");
        $stmt->execute(['token' => $token, 'token_expired_at' => $token_expired_at, 'email' => $email]);

        // Send the reset email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your domain's SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'jagdonjohncarlo0714@gmail.com'; // SMTP username
            $mail->Password = 'wlyl kbyt mjam fhzv'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    

            //Recipients
            $mail->setFrom('jagdonjohncarlo0714@gmail.com', 'ICP MADRIDEJOS');
            $mail->addAddress($email);

            // Content
            $resetLink = "http://localhost/immaculateconception/reset-password.php?token=$token";
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo 'An email has been sent to your email address with instructions to reset your password.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No account found with that email address.";
    }
}
?>