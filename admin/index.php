<?php
// Database Configuration
define('DB_SERVER', "localhost");
define('DB_USERNAME', "u510162695_church_db");
define('DB_PASSWORD', "1Church_db");
define('DB_NAME', "u510162695_church_db");

class DatabaseManager {
    private $conn;

    // Input Sanitization Functions
    public static function sanitizeInput($input) {
        // Trim whitespace
        $input = trim($input);
        
        // Convert special characters to HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        // Remove potentially dangerous HTML tags
        $input = strip_tags($input);
        
        // Additional XSS prevention
        $input = filter_var($input, FILTER_SANITIZE_STRING);
        
        // Remove control characters
        $input = preg_replace('/[\x00-\x1F\x7F]/', '', $input);
        
        return $input;
    }

    // Validate different input types
    public static function validateInput($input, $type = 'string') {
        switch ($type) {
            case 'email':
                $input = filter_var($input, FILTER_SANITIZE_EMAIL);
                return filter_var($input, FILTER_VALIDATE_EMAIL) ? $input : false;
            
            case 'int':
                return filter_var($input, FILTER_VALIDATE_INT);
            
            case 'float':
                return filter_var($input, FILTER_VALIDATE_FLOAT);
            
            case 'url':
                $input = filter_var($input, FILTER_SANITIZE_URL);
                return filter_var($input, FILTER_VALIDATE_URL) ? $input : false;
            
            default:
                return self::sanitizeInput($input);
        }
    }

    // Constructor to establish database connection
    public function __construct($server = DB_SERVER, $username = DB_USERNAME, $password = DB_PASSWORD, $dbname = DB_NAME) {
        // Create connection
        $this->conn = new mysqli($server, $username, $password, $dbname);
        
        // Check connection
        if ($this->conn->connect_error) {
            $this->logError("Connection failed: " . $this->conn->connect_error);
            throw new Exception("Database Connection Error");
        }
    }

    // Method to log errors
    private function logError($errorMessage) {
        // Log errors to a file or error logging system
        error_log(date('[Y-m-d H:i:s] ') . $errorMessage . "\n", 3, "db_errors.log");
    }

    // Secure method to execute prepared statements
    public function executeQuery($query, $params = [], $paramTypes = null) {
        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            // Bind parameters if provided
            if (!empty($params)) {
                // If param types not specified, default to strings
                if ($paramTypes === null) {
                    $paramTypes = str_repeat('s', count($params));
                }
                
                // Bind parameters
                $bindParams = [&$paramTypes];
                foreach ($params as $key => &$value) {
                    // Sanitize each parameter
                    $value = self::sanitizeInput($value);
                    $bindParams[] = &$value;
                }
                
                call_user_func_array([$stmt, 'bind_param'], $bindParams);
            }
            
            // Execute statement
            $executeResult = $stmt->execute();
            
            if ($executeResult === false) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            
            // Get results for SELECT queries
            $result = $stmt->get_result();
            
            return $result;
        } catch (Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    // Method to get all tables in the database
    public function getAllTables() {
        $query = "SHOW TABLES";
        $result = $this->executeQuery($query);
        
        if ($result === false) {
            return [];
        }
        
        $tables = [];
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
        
        return $tables;
    }

    // Method to get all data from a specific table
    public function getTableData($tableName) {
        // Sanitize table name to prevent SQL injection
        $tableName = self::sanitizeInput($tableName);
        
        $query = "SELECT * FROM `" . $tableName . "`";
        $result = $this->executeQuery($query);
        
        if ($result === false) {
            return [];
        }
        
        $tableData = [];
        while ($row = $result->fetch_assoc()) {
            $tableData[] = $row;
        }
        
        return $tableData;
    }

    // Method to display table data
    public function displayTableData($tableName) {
        $data = $this->getTableData($tableName);
        
        if (empty($data)) {
            echo "No data found in table: " . $tableName . "\n";
            return;
        }
        
        // Print headers
        echo "Table: " . $tableName . "\n";
        $headers = array_keys($data[0]);
        echo implode("\t", $headers) . "\n";
        
        // Print data
        foreach ($data as $row) {
            echo implode("\t", $row) . "\n";
        }
    }

    // Destructor to close database connection
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Main execution
try {
    // Create database manager instance
    $dbManager = new DatabaseManager();
    
    // Get all tables
    $tables = $dbManager->getAllTables();
    
    // Display data for each table
    foreach ($tables as $table) {
        $dbManager->displayTableData($table);
        echo "\n"; // Separate tables with a newline
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
