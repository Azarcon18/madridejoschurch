<?php
// File path: db_functions.php

function displayDonationsTable()
{
    // Database connection details
    $host = "localhost";
    $username = "u510162695_church_db";
    $password = "1Church_db     ";
    $dbname = "u510162695_church_db";

    // Create connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch all data from donations table
    $sql = "SELECT * FROM donations";
    $result = $conn->query($sql);

    // Check if there are rows to display
    if ($result->num_rows > 0) {
        // Start the HTML table
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";

        // Generate table headers dynamically from the query result
        $fields = $result->fetch_fields();
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";

        // Output data for each row dynamically
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>{$value}</td>";
            }
            echo "</tr>";
        }

        // Close the table
        echo "</table>";
    } else {
        echo "No records found in the donations table.";
    }

    // Close the connection
    $conn->close();
}
