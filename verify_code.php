<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('config.php'); // Include your database configuration

// Retrieve the code from the POST request
$code = intval(implode("", $_POST['code']));

// Check if the code is valid
$sql = "SELECT user_id FROM registered_users WHERE code = ? AND code_expired_at > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Code is valid, update the status
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];

    $update_sql = "UPDATE registered_users SET status = 'active' WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $user_id);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        // Clear the code after successful update
        $clear_code_sql = "UPDATE registered_users SET code = NULL WHERE user_id = ?";
        $clear_code_stmt = $conn->prepare($clear_code_sql);
        $clear_code_stmt->bind_param("i", $user_id);
        $clear_code_stmt->execute();

        if ($clear_code_stmt->affected_rows > 0) {
            echo "Account verified and code cleared successfully!";
        } else {
            echo "Account verified, but failed to clear the code.";
        }
    } else {
        echo "Failed to update account status.";
    }
} else {
    echo "Invalid or expired code.";
}

// Close the connection
$conn->close();
?>