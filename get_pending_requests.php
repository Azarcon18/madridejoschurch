<?php
// Include database connection and other necessary files
include 'config.php'; // Ensure this file includes the $conn database connection variable

// Set the content type to JSON
header('Content-Type: application/json');

// Initialize counts to 0 (default value)
$burialCount = 0;
$baptismCount = 0;
$weddingCount = 0;

// Error handling: Check if database connection is successful
if ($conn) {
    try {
        // Fetch counts of pending requests with status = 0 (pending)
        $burialCount = $conn->query("SELECT COUNT(id) FROM appointment_schedules WHERE status = '0'")->fetchColumn();
        $baptismCount = $conn->query("SELECT COUNT(id) FROM baptism_schedule WHERE status = '0'")->fetchColumn();
        $weddingCount = $conn->query("SELECT COUNT(id) FROM wedding_schedules WHERE status = '0'")->fetchColumn();
    } catch (PDOException $e) {
        // If there is a database error, log the error and set counts to 0
        error_log("Database Error: " . $e->getMessage());
    }
}

// Return the data as JSON
echo json_encode([
    'burial' => $burialCount,
    'baptism' => $baptismCount,
    'wedding' => $weddingCount
]);

?>
