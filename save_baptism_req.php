<?php
// Include your database connection
include('../config.php');

// Get the data from the POST request
$id = isset($_POST['id']) ? $_POST['id'] : '';
$sched_type_id = isset($_POST['sched_type_id']) ? intval($_POST['sched_type_id']) : 0;
$child_fullname = isset($_POST['child_fullname']) ? trim($_POST['child_fullname']) : '';
$birthplace = isset($_POST['birthplace']) ? trim($_POST['birthplace']) : '';
$birthdate = isset($_POST['birthdate']) ? trim($_POST['birthdate']) : '';
$father = isset($_POST['father']) ? trim($_POST['father']) : '';
$mother = isset($_POST['mother']) ? trim($_POST['mother']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$date_of_baptism = isset($_POST['date_of_baptism']) ? trim($_POST['date_of_baptism']) : '';
$minister = isset($_POST['minister']) ? trim($_POST['minister']) : '';
$position = isset($_POST['position']) ? trim($_POST['position']) : '';
$sponsors = isset($_POST['sponsors']) ? trim($_POST['sponsors']) : '';
$book_no = isset($_POST['book_no']) ? intval($_POST['book_no']) : 0;
$page = isset($_POST['page']) ? intval($_POST['page']) : 0;
$volume = isset($_POST['volume']) ? intval($_POST['volume']) : 0;
$date_issue = isset($_POST['date_issue']) ? trim($_POST['date_issue']) : '';

// Validate required fields
if (empty($child_fullname) || empty($birthplace) || empty($birthdate) || empty($address) || empty($date_of_baptism) || empty($minister) || empty($position) || empty($sponsors) || empty($book_no) || empty($page) || empty($volume) || empty($date_issue)) {
    echo json_encode(["status" => "failed", "msg" => "Please fill in all required fields."]);
    exit;
}

// Validate numeric fields
if (!is_numeric($book_no) || !is_numeric($page) || !is_numeric($volume)) {
    echo json_encode(["status" => "failed", "msg" => "Book No, Page, and Volume must be numeric."]);
    exit;
}

// Insert the baptism request into the database
$query = "INSERT INTO baptism_appointment (sched_type_id, child_fullname, birthplace, birthdate, father, mother, address, date_of_baptism, minister, position, sponsors, book_no, page, volume, date_issue) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["status" => "failed", "msg" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param('issssssssssssss', $sched_type_id, $child_fullname, $birthplace, $birthdate, $father, $mother, $address, $date_of_baptism, $minister, $position, $sponsors, $book_no, $page, $volume, $date_issue);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed", "msg" => "Error scheduling baptism: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
