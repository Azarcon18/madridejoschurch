<?php
session_start(); // Start session for basic authentication
// Note: This is a basic implementation and MUST be enhanced for real-world use

// Database connection parameters
$servername = "localhost";
$username = "u510162695_church_db";
$password = "1Church_db";
$dbname = "u510162695_church_db";

// Basic authentication (IMPORTANT: REPLACE WITH PROPER AUTHENTICATION)
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Simplified login (MUST be replaced with secure login mechanism)
    $_SESSION['authenticated'] = false;
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && 
    isset($_GET['table']) && isset($_GET['id']) && 
    $_SESSION['authenticated'] === true) {
    
    $table = $_GET['table'];
    $id = $_GET['id'];
    
    // Validate inputs (CRITICAL SECURITY STEP)
    $table = $conn->real_escape_string($table);
    $id = $conn->real_escape_string($id);
    
    // Attempt to get primary key column name
    $primary_key_query = "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'";
    $primary_key_result = $conn->query($primary_key_query);
    
    if ($primary_key_result->num_rows > 0) {
        $primary_key_row = $primary_key_result->fetch_assoc();
        $primary_key_column = $primary_key_row['Column_name'];
        
        // Prepare and execute delete query
        $delete_query = "DELETE FROM `$table` WHERE `$primary_key_column` = '$id'";
        if ($conn->query($delete_query) === TRUE) {
            echo "<script>alert('Row deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting row: " . htmlspecialchars($conn->error) . "');</script>";
        }
    }
}

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
        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }
    </style>
</head>
<body>';

// Authentication check
if ($_SESSION['authenticated'] !== true) {
    echo '<form method="post" action="">
            <h2>Login Required</h2>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" value="Login">
          </form>';
    
    // Simple login handling (MUST BE REPLACED WITH SECURE METHOD)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $entered_password = $_POST['password'];
        // REPLACE WITH SECURE PASSWORD CHECK
        if ($entered_password === '1Church_db') {
            $_SESSION['authenticated'] = true;
            echo "<script>location.reload();</script>";
        } else {
            echo "<script>alert('Incorrect Password');</script>";
        }
    }
    
    $conn->close();
    echo '</body></html>';
    exit();
}

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
            echo "<th>Actions</th>";
            echo "</tr>";
            
            // Attempt to get primary key column
            $primary_key_query = "SHOW KEYS FROM `" . $table[0] . "` WHERE Key_name = 'PRIMARY'";
            $primary_key_result = $conn->query($primary_key_query);
            $primary_key_column = $primary_key_result->num_rows > 0 
                ? $primary_key_result->fetch_assoc()['Column_name'] 
                : null;
            
            // Print data rows
            while ($row = $data_result->fetch_assoc()) {
                echo "<tr>";
                $row_id = $primary_key_column ? $row[$primary_key_column] : null;
                
                foreach ($row as $value) {
                    // Escape all output to prevent XSS
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                
                // Add delete action column
                echo "<td>";
                if ($row_id !== null) {
                    echo "<a href='?action=delete&table=" . urlencode($table[0]) . 
                         "&id=" . urlencode($row_id) . 
                         "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this row?\");'>Delete</a>";
                } else {
                    echo "N/A";
                }
                echo "</td>";
                
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

// Logout link
echo '<br><a href="?action=logout">Logout</a>';

// Logout handling
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    echo "<script>location.reload();</script>";
}

// HTML footer
echo '</body></html>';

// Close connection
$conn->close();
?>