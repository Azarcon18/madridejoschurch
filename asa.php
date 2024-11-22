<?php
// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add a column if it doesn't exist
function addColumnIfNotExists($conn, $table, $column, $definition) {
    $result = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    if ($result->num_rows == 0) {
        $sql = "ALTER TABLE `$table` ADD `$column` $definition";
        if ($conn->query($sql) === TRUE) {
            echo "Column `$column` added successfully.\n";
        } else {
            echo "Error adding column `$column`: " . $conn->error . "\n";
        }
    } else {
        echo "Column `$column` already exists.\n";
    }
}

// Add 'verification_code' column
addColumnIfNotExists($conn, 'registered_users', 'verification_code', "VARCHAR(255) NOT NULL");

// Add 'is_verified' column
addColumnIfNotExists($conn, 'registered_users', 'is_verified', "TINYINT(1) NOT NULL DEFAULT 0");

// Close connection
$conn->close();
?>
