<?php
require_once('../config.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Check if the user exists and is verified
$query = "SELECT * FROM registered_users WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        if ($user['is_verified'] == 1) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['success'] = "Login successful!";
            header('Location: ../dashboard.php');
        } else {
            $_SESSION['error'] = "Please verify your email before logging in.";
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['error'] = "Invalid password.";
        header('Location: ../index.php');
    }
} else {
    $_SESSION['error'] = "No account found with this email.";
    header('Location: ../index.php');
}
?>
