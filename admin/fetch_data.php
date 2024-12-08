<?php
require_once('../config.php');
date_default_timezone_set('Asia/Manila'); // Adjust the timezone as needed
$startOfMonth = date('Y-m-01');
$endOfMonth = date('Y-m-t');

$response = array('success' => false, 'data' => array(), 'message' => '');

$qry = $conn->query("SELECT DATE(schedule) as date, COUNT(*) as total 
                     FROM `appointment_request` 
                     WHERE DATE(schedule) BETWEEN '$startOfMonth' AND '$endOfMonth' 
                     GROUP BY DATE(schedule) 
                     ORDER BY DATE(schedule)");

if($qry) {
    while($row = $qry->fetch_assoc()) {
        $response['data'][] = $row;
    }
    $response['success'] = true;
} else {
    $response['message'] = 'Error fetching data';
}

echo json_encode($response);
?>
