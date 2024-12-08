<?php


require_once('config.php'); // Include your database configuration


// User login handling (if this part is used in the same file)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(string: $_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare SQL statement
        $sql = "SELECT user_id, name, user_name, email, password FROM registered_users WHERE email = ? AND status = 'active' LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store user details in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_photo'] = $user['photo'];

                // Redirect to dashboard or another page
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "No active user found with these credentials.";
        }
        $stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}
?>
