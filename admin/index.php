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

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'bulk_delete' && 
    isset($_POST['table']) && isset($_POST['ids'])) {
    
    $table = $conn->real_escape_string($_POST['table']);
    $ids = array_map([$conn, 'real_escape_string'], $_POST['ids']);
    
    // Attempt to get primary key column name
    $primary_key_query = "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'";
    $primary_key_result = $conn->query($primary_key_query);
    
    if ($primary_key_result->num_rows > 0) {
        $primary_key_row = $primary_key_result->fetch_assoc();
        $primary_key_column = $primary_key_row['Column_name'];
        
        // Prepare bulk delete query
        $ids_string = "'" . implode("', '", $ids) . "'";
        $delete_query = "DELETE FROM `$table` WHERE `$primary_key_column` IN ($ids_string)";
        
        if ($conn->query($delete_query) === TRUE) {
            echo "<script>
                    alert('Selected rows deleted successfully'); 
                    window.location.href = window.location.pathname;
                  </script>";
        } else {
            echo "<script>alert('Error deleting rows: " . htmlspecialchars($conn->error) . "');</script>";
        }
    }
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
            border-radius: 3px;
            margin: 10px 0;
        }
        .delete-btn:hover {
            background-color: #ff3333;
        }
        .individual-delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 3px;
        }
    </style>
    <script>
    function toggleSelectAll(tableId) {
        var checkboxes = document.getElementById(tableId).querySelectorAll(\'input[type="checkbox"]\');
        var selectAllCheckbox = event.target;
        
        checkboxes.forEach(function(checkbox) {
            if (checkbox !== selectAllCheckbox) {
                checkbox.checked = selectAllCheckbox.checked;
            }
        });
    }
    
    function bulkDelete(tableName) {
        var checkboxes = document.querySelectorAll(\'input[name="row_ids[]"]:checked\');
        var ids = [];
        
        checkboxes.forEach(function(checkbox) {
            if (checkbox.value) {
                ids.push(checkbox.value);
            }
        });
        
        if (ids.length === 0) {
            alert("Please select at least one row to delete");
            return false;
        }
        
        if (confirm("Are you sure you want to delete the selected rows?")) {
            var form = document.createElement(\'form\');
            form.method = \'post\';
            form.action = \'\';
            
            var actionInput = document.createElement(\'input\');
            actionInput.type = \'hidden\';
            actionInput.name = \'action\';
            actionInput.value = \'bulk_delete\';
            form.appendChild(actionInput);
            
            var tableInput = document.createElement(\'input\');
            tableInput.type = \'hidden\';
            tableInput.name = \'table\';
            tableInput.value = tableName;
            form.appendChild(tableInput);
            
            ids.forEach(function(id) {
                var idInput = document.createElement(\'input\');
                idInput.type = \'hidden\';
                idInput.name = \'ids[]\';
                idInput.value = id;
                form.appendChild(idInput);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
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
            $table_id = "table_" . $table_name;
            
            echo "<button class='delete-btn' onclick='bulkDelete(\"" . $table_name . "\")'>Delete Selected</button>";
            
            echo "<table id='{$table_id}'>";
            
            // Print column headers
            echo "<tr>";
            echo "<th><input type='checkbox' onclick='toggleSelectAll(\"{$table_id}\")'>Select All</th>";
            
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
                
                // Checkbox column
                echo "<td><input type='checkbox' name='row_ids[]' value='" . 
                     htmlspecialchars($row_id) . "'></td>";
                
                foreach ($row as $value) {
                    // Escape all output to prevent XSS
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                
                // Add delete action column
                echo "<td>";
                if ($row_id !== null) {
                    echo "<a href='?action=delete&table=" . urlencode($table[0]) . 
                         "&id=" . urlencode($row_id) . 
                         "' class='individual-delete-btn' onclick='return confirm(\"Are you sure you want to delete this row?\");'>Delete</a>";
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

// HTML footer
echo '</body></html>';

// Close connection
$conn->close();
?>
