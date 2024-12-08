<?php
// Include database connection
require_once('../config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $resp = array();
    
    // Sanitize and get form inputs
    $id = $_POST['id'];
    $sched_type_id = $_POST['sched_type_id'];
    $child_fullname = $_POST['child_fullname'];
    $birthplace = $_POST['birthplace'];
    $birthdate = $_POST['birthdate'];
    $father = $_POST['father'];
    $mother = $_POST['mother'];
    $address = $_POST['address'];
    $date_of_baptism = $_POST['date_of_baptism'];
    $minister = $_POST['minister'];
    $position = $_POST['position'];
    $sponsors = $_POST['sponsors'];
    $book_no = $_POST['book_no'];
    $page = $_POST['page'];
    $volume = $_POST['volume'];
    $date_issue = $_POST['date_issue'];
    
    // Prepare SQL query to insert or update record
    if(empty($id)){
        // Insert new baptism record
        $sql = "INSERT INTO baptism_records (sched_type_id, child_fullname, birthplace, birthdate, father, mother, address, date_of_baptism, minister, position, sponsors, book_no, page, volume, date_issue) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issssssssssiiis', $sched_type_id, $child_fullname, $birthplace, $birthdate, $father, $mother, $address, $date_of_baptism, $minister, $position, $sponsors, $book_no, $page, $volume, $date_issue);
        
    } else {
        // Update existing baptism record
        $sql = "UPDATE baptism_records SET sched_type_id=?, child_fullname=?, birthplace=?, birthdate=?, father=?, mother=?, address=?, date_of_baptism=?, minister=?, position=?, sponsors=?, book_no=?, page=?, volume=?, date_issue=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issssssssssiiisi', $sched_type_id, $child_fullname, $birthplace, $birthdate, $father, $mother, $address, $date_of_baptism, $minister, $position, $sponsors, $book_no, $page, $volume, $date_issue, $id);
    }
    
    // Execute query
    if($stmt->execute()){
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Database Error: '.$conn->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Return response as JSON
    echo json_encode($resp);
}
?>
