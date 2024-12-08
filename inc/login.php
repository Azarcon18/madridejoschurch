<?php
require_once('../config.php');
require_once('../classes/Master.php');

$master = new Master();

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the user credentials
    $query = $conn->prepare("SELECT * FROM registered_users WHERE email = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['photo'] = $user['photo'];

            $response = [
                'status' => 'success',
                'name' => $user['name'],
                'photo' => $user['photo'] ? 'uploads/' . $user['photo'] : 'uploads/default_photo.jpg'
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid password.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid email.'];
    }

    echo json_encode($response);
}
?>