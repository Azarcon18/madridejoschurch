<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
} else {
    echo 'logged_in';
}
?>