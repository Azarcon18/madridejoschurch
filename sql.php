<?php
// Database credentials
$host = "127.0.0.1";
$username = "u510162695_church_db";
$password = "1Church_db";
$dbname = "u510162695_church_db";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to display table contents
function displayTable($conn, $tableName) {
    echo "<h3>Table: $tableName</h3>";
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'><tr>";
        // Fetch column names
        while ($field = $result->fetch_field()) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr>";

        // Fetch rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found in table '$tableName'.<br>";
    }
}

// List of tables to display
$tables = ['appointment_schedules', 'baptism_schedules', 'wedding_schedules'];
foreach ($tables as $table) {
    displayTable($conn, $table);
}

// Close connection
$conn->close();
?>
