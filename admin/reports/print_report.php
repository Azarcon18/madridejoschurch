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
            <title>Death Certificate</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f0f0f0;
                }
                .certificate {
                    width: 210mm;
                    height: 297mm;
                    margin: 0 auto;
                    background-color: white;
                    padding: 20mm;
                    box-sizing: border-box;
                }
                header {
                    text-align: center;
                    margin-bottom: 10mm;
                }
                h1 {
                    font-size: 24pt;
                    color: #333;
                    margin: 0;
                }
                .details {
                    font-size: 14pt;
                    line-height: 3;
                    text-align: justify;
                }
                .signatures {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20mm;
                }
                .signature {
                    text-align: center;
                }
                @media print {
                    body {
                        background-color: white;
                    }
                    .certificate {
                        box-shadow: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="certificate">
                <header>
                    <h1><b>DEATH CERTIFICATE</b></h1>
                </header>
                
                <section class="details">
                    <p>TO WHOM IT MAY CONCERN:</p>
                    
                    <p>This is to clarify that <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['death_person_fullname']); ?></span>, <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['gender']); ?></span> died last <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['date_of_death']); ?></span>. Born on <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['birthdate']); ?></span>, died at <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['resident']); ?></span>. <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['civil_status']); ?></span>, resident of <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['resident']); ?></span>, <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['nationality']); ?></span>. Entrepreneur of parents <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['mother']); ?></span> and <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['father']); ?></span>, <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['nationality']); ?></span>. <br> This certification is issued to <span style="text-decoration:underline;"><?php echo htmlspecialchars($appointment['fullname']); ?></span> upon his/her request for whatever legal purpose it may serve.</p>
                    <?php
    // Set the timezone to Cebu, Philippines
    date_default_timezone_set('Asia/Manila');

    // Get the current date
    $current_date = date('F j, Y');

    // Output the date within the paragraph
    echo "<p>Given this of $current_date at Immaculate Conception Parish, Poblacion Madridejos Cebu, Burgos St.</p>";
?>

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