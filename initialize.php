<?php
// Database configuration
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => '0192023a7bbd73250516f069df18b500',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

if (!defined('base_url')) define('base_url', 'https://icpmadridejos.com/');
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('dev_data')) define('dev_data', $dev_data);
if (!defined('DB_SERVER')) define('DB_SERVER', "localhost");
if (!defined('DB_USERNAME')) define('DB_USERNAME', "u510162695_church_db");
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', "1Church_db");
if (!defined('DB_NAME')) define('DB_NAME', "u510162695_church_db");

// Establish secure database connection using PDO
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Check if form is submitted and inputs are set
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query with prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Fetch results
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "Login successful";
    } else {
        echo "Invalid credentials";
    }
} 
?>
