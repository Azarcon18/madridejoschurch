<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

header('Content-Type: application/json'); // Ensure the content is JSON

// Initialize an array to store the data
$data = [
    'success' => false,
    'message' => '',
    'data' => [],
];

try {
    // First get the appointment types data
    $stmt = $conn->prepare("
        SELECT t.sched_type, COUNT(r.id) AS total 
        FROM appointment_request r
        INNER JOIN schedule_type t ON r.sched_type_id = t.id
        GROUP BY t.sched_type
    ");

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        $chartData = [];

        while ($row = $result->fetch_assoc()) {
            $chartData[] = [
                'label' => $row['sched_type'],
                'total' => (int)$row['total'],
            ];
        }

        $stmt->close();

        // Now get the wedding schedules count
        $weddingStmt = $conn->prepare("
            SELECT COUNT(*) as total 
            FROM wedding_schedules
        ");

        if ($weddingStmt) {
            $weddingStmt->execute();
            $weddingResult = $weddingStmt->get_result();
            $weddingRow = $weddingResult->fetch_assoc();

            // Add wedding schedules to the chart data
            $chartData[] = [
                'label' => 'Wedding Schedules',
                'total' => (int)$weddingRow['total'],
            ];

            $weddingStmt->close();
        }

        $data['success'] = true;
        $data['data'] = $chartData;
    } else {
        $data['message'] = 'Error preparing statement: ' . $conn->error;
    }
} catch (Exception $e) {
    $data['message'] = 'Exception caught: ' . $e->getMessage();
}

echo json_encode($data);

?>