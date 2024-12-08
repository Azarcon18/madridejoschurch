<?php
require_once '../config.php';
require_once('Master.php');

$master = new Master();

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($master->login_user($email, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = 'Incorrect email or password';
        header('Location: login.php');
        exit();
    }
}
?>
