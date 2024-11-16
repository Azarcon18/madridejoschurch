<?php
// Database configuration
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => '5da283a2d990e8d8512cf967df5bc0d0',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);


if (!defined('base_url')) define('base_url', 'https:/icpmadridejos.com/');
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('dev_data')) define('dev_data', $dev_data);
if (!defined('DB_SERVER')) define('DB_SERVER', "localhost");
if (!defined('DB_USERNAME')) define('DB_USERNAME', "u510162695_church_db");
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', "1Church_db");
if (!defined('DB_NAME')) define('DB_NAME', "u510162695_church_db");

// Establish secure database connection using PDO
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWcpORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Function to get all tables from the database
function getAllTables($pdo) {
    try {
        // Fetch all table names from the database
        $sql = "SHOW TABLES";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        die("ERROR: Could not retrieve tables. " . $e->getMessage());
    }
}

// Function to display all rows from a specified table
function viewTableData($pdo, $tableName) {
    try {
        // Prepare SQL query to fetch all rows from the specified table
        $sql = "SELECT * FROM " . $tableName;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any rows were returned
        if (count($rows) > 0) {
            echo "<h3>Table: " . htmlspecialchars($tableName) . "</h3>";
            echo "<table border='1'>";
            echo "<tr>";
            foreach ($rows[0] as $key => $value) {
                echo "<th>" . htmlspecialchars($key) . "</th>";
            }
            echo "</tr>";

            // Display table rows
            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        } else {
            echo "<h3>Table: " . htmlspecialchars($tableName) . "</h3>";
            echo "<p>No data found in this table.</p>";
        }
    } catch (PDOException $e) {
        die("ERROR: Could not retrieve data from $tableName. " . $e->getMessage());
    }
}

// Get all tables from the database
$tables = getAllTables($pdo);

// Loop through each table and display its data
foreach ($tables as $table) {
    viewTableData($pdo, $table);
}
?>
