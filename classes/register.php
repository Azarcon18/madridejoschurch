<?php

require '../vendor/autoload.php'; // Include PHPMailer's autoload file
require_once('../config.php'); // Include your database configuration

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterUser extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function register() {
        extract($_POST);
    
        $response = ['success' => false, 'message' => ''];
    
        // Check if email already exists
        $stmt = $this->conn->prepare('SELECT * FROM registered_users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    
        if ($user) {
            if ($user['status'] === 'active') {
                // Email is associated with an active account
                $response['success'] = false;
                $response['message'] = "This email is associated with a verified account.";
            } else {
                // Email exists but not active, send verification code
                $this->sendVerificationCode($email);
                $response['success'] = true;
                $response['message'] = "Verification code sent to your email.";
            }
        } else {
            // Proceed with registration
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO registered_users (name, user_name, email, password, phone_no, address, photo, status) 
                    VALUES (?, ?, ?, ?, ?, ?, 'defaultphoto.jpg', 'inactive')";
            
            $insertStmt = $this->conn->prepare($sql);
            $insertStmt->bind_param('ssssss', $name, $user_name, $email, $hashed_password, $phone_no, $address);
            
            if ($insertStmt->execute()) {
                // Send verification code after successful registration
                $this->sendVerificationCode($email);
                $response['success'] = true;
                $response['message'] = "Account successfully created. Verification code sent to your email.";
            } else {
                $response['message'] = "Registration failed. Please try again.";
            }
        }
    
        return $response;
    }

    private function sendVerificationCode($email) {
        // Generate a 5-digit verification code
        $verificationCode = rand(10000, 99999);
    
        // Save the code and expiration time to the database
        $expiryTime = date('Y-m-d H:i:s', strtotime('+15 minutes')); // Code expires in 15 minutes
        $updateStmt = $this->conn->prepare('UPDATE registered_users SET code = ?, code_expired_at = ? WHERE email = ?');
        $updateStmt->bind_param('iss', $verificationCode, $expiryTime, $email);
        $updateStmt->execute();
    
        // Send the verification code via email
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
    
            // Set email priority to high (important)
            $mail->Priority = 1;
            $mail->addCustomHeader('X-Priority', '1');
            $mail->addCustomHeader('X-MSMail-Priority', 'High');
            $mail->addCustomHeader('Importance', 'high');
    
            //Recipients
            $mail->setFrom('jagdonjohncarlo0714@gmail.com', 'ICP MADRIDEJOS');
            $mail->addAddress($email);
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = "
                <html>
                <head>
                    <style>
                        .email-container {
                            font-family: Arial, sans-serif;
                            max-width: 600px;
                            margin: auto;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            background-color: #f9f9f9;
                        }
                        .header {
                            background-color: #007bff;
                            color: white;
                            padding: 10px;
                            text-align: center;
                            border-radius: 5px 5px 0 0;
                        }
                        .content {
                            padding: 20px;
                            text-align: center;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 12px;
                            color: #666;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='header'>
                            <h2>Your Company Verification</h2>
                        </div>
                        <div class='content'>
                            <p>Dear User,</p>
                            <p>Your verification code is:</p>
                            <h3>{$verificationCode}</h3>
                            <p>This code will expire in 15 minutes.</p>
                            <p>Thank you for registering with us!</p>
                        </div>
                        <div class='footer'>
                            <p>&copy; 2023 Your Company. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";
            $mail->AltBody = "Dear User,\n\nYour verification code is: {$verificationCode}\n\nThis code will expire in 15 minutes.\n\nThank you for registering with us!";
    
            $mail->send();
        } catch (Exception $e) {
            error_log("Email send failed: " . $mail->ErrorInfo);
        }
    }
}

// AJAX Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $registerUser = new RegisterUser();
    $response = $registerUser->register();
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}