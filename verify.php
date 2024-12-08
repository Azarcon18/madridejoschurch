<?php
require_once('config.php');

// Get the verification code from the URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Check if the code exists in the database
    $query = "SELECT * FROM registered_users WHERE verification_code = '$code'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Update the user as verified
        $update_query = "UPDATE users SET is_verified = 1, verification_code = NULL WHERE verification_code = '$code'";
        if ($conn->query($update_query)) {
            $_SESSION['success'] = "Your email has been verified successfully.";
        } else {
            $_SESSION['error'] = "Failed to verify your email.";
        }
    } else {
        $_SESSION['error'] = "Invalid verification code.";
    }
} else {
    $_SESSION['error'] = "No verification code provided.";
}

header('Location: index.php');
?>
