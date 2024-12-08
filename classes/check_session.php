<?php
session_start();
header('Content-Type: application/json');

$response = [
    'session_active' => isset($_SESSION['user_id']) ? true : false,
    'message' => isset($_SESSION['user_id']) ? 'Session active' : 'No active session'
];
echo json_encode($response);
?>