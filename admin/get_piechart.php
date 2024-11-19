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
    // Modified query to include both regular appointments and wedding schedules
    $stmt = $conn->prepare("
        SELECT 
            t.sched_type,
            (
                SELECT COUNT(r.id) 
                FROM appointment_request r 
                WHERE r.sched_type_id = t.id
            ) + (
                CASE 
                    WHEN t.id = '3' THEN (
                        SELECT COUNT(*) 
                        FROM wedding_schedules
                    )
                    ELSE 0
                END
            ) as total
        FROM schedule_type t
        GROUP BY t.sched_type, t.id
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