<?php
// Include the config file to connect to the database
require_once('../config.php');

// Get the baptism request ID from the query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Prepare the SQL query to fetch baptism details
    $stmt = $conn->prepare("
        SELECT 
            child_fullname, birthplace, birthdate, father, mother, address, 
            date_of_baptism, minister, sponsors, book_no, page, volume, date_issue
        FROM baptism_schedule 
        WHERE id = ?
    ");
    
    // Bind the baptism request ID to the query
    $stmt->bind_param("i", $id);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch the data
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "No data found for this baptism request.";
        exit;
    }
    
    // Close the statement
    $stmt->close();
} else {
    echo "No ID provided.";
    exit;
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Baptism</title>
    <style>
        body {
            font-family: Times New Roman, serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .certificate {
            background-color: #e6f3ff;
            padding: 40px;
            width: 800px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 60px;
            height: 60px;
        }
        h1 {
            color: #333;
            font-style: italic;
            margin: 0;
            font-size: 24px;
        }
        h2 {
            text-align: center;
            color: #8B0000;
            font-size: 28px;
            margin-top: 10px;
            text-transform: uppercase;
        }
        .content {
            margin-top: 20px;
            line-height: 2;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
        .input {
            border-bottom: 1px solid #000;
            flex-grow: 1;
            margin: 0 5px;
        }
        .footer {
            margin-top: 20px;
        }
        .signature {
            text-align: right;
            margin-top: 40px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            font-size: 100px;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <img src="/api/placeholder/60/60" alt="Logo" class="logo">
        <div class="header">
            <h1>Immaculate Conception Parish</h1>
            <p>Madridejos, Cebu</p>
            <h2>Certificate of Baptism</h2>
        </div>
        <div class="content">
            <div class="row">
                <span class="label">This is to certify</span>
                <span class="input"><?php echo $data['child_fullname']; ?></span>
                <span class="label">that born in</span>
            </div>
            <div class="row">
                <span class="input"><?php echo $data['birthplace']; ?></span>
                <span class="label">on the</span>
                <span class="input"><?php echo date('jS', strtotime($data['birthdate'])); ?></span>
                <span class="label">day of</span>
                <span class="input"><?php echo date('F', strtotime($data['birthdate'])); ?></span>
                <span>, <?php echo date('Y', strtotime($data['birthdate'])); ?></span>
            </div>
            <div class="row">
                <span class="label">legitimate child of</span>
                <span class="input"><?php echo $data['father']; ?></span>
                <span class="label">and of</span>
                <span class="input"><?php echo $data['mother']; ?></span>
            </div>
            <div class="row">
                <span class="label">residents of</span>
                <span class="input"><?php echo $data['address']; ?></span>
                <span class="label">was solemnly</span>
            </div>
            <div class="row">
                <span class="label">baptized on the</span>
                <span class="input"><?php echo date('jS', strtotime($data['date_of_baptism'])); ?></span>
                <span class="label">day of</span>
                <span class="input"><?php echo date('F', strtotime($data['date_of_baptism'])); ?></span>
                <span class="label">in the year of our Lord</span>
                <span class="input"><?php echo date('Y', strtotime($data['date_of_baptism'])); ?></span>
            </div>
        </div>
        <div class="footer">
            <p>ACCORDING TO THE RITE OF THE HOLY ROMAN CATHOLIC CHURCH by the</p>
            <div class="row">
                <span class="label">Rev. Fr.</span>
                <span class="input"><?php echo $data['minister']; ?></span>
                <span class="label">(Parish Priest)</span>
            </div>
            <div class="row">
                <span class="label">The sponsors being</span>
                <span class="input"><?php echo $data['sponsors']; ?></span>
            </div>
            <div class="row">
                <span class="label">as appears from the Baptismal Register Book No.</span>
                <span class="input"><?php echo $data['book_no']; ?></span>
            </div>
            <div class="row">
                <span class="label">Page no.</span>
                <span class="input"><?php echo $data['page']; ?></span>
                <span class="label">, volume</span>
                <span class="input"><?php echo $data['volume']; ?></span>
                <span class="label">of the church.</span>
            </div>
            <div class="row">
                <span class="label">Date Issue:</span>
                <span class="input"><?php echo date('m - d - y', strtotime($data['date_issue'])); ?></span>
            </div>
        </div>
        <div class="signature">
            <p>REV. FR. JIMMY M. TOLENTIN</p>
            <p>(Parish Priest)</p>
        </div>
        <div class="watermark">BAPTISM</div>
    </div>
</body>
</html>
