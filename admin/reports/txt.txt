<?php
// Include necessary database connection and other required files
require_once('../config.php');

$debug = false; // Set to true when you need to debug

// Enable error reporting for debugging
if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the appointment ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($debug) {
    echo "Debug: Received ID = " . $id . "<br>";
}

if ($id) {
    // Fetch the specific appointment data
    $query = "SELECT ar.*, st.sched_type 
              FROM appointment_request ar 
              LEFT JOIN schedule_type st ON ar.sched_type_id = st.id 
              WHERE ar.id = ?";
    
    if ($debug) {
        echo "Debug: Query = " . $query . "<br>";
    }

    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if ($appointment) {
        // Display the appointment data using the modified template
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Appointment Report</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    background-color: #f8f8f8;
                }
                .certificate {
                    width: 210mm;
                    height: 297mm;
                    padding: 40px;
                    margin: 0 auto;
                    background-color: white;
                    border: 1px solid #ccc;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                header h1 {
                    margin: 0;
                    font-size: 28px;
                    color: #333;
                }
                header p {
                    margin: 5px 0;
                    font-size: 18px;
                    color: #666;
                }
                .details {
                    margin-bottom: 20px;
                }
                .details table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .details td {
                    padding: 8px;
                    border: 1px solid #ccc;
                    vertical-align: top;
                }
                .details td:first-child {
                    font-weight: bold;
                    width: 40%;
                }
                .signatures {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 30px;
                }
                .signature {
                    text-align: center;
                    width: 45%;
                }
                .signature p {
                    margin: 5px 0;
                    font-size: 16px;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="certificate">
                <header>
                    <h1>Appointment Report</h1>
                    <p>Appointment Details</p>
                </header>
                
                <section class="details">
                    <table>
                        <tbody>
                            <tr>
                                <td><strong>Appointment ID:</strong></td>
                                <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Schedule Type:</strong></td>
                                <td><?php echo htmlspecialchars($appointment['sched_type']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Full Name:</strong></td>
                                <td><?php echo htmlspecialchars($appointment['fullname']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Contact:</strong></td>
                                <td><?php echo htmlspecialchars($appointment['contact']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td><?php echo htmlspecialchars($appointment['address']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Schedule:</strong></td>
                                <td><?php echo date("M d, Y h:i A", strtotime($appointment['schedule'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Remarks:</strong></td>
                                <td><?php echo htmlspecialchars($appointment['remarks']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <?php
                                    if ($appointment['status'] == 1) echo "Confirmed";
                                    elseif ($appointment['status'] == 2) echo "Cancelled";
                                    else echo "Pending";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date Created:</strong></td>
                                <td><?php echo date("M d, Y h:i A", strtotime($appointment['date_created'])); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="signatures">
                    <div class="signature">
                        <p>_________________________</p>
                        <p>Signature of Applicant</p>
                        <p>Date: ___________</p>
                    </div>
                    <div class="signature">
                        <p>_________________________</p>
                        <p>Signature of Approver</p>
                        <p>Date: ___________</p>
                    </div>
                </section>
            </div>

            <script>
                // Automatically print the page when it loads
                window.onload = function() {
                    window.print();
                }
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "Invalid request. No ID provided.";
}
?>