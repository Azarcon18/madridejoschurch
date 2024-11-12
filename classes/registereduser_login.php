<?php
require_once '../config.php';
require_once('Master.php');

$master = new Master();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = $master->login_user();
    $response_data = json_decode($response, true);

    if ($response_data['status'] == 'success') {
        header("Location: ../index.php");
    } else {
        $_settings->set_flashdata('error', $response_data['msg']);
        header("Location: ../index.php");
    }
    exit();
}
?>
