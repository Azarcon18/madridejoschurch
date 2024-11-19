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

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'], $_POST['table_name'])) {
    $deleteId = intval($_POST['delete_id']);
    $tableName = $_POST['table_name'];

    $sql = "DELETE FROM $tableName WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute()) {
        echo "Record with ID $deleteId deleted from table $tableName.<br>";
    } else {
        echo "Error deleting record: " . $conn->error . "<br>";
    }
    $stmt->close();
}

// Function to display table contents with delete button
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
        echo "<th>Action</th></tr>"; // Extra column for Delete button

        // Fetch rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            // Add delete button for each row
            echo "<td>
                <form method='POST'>
                    <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                    <input type='hidden' name='table_name' value='" . htmlspecialchars($tableName) . "'>
                    <button type='submit'>Delete</button>
                </form>
            </td>";
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
