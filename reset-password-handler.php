<?php
require_once('config.php');

// Check if token is provided
if (!isset($_GET['token'])) {
    die('Invalid request.');
}

$token = $_GET['token'];

// Verify the token
$stmt = $pdo->prepare("SELECT user_id, token_expired_at FROM registered_users WHERE token = :token");
$stmt->execute(['token' => $token]);
$user = $stmt->fetch();

if (!$user || new DateTime() > new DateTime($user['token_expired_at'])) {
    die('Invalid or expired token.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = 'Passwords do not match.';
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmt = $pdo->prepare("UPDATE registered_users SET password = :password, token = NULL, token_expired_at = NULL WHERE user_id = :user_id");
        $stmt->execute(['password' => $hashedPassword, 'user_id' => $user['user_id']]);

        // Redirect or show success message
        $_SESSION['success'] = 'Password has been reset successfully.';
        header('Location: login.php');
        exit;
    }
}
?>