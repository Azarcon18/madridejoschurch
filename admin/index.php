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
    die("Connection failed: " . $conn->connect_error);
}

// Get list of all tables
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);

if ($tables_result->num_rows > 0) {
    while ($table = $tables_result->fetch_array()) {
        echo "Table: " . $table[0] . "\n";
        
        // Retrieve and display data from each table
        $data_query = "SELECT * FROM `" . $table[0] . "`";
        $data_result = $conn->query($data_query);
        
        if ($data_result->num_rows > 0) {
            // Print column headers
            $fields = $data_result->fetch_fields();
            foreach ($fields as $field) {
                echo $field->name . "\t";
            }
            echo "\n";
            
            // Print data rows
            while ($row = $data_result->fetch_assoc()) {
                foreach ($row as $value) {
                    echo $value . "\t";
                }
                echo "\n";
            }
        } else {
            echo "No data in this table.\n";
        }
        echo "\n";
    }
} else {
    echo "No tables found in the database.";
}

// Close connection
$conn->close();
?>
