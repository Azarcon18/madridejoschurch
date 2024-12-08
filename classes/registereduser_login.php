<?php
// Include the session and database configuration
include '../config.php';
session_start(); // Start the session

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = null;
}

$lockout_duration = 180; // 3 minutes in seconds
$current_time = time();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check lockout status
    if ($_SESSION['lockout_time'] && $current_time < $_SESSION['lockout_time']) {
        $remaining_time = $_SESSION['lockout_time'] - $current_time;
        $_SESSION['error'] = "Too many failed attempts. Try again after {$remaining_time} seconds.";
        header("Location: ../login.php");
        exit;
    }

    // Retrieve email and password from POST data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare SQL statement to prevent SQL injection
        $sql = "SELECT user_id, name, user_name, email, password FROM registered_users WHERE email = ? AND status = 'active' LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Successful login: reset login attempts and lockout time
                $_SESSION['login_attempts'] = 0;
                $_SESSION['lockout_time'] = null;

                // Store user details in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];

                $stmt->close();
                $conn->close();

                // Redirect to the home page
                header("Location: http://localhost/immaculateconception/");
                exit;
            } else {
                // Invalid password
                $_SESSION['login_attempts']++;
            }
        } else {
            // No active user found with these credentials
            $_SESSION['login_attempts']++;
        }

        $stmt->close();
        $conn->close();

        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lockout_time'] = $current_time + $lockout_duration;
            $_SESSION['login_attempts'] = 0; // Reset attempts after lockout
            $_SESSION['error'] = "Too many failed attempts. Please try again in 3 minutes.";
        } else {
            $remaining_attempts = 3 - $_SESSION['login_attempts'];
            $_SESSION['error'] = "Invalid email or password. You have {$remaining_attempts} attempt(s) left.";
        }

        header("Location: ../login.php");
        exit;
    } else {
        // Missing email or password
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../login.php");
        exit;
    }
} else {
    // If the request method is not POST, redirect to the login page
    header("Location: ../login.php");
    exit;
}

$conn->close();
?>
