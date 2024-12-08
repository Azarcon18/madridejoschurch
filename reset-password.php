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

<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>

<body class="light-mode">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="container-fluid mb-5 mt-2">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4">
                <h3 class="text-center">Reset Password</h3>
                <hr>
                <form id="reset-password-form" action="" method="post">
                    <div class="form-group">
                        <label for="password" class="control-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control form" id="password" name="password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePasswordVisibility('password', this)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="control-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control form" id="confirm_password" name="confirm_password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePasswordVisibility('confirm_password', this)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 mt-3">
                        <button type="submit" class="btn btn-primary float-end">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, toggleButton) {
            const passwordField = document.getElementById(fieldId);
            const icon = toggleButton.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <?php require_once('inc/footer.php'); ?>
</body>
</html>