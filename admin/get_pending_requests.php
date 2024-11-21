<?php
// Include database connection and other necessary files
include 'config.php'; // or include your database connection file

// Fetch counts of pending requests
$burialCount = $conn->query("SELECT COUNT(*) FROM appointment_schedules WHERE status = '1'")->fetchColumn();
$baptismCount = $conn->query("SELECT COUNT(*) FROM baptism_schedule WHERE status = '1'")->fetchColumn();
$weddingCount = $conn->query("SELECT COUNT(*) FROM wedding_schedules WHERE status = '1'")->fetchColumn();

// Return the data as JSON
echo json_encode([
  'burial' => $burialCount,
  'baptism' => $baptismCount,
  'wedding' => $weddingCount
]);
?>
