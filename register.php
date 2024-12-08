<?php
require_once('../config.php');

// Retrieve form data
$name = $_POST['name'];
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone_no = $_POST['phone_no'];
$address = $_POST['address'];
$status = $_POST['status'];
$verification_code = md5(uniqid(rand(), true)); // Unique code for verification

// Insert user into the database
$query = "INSERT INTO registered_users (name, user_name, email, password, phone_no, address, status, verification_code, is_verified) 
          VALUES ('$name', '$user_name', '$email', '$password', '$phone_no', '$address', '$status', '$verification_code', 0)";
$result = $conn->query($query);

if ($result) {
    // Send verification email
    $subject = "Email Verification";
    $message = "Hello $name, \n\nPlease verify your email by clicking the link below:\n";
    $message .= "https://icpmadridejos.com/verify.php?code=$verification_code";
    $headers = "From: John Carlo Jagdon";

    if (mail($email, $subject, $message, $headers)) {
        $_SESSION['success'] = "Account created successfully. Please check your email for verification.";
    } else {
        $_SESSION['error'] = "Account created, but failed to send verification email.";
    }
} else {
    $_SESSION['error'] = "Failed to create account.";
}

header('Location: ../index.php');
?>
