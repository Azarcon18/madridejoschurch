<?php
header('Content-Type: application/json');
$burial_count = $conn->query("SELECT COUNT(id) FROM burial_requests WHERE status = '0'")->fetchColumn();
$baptism_count = $conn->query("SELECT COUNT(id) FROM baptism_requests WHERE status = '0'")->fetchColumn();
$wedding_count = $conn->query("SELECT COUNT(id) FROM wedding_requests WHERE status = '0'")->fetchColumn();
echo json_encode(['burial' => $burial_count, 'baptism' => $baptism_count, 'wedding' => $wedding_count]);
?>
0