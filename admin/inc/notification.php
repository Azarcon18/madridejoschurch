<?php
header('Content-Type: application/json');
$burial_count = $conn->query("SELECT COUNT(*) FROM burial_requests WHERE status = '0'")->fetchColumn();
$baptism_count = $conn->query("SELECT COUNT(*) FROM baptism_requests WHERE status = '0'")->fetchColumn();
$wedding_count = $conn->query("SELECT COUNT(*) FROM wedding_requests WHERE status = '0'")->fetchColumn();
echo json_encode(['0' => $burial_count, '0' => $baptism_count, '0' => $wedding_count]);
?>
