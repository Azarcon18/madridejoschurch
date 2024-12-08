<?php
// Database connection parameters
$host = "127.0.0.1";        // Database host
$username = "u510162695_church_db";         // Database username
$password = "1Church_db";             // Database password
$dbname = "u510162695_church_db";      // Database name

// Establish a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize data from the POST request
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0.00;
    $ref_no = isset($_POST['ref_no']) ? htmlspecialchars(trim($_POST['ref_no'])) : '';

    // Validate required fields
    if ($name && $email && $amount > 0 && $ref_no) {
        // Prepare the SQL statement to insert the donation record
        $stmt = $conn->prepare("INSERT INTO donations (name, email, ref_no, message, amount, date_created) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssd", $name, $email, $ref_no, $message, $amount);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            // Send a JSON response indicating success
            echo json_encode([
                'status' => 'success',
                'message' => 'Donation recorded successfully!',
                'ref_no' => $ref_no
            ]);
        } else {
            // Send an error response if the query fails
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to record the donation. Please try again later.'
            ]);
        }
        
        // Close the prepared statement
        $stmt->close();
    } else {
        // Validation error response
        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill in all required fields with valid data.'
        ]);
    }
} else {
    // Invalid request method response
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}

// Close the database connection
$conn->close();
?>