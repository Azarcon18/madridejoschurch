<?php
// Include the database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $amount = htmlspecialchars($_POST['amount']);

    // Prepare the SQL statement to insert donation data
    $sql = "INSERT INTO donations (name, email, amount, date_created) VALUES ('$name', '$email', '$amount', NOW())";

    // Execute the query and check if successful
    if ($conn->query($sql) === TRUE) {
        // Set a success message in the session
        $_settings->set_flashdata('success', 'Donation completed successfully!');
        
        // Redirect to the index page to display the updated list
        header("Location: index.php");
        exit();
    } else {
        // Handle the error if the query fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// No need to manually close the connection, the destructor will handle it
?>
