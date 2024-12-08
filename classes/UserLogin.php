<?php
session_start();
require_once '../config.php';

class UserLogin extends DBConnection {
    private $settings;
    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }
    public function __destruct(){
        parent::__destruct();
    }
    public function index(){
        echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
    }
    public function login_user(){
        extract($_POST);

        // Prepare statement
        $qry = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$qry) {
            error_log("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
            return json_encode(['status' => 'failed', 'error' => 'Database error']);
        }
        
        $qry->bind_param('s', $email);
        if (!$qry->execute()) {
            error_log("Execute failed: (" . $qry->errno . ") " . $qry->error);
            return json_encode(['status' => 'failed', 'error' => 'Database error']);
        }
        
        $result = $qry->get_result();
        
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])){
                foreach($user as $k => $v){
                    if(!is_numeric($k) && $k != 'password'){
                        $this->settings->set_userdata($k, $v);
                    }
                }
                $this->settings->set_userdata('login_type', 2); // Differentiate user login type
                return json_encode(array('status' => 'success'));
            } else {
                return json_encode(array('status' => 'incorrect'));
            }
        } else {
            return json_encode(array('status' => 'incorrect'));
        }
    }
}

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new UserLogin();
switch ($action) {
    case 'login_user':
        echo $auth->login_user();
        break;
    default:
        echo $auth->index();
        break;
}
