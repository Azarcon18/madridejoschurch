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

// Query to fetch all data from the donations table
$sql = "SELECT * FROM donations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display data in a table
    echo "<table border='1'>";
    echo "<tr>";
    // Output table headers
    while ($fieldInfo = $result->fetch_field()) {
        echo "<th>" . $fieldInfo->name . "</th>";
    }
    echo "</tr>";
    
    // Output table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found in the donations table.";
}

// Close connection
$conn->close();
?>
