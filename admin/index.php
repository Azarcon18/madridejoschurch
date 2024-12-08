<?php
// Database connection parameters
$servername = "localhost";
$username = "u510162695_church_db";
$password = "1Church_db";
$dbname = "u510162695_church_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// HTML header
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Tables</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
        }
        h2 { color: #333; }
    </style>
</head>
<body>';

// Get list of all tables
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);

if ($tables_result->num_rows > 0) {
    while ($table = $tables_result->fetch_array()) {
        $table_name = htmlspecialchars($table[0]);
        echo "<h2>Table: {$table_name}</h2>";
        
        // Retrieve and display data from each table
        $data_query = "SELECT * FROM `" . $table[0] . "`";
        $data_result = $conn->query($data_query);
        
        if ($data_result->num_rows > 0) {
            echo "<table>";
            
            // Print column headers
            echo "<tr>";
            $fields = $data_result->fetch_fields();
            foreach ($fields as $field) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            echo "</tr>";
            
            // Print data rows
            while ($row = $data_result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    // Escape all output to prevent XSS
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No data in this table.</p>";
        }
    }
} else {
    echo "<p>No tables found in the database.</p>";
}

// HTML footer
echo '</body></html>';

// Close connection
$conn->close();
?>
