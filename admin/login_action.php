<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaSecret = 'your-secret-key';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify the token with Google
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($verifyResponse);

    if ($responseData->success && $responseData->score > 0.5) {
        // Proceed with login validation
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Your authentication logic here

        // Example: Redirect on success
        header('Location: dashboard.php');
    } else {
        // If reCAPTCHA fails
        echo 'reCAPTCHA verification failed. Please try again.';
    }
} else {
    header('Location: login.php');
    exit;
}
?>
