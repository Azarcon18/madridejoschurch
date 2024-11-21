<?php
// Include your database connection
require_once 'db_connect.php';

// Fetch pending requests
$query = "
    SELECT 'Burial' AS type, COUNT(*) AS count, 'burial_location_url' AS location
    FROM burial_requests
    WHERE status = 'pending'
    UNION ALL
    SELECT 'Baptism' AS type, COUNT(*) AS count, 'baptism_location_url' AS location
    FROM baptism_requests
    WHERE status = 'pending'
    UNION ALL
    SELECT 'Wedding' AS type, COUNT(*) AS count, 'wedding_location_url' AS location
    FROM wedding_requests
    WHERE status = 'pending'
";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
