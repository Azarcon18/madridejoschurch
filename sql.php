<?php
// Database credentials
$host = "localhost";
$username = "u510162695_church_db";
$password = "1Church_db";
$dbname = "u510162695_church_db";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to show all tables
$sql = "SHOW TABLES FROM $dbname";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Tables in database '$dbname':<br>";
    while ($row = $result->fetch_array()) {
        echo $row[0] . "<br>";
    }
} else {
    echo "No tables found in the database.";
}

// Close connection
$conn->close();
?>
