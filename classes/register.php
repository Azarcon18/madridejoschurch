<?php
require_once '../config.php';
require_once('Master.php');

$master = new Master();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = $master->save_user();
    $response_data = json_decode($response, true);

    if ($response_data['status'] == 'success') {
        header("Location: ../login.php");
    } else {
        header("Location: error.php");
    }
    exit();
}
?>
