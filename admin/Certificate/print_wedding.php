<?php
require_once('../config.php');

// Check if the id parameter is present in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the query to fetch the wedding details
    $stmt = $conn->prepare("
        SELECT 
    ws.id,
    st.sched_type,
    ws.date_created,
    ws.date_of_marriage,
    ws.husband_fname,
    ws.husband_mname,
    ws.husband_lname,
    CONCAT(ws.husband_fname, ' ', ws.husband_mname, ' ', ws.husband_lname) AS husband,
    ws.wife_fname,
    ws.wife_mname,
    ws.wife_lname,
    CONCAT(ws.wife_fname, ' ', ws.wife_mname, ' ', ws.wife_lname) AS wife,
    ws.birthdate AS husband_birthdate,
    ws.wife_birthdate,
    ws.birthplace AS husband_birthplace,
    ws.wife_birthplace,
    ws.gender AS husband_gender,
    ws.wife_gender,
    ws.citizenship AS husband_citizenship,
    ws.wife_citizenship,
    ws.address AS husband_address,
    ws.wife_address,
    ws.civil_status AS husband_civil_status,
    ws.wife_civil_status,
    ws.father_name AS husband_father_name,
    ws.wife_father_name,
    ws.fcitizenship AS husband_father_citizenship,
    ws.wife_fcitizenship,
    ws.mother_name AS husband_mother_name,
    ws.wife_mother_name,
    ws.mcitizenship AS husband_mother_citizenship,
    ws.advice,
    ws.wife_advice,
    ws.relationship,
    ws.marriage_license_no,
    ws.wife_relationship,
    ws.wife_mcitizenship,
    ws.place_of_marriage1,
    ws.place_of_marriage2,
    ws.place_of_marriage3,
    ws.time_of_marriage,
    ws.religion,
    ws.wreligion,
    ws.witnesses_1,
    ws.witnesses_2,
    ws.witnesses_3,
    ws.witnesses_4,
    ws.witnesses_5,
    ws.witnesses_6,
    ws.witnesses_7,
    ws.witnesses_8,
    ws.date_created,
    ws.status
FROM 
    schedule_type st
LEFT JOIN 
    wedding_schedules ws ON st.id = ws.sched_type_id
WHERE 
    ws.id = ?

    ");

    // Bind the id parameter
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the wedding details
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
} else {
    // Redirect to the dashboard if the id parameter is not present
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Marriage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .main-table {
            width: 150%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: -190px;
        }
        .main-table td, .main-table th {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .registry {
            text-align: right;
            font-size: 0.9em;
        }
        .form-no {
            text-align: left;
            font-size: 0.9em;
        }
        .column-header {
            text-align: center;
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .label {
            font-weight: bold;
            width: 15%;
        }
        .labeling {
            font-weight: bold;
        }
        .value {
            font-style: italic;
        }
        .values {
            font-style: italic;
        }
        .signatures {
            margin-top: 20px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 20px auto 5px;
        }
        hr {
            border: 1px solid #ccc; /* Light gray line */
            margin: 10px 0; /* Adds space around the line */
        }
        .space {
            margin-left: 22px; /* Adjust as needed */
            text-align: right;
        }
        .spacing {
            margin-left: 30%; /* Adjust as needed */
        }
        .spaces {
            margin-left: 10%; /* Adjust as needed */
        }
        .spacer {
            text-align: center;
            font-weight: bold;
        }
        .spacess {
            margin-left: 20%; /* Adjust as needed */
        }
        .input {
            border-bottom: 1px solid #000;
            flex-grow: 1;
            margin: 0 5px;
        }
        .box-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            background-color: green;
            margin-left: 5px;
            border-radius: 2px; /* To soften the edges */
        }
        .signature-container {
        display: flex;
        justify-content: center;
        gap: 30px; /* Adjust the spacing between the two lines */
        }
        .signature-containers {
            display: grid;
    justify-content: right;
    margin-right: 60px
        }

        .signature-line {
        text-align: center;
        }

        .underline {
        border-bottom: 1px solid black;
        width: 120px; /* Width of the underline */
        margin-bottom: 4px; /* Space between underline and label */
        }

        .labels {
        font-size: 10px; /* Adjust font size as needed */
        color: black;
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="form-no">Municipal Form No. 97</div>
        <h2>Republic of the Philippines</h2>
        <h3>OFFICE OF THE CIVIL REGISTRAR GENERAL</h3>
        <h1>CERTIFICATE OF MARRIAGE</h1>
    </div>

    <table class="main-table">
        <tr>
            <td colspan="3">Province:<span class="space" style="margin-left: 20px; font-weight: bold;">CEBU</span><br>
            <hr>
                City/Municipality:<span class="space" style="margin-left: 20px; font-weight: bold;">MADRIDEJOS</span>
            </hr>
        </td>
            <td colspan="2" class="registry">Registry No. <br> <span class="space" style="margin-left: 200px; font-weight: bold;"><?php echo $row['id']; ?></span></td>
        </tr>
        

<tr>
    <td class="label">1. Name of Contracting Parties</td>
    <td colspan="2" class="value">
        <div style="text-align: center; margin-bottom: 10px;">
            <strong>Husband</strong>
        </div>
        <hr>
        <strong style="font-weight: 300">(First):</strong><span class="space" style="margin-left: 20px; font-weight: bold;"> <?php echo $row['husband_fname']; ?></span><br>
        <hr>
        <strong style="font-weight: 300">(Middle):</strong><span class="space" style="margin-left: 20px; font-weight: bold;"> <?php echo $row['husband_mname']; ?></span><br>
        <hr>
        <strong style="font-weight: 300">(Last):</strong><span class="space" style="margin-left: 20px; font-weight: bold;"> <?php echo $row['husband_lname']; ?></span>
    </td>
    <!-- Removed the <td class="label"> entirely for the wife section -->
    <td colspan="2" class="value">
        <div style="text-align: center; margin-bottom: 10px;">
            <strong>Wife</strong>
        </div>
        <hr>
        <strong style="font-weight: 300">(First):</strong><span class="space" style="margin-left: 20px; font-weight: bold;"> <?php echo $row['wife_fname']; ?></span><br>
        <hr>
        <strong style="font-weight: 300">(Middle):</strong><span class="space" style="margin-left: 20px; font-weight: bold;"> <?php echo $row['wife_mname']; ?></span><br>
        <hr>
        <strong style="font-weight: 300">(Last):</strong><span class="space" style="margin-left: 20px; font-weight: bold;"> <?php echo $row['wife_lname']; ?></span>
    </td>
</tr>
<tr>
    <td class="label">2a. Date of Birth</td>
    <td class="value">
        <!-- Husband's Day, Month, Year, Age -->
        <div>
        <strong style="font-weight: 300">(Day)<span class="space" style="margin-left: 20px; font-weight: 300;"> (Month)</span><span class="space" style="margin-left: 20px; font-weight: 300;"> (Year)</span></strong>
            <br><span class="space" style="margin-left: 20px; font-weight: bold;">
            <?php 
                $husband_birthday = new DateTime($row['husband_birthdate']);
                echo $husband_birthday->format("d") . "<span class='space'></span>"; // Day
            ?> 
            <?php 
                echo $husband_birthday->format("F") . "<span class='space'></span>"; // Month
            ?> 
            <?php 
                echo $husband_birthday->format("Y") . "<span class='space'></span>"; // Year
            ?> 
            </span>
        </div>
    </td>
    <td class="value">
        <strong style="font-weight: 300; margin-left: 10px;">(Age)</strong><br><span class="space" style="margin-left: 20px; font-weight: bold;">
       <?php 
                $current_date = new DateTime();
                $husband_age = $husband_birthday->diff($current_date)->y;
                echo $husband_age . " "; // Age
            ?></span>
    </td>
    <td class="value">
        <!-- Wife's Day, Month, Year, Age -->
        <div>
            <strong style="font-weight: 300">(Day)<span class="space" style="margin-left: 20px; font-weight: 300;"> (Month)</span><span class="space" style="margin-left: 20px; font-weight: 300;"> (Year)</span></strong>
            <br><span class="space" style="margin-left: 20px; font-weight: bold;">
            <?php 
                $wife_birthday = new DateTime($row['wife_birthdate']);
                echo $wife_birthday->format("d") . "<span class='space'></span>"; // Day
            ?> 
            <?php 
                echo $wife_birthday->format("F") . "<span class='space'></span>"; // Month
            ?> 
            <?php 
                echo $wife_birthday->format("Y") . "<span class='space'></span>"; // Year
            ?>
           </span>
        </div>
    </td>
    <td class="value">
        <strong style="font-weight: 300; margin-left:10px;">(Age)</strong><br><span class="space" style="margin-left: 20px; font-weight: bold;">
        <?php 
                $current_date = new DateTime();
                $husband_age = $husband_birthday->diff($current_date)->y;
                echo $husband_age . " "; // Age
            ?></span>
    </td>
</tr>



        <tr>
            <td class="label">3. Place of Birth</td>
            <td colspan="2" class="value">
                <div>
                    <strong style="font-weight: 300">(City/Municipality) (Provcince) (Country)</strong><br><span class="space" style="margin-left: 10px; font-weight: bold;">
                <?php echo $row['husband_birthplace']; ?></span>
            </td>
            <td colspan="2" class="value">
            <strong style="font-weight: 300">(City/Municipality) (Provcince) (Country)</strong><br><span class="space" style="margin-left: 10px; font-weight: bold;">
                <?php echo $row['wife_birthplace']; ?></span>
            </td>
    </div>
        </tr>
        <tr>
            <td class="label">4a. Sex<br>4b. Citizenship</td>
            <td class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_gender']; ?></span></td>
            <td class="value"><strong style="font-weight: 300">(Citizenship)</strong><br><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_citizenship']; ?></span></td>
            <td class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_gender']; ?></span></td>
            <td class="value"><strong style="font-weight: 300">(Citizenship)</strong><br><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_citizenship']; ?></span></td>
        </tr>
        
        <tr>
            <td class="label">5. Residence</td>
            <td colspan="2" class="value">
                <div>
                     <strong style="font-size: small; font-weight: 300">(House No., St, Barangay, City/Municipality, Province, Country)</strong><br>
                     <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_address']; ?></span></td>
            <td colspan="3" class="value">
            <strong style="font-size: small; font-weight: 300">(House No., St, Barangay, City/Municipality, Province, Country)</strong><br>
            <span class="space" style="margin-left: 10px; font-weight: bold;"> <?php echo $row['wife_address']; ?></span></td></div>
        </tr>
        <tr>
            <td class="label">6. Religion / Religion Sect</td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['religion']; ?></span></td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wreligion']; ?></span></td>
        </tr>
        <tr>
            <td class="label">7. Civil Status</td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_civil_status']; ?></span></td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_civil_status']; ?></span></td>
        </tr>
        <tr>
            <td class="label">8. Name of Father</td>
            <td colspan="2" class="value">
            <div>
                <strong style="font-weight: 300">(First) (Middle) (Last)</strong><br>
                <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_father_name']; ?></span></td>
            <td colspan="2" class="value">
                <strong style="font-weight: 300">(First) (Middle) (Last)</strong><br>    
                <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_father_name']; ?></span></td>
        </div>
        </tr>
        <tr>
            <td class="label">9. Citizenship</td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_father_citizenship']; ?></span></td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_fcitizenship']; ?></span></td>
        </tr>
        <tr>
            <td class="label">10. Maiden Name of Mother</td>
            <td colspan="2" class="value">
                <div>
                    <strong style="font-weight: 300">(First)  (Middle)  (Last)</strong><br>
                    <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_mother_name']; ?></span></td>
            <td colspan="2" class="value">
            <strong style="font-weight: 300">(First)  (Middle)  (Last)</strong><br>
            <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_mother_name']; ?></span></td>
    </div>
        </tr>
        <tr>
            <td class="label">11. Citizenship</td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_mother_citizenship']; ?></span></td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_mcitizenship']; ?></span></td>
        </tr>
        <tr>
            <td class="label">12. Name of Person/ Was Who Gave Consent or Advice</td>
            <td colspan="2" class="value">
                <div>
                    <strong style="font-weight: 300">(First) (Middle) (Last)</strong><br>
                    <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['advice']; ?></span></td>
            <td colspan="2" class="value">
                    <strong style="font-weight: 300">(First) (Middle) (Last)</strong><br>
                    <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_advice']; ?></span></td>
    </div>
        </tr>
        <tr>
            <td class="label">13. Relationship</td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['husband_father_citizenship']; ?></span></td>
            <td colspan="2" class="value"><span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_fcitizenship']; ?></span></td>
        </tr>
        <tr>
            <td class="label">14. Residence</td>
            <td colspan="2" class="value">
                <div><strong style="font-size: small; font-weight: 300">(House No., St, Barangay, City/Municipality, Province, Country)</strong><br>
                <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['relationship']; ?></td>
            <td colspan="2" class="value">
            <strong style="font-size: small; font-weight: 300">(House No., St, Barangay, City/Municipality, Province, Country)</strong><br>
            <span class="space" style="margin-left: 10px; font-weight: bold;"><?php echo $row['wife_relationship']; ?></td>
    </div>
        </tr>
    </table>

    <table class="main-table" style="margin-top: 1px;">
    <tr>
    <td colspan="5" class="label">
        15. Place of Marriage: 
        <span class="input" style="margin-left: 10px; font-weight: bold; font-style: italic;">
            <?php echo $row['place_of_marriage1']; ?><span class="spacing">  </span> 
            <?php echo $row['place_of_marriage2']; ?><span class="spaces">  </span> 
            <?php echo $row['place_of_marriage3']; ?>
        </span>
        <br>
        <strong style="margin-left: 17%; font-weight: 300">(Office of the/House of/Barangay of/Church of/Mosque of) <span class="space"></span>(City/Municipality) <span class="space"></span>(Province)</strong><br><br>
        16. Date of Marriage:<span class="input" style="font-weight: bold; font-style: italic; margin-left: 32px"><?php echo date("d  F  Y", strtotime($row['date_of_marriage'])); ?></span> <span class="spacess"></span>17. Time of Marriage: <span class="input" style="font-weight: bold; font-style: italic;"><?php echo date("h:i A", strtotime($row['time_of_marriage'])); ?></span><span class="space"  style="font-weight: 300">(am/pm)</span><br>
        <strong style="margin-left: 19%; font-weight: 300">(Day) (Month) (Year)</strong><br><br>
        18. CERTIFICATION OF THE CONTRACTING PARTIES<br><span class="space" style="margin-left: 85px; font-weight: 300;">THIS IS TO CERTIFY. That I,<span class="input" style="font-weight: bold; font-style: italic"><?php echo $row['husband']; ?></span>and I, <span class="input"  style="font-weight: bold; font-style: italic"><?php echo $row['wife']; ?></span>
        both of legal age, of our own free will and accord, and in the presence of the person solemnizing this marriage and of the witnessess named below, take each other as husband and wife and certifying further the we both of legal age, of our own free will and accord, and in the presence of the person solemnizing this marriage and of the witnesses named below, take each other as husband and wife and certifying further that we<span class="box-icon">⬜</span> have entered, a copy of which is hereto attached<span class="box-icon">⬜</span> have not entered into a marriage settlement 
        </span><br><span class="space" style="margin-left: 85px; font-weight: 300;">IN WITNESS WHEREOFF, we have signed/marked with our fingerprint this certificate in quadruplicate this <span class="input"  style="font-weight: bold; font-style: italic"><?php echo date("d", strtotime($row['date_of_marriage'])); ?></span>, day of <span class="input"  style="font-weight: bold; font-style: italic"><?php echo date("F Y", strtotime($row['date_of_marriage'])); ?></span></span><br>
       <span class="space" style="margin-left: 85px; font-weight: 300;">
        <div class="signature-container">
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">(Signature of Husband)</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">(Signature of Wife)</div>
            </div>
        </div>
        </span><br>
        19. CERTIFICATION OF THE SOLEMNIZING OFFICER:<br><span class="space" style="margin-left: 85px; font-weight: 300;">THIS IS TO CERTIFY. THAT BEFORE ME, on the date and place above-written parties, with their mutual consent, lawfully joined together in marriage
        which was solemnized by me in the presence of the witnesses named below, all of legal age. <br> <span class="box-icon">⬜</span> a. Marriage License No. <span class="input"  style="font-weight: bold; font-style: italic"><?php echo $row['marriage_license_no']; ?></span> issued on <span class="input" style="font-weight: bold; font-style: italic"><?php echo date("F d, Y", strtotime($row['date_created'])); ?></span>,
        at <span class="input" style="font-weight: bold; font-style: italic"><?php echo $row['place_of_marriage2']; ?>, <?php echo $row['place_of_marriage3']; ?></span> in favor of said parties, was wxhibited to me.<br> <span class="box-icon">⬜</span> b. no marriage license was necessary. the marriage being solemnized under Art<span class="input">_____</span>of Executive Order No. 209.<br>
        <span class="box-icon">⬜</span> c. the marriage was solemnized in accordance with the provisions of Presidential Decree No. 1083.</span>

        <span class="space" style="margin-left: 85px; font-weight: 300;">
        <div class="signature-container">
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">(SignatureOver Printed Name of Solemnizing Officer)</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">(Position.Designation)</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">(Religion/Religious Sect, Registry No., and Expiration Date if applicable)</div>
            </div>
        </div>
        </span><br>
        20a. WITNESSES (Print Name and Sign): <span class="space" style="margin-left: 15px; font-weight: 300; font-size: 14px;"> Additional at the back</span><br><br>
        <span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_1']; ?></span><span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_2']; ?></span>
        <span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_3']; ?></span><span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_4']; ?></span>
    </td>
</tr>
    </table>
    <table class="main-table" style="margin-top: 1px;">
    <tr>
            <td colspan="5" class="labeling">21. RECEIVED BY:<br><span class="valued" style=" font-weight: 300; font-size: 19px;"> Signature</span><span class="inputed" style="margin-left: 89px; font-weight: 300; font-size: 19px;">__________________________</span><br>
            <span class="valued" style= "font-weight: 300; font-size: 19px;"> Name in Print</span><span class="inputed" style="margin-left: 56px; font-weight: 300; font-size: 19px;">__________________________</span><br>
            <span class="valued" style= "font-weight: 300; font-size: 19px;"> Title or Position</span><span class="inputed" style="margin-left: 40px; font-weight: 300; font-size: 19px;">__________________________</span><br>
            <span class="valued" style=" font-weight: 300; font-size: 19px;"> Date</span><span class="inputed" style="margin-left: 129px; font-weight: 300; font-size: 19px;">__________________________</span>
        </td>
        <td colspan="5" class="labeling">22. REGISTERED BY THE CIVIL REGISTRAR:<br><span class="valued" style=" font-weight: 300; font-size: 19px;"> Signature</span><span class="inputed" style="margin-left: 89px; font-weight: 300; font-size: 19px;">__________________________</span><br>
            <span class="valued" style= "font-weight: 300; font-size: 19px;"> Name in Print</span><span class="inputed" style="margin-left: 56px; font-weight: 300; font-size: 19px;">__________________________</span><br>
            <span class="valued" style= "font-weight: 300; font-size: 19px;"> Title or Position</span><span class="inputed" style="margin-left: 40px; font-weight: 300; font-size: 19px;">__________________________</span><br>
            <span class="valued" style=" font-weight: 300; font-size: 19px;"> Date</span><span class="inputed" style="margin-left: 129px; font-weight: 300; font-size: 19px;">__________________________</span>
        </td>
        </tr>
    </table>

    <table class="main-table" style="margin-top: 1px;">
    <tr>
            <td colspan="5" class="labeling">20b. WITNESSES (Print Name and Sign): <span class="space" style="margin-left: 15px; font-weight: 300; font-size: 14px;"> Additional at the back</span><br><br>
        <span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_5']; ?></span><span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_6']; ?></span>
        <span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_7']; ?></span><span class="input" style="margin-left: 90px; font-weight: bold; font-size: 19px;"><?php echo $row['witnesses_8']; ?></span></td>
        </tr>
    </table>
    <table class="main-table" style="margin-top: 1px;"> 
    <tr>
    <td colspan="5" class="labeling">
    <span class="spacer" style="margin-left: 290px; font-weight: bold;">AFFIDAVIT OF SOLEMNIZING OFFICER</span> <br><span class="space" style="margin-left: 55px; font-weight: 300;">I, __________________________ , of legal age, Solemnixing Officer of _____________________________ with address at __________________________________ , after having sworn to in accordance with law, do hereby depose and say:<br>
            1. That I have solemnized the marriage between _____________________________ and _____________________________.<br>
            2. <span class="box-icon">⬜</span> a. That I have ascertained the qualifications of the contracting parties and have fun legal impediment for them to marry as required by Article 34 of the Family Code.<br>
                <span class="box-icon">⬜</span> b. That his marriage was performed in articulo mortis orp at the point of death.<br>
                <span class="box-icon">⬜</span> c. That the contracting party/ies _____________________________ and _____________________________ being at the point of death and physically unable to sign the foregoing certificate of marriage; sign for him or her by writting the dying party's name and beneath it, the witness' own signature preceded by the preposition "By";<br>
                <span class="box-icon">⬜</span> d. That the residence of either party is so located that there is no means of transportation to enable concerned party/parties to appear personally before the civil registrar;<br>
                <span class="box-icon">⬜</span> e. That the marriage was among Muslims or among members of the Ethnic Cultural Communities and that the marriage was solemnized in accordance with their customs and parties;<br>
            3. That I took the necessary steps to ascertain the ages and relationship of the contracting parties and that neither of them are under any legal impidement to marry each other;<br>
            4. That I am executing this affidavit to attest to the truthfulness of the foregoing statements of all legal intents and purpose.<br><br>

            <span class="space" style="margin-left: 55px; font-weight: 300;">In truth wherefore, I have affixed my signature below this _____ day of __________ , __________ at________________ Philippines.</span><br>
            <span class="space" style="margin-left: 85px; font-weight: 300;">
        <div class="signature-containers" >
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Signature Over Printed Name of the Solemnixing Officer</div>
            </div>
        </div>
        </span><br>
        <span class="space" style="margin-left: 55px; font-weight: bold;"> SUBSCRIBED AND SWORN </span> to before me this __________ day of ___________________, _________________ at _______________________ Philippines, affiant who exhibited to me his Community Tax Certificate _________________ issued on _______________ at ______________.<br>
        <span class="space" style="margin-left: 85px; font-weight: 300;">
        <div class="signature-container">
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Signature of the Administering Officer</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Position/Title/Designation</div>
            </div>
        </div><br>
        <div class="signature-container">
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Name in Print</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Address</div>
            </div>
        </div>
        </span>
    </td>
        </tr>
    </table>

    <table class="main-table" style="margin-top: 1px;"> 
    <tr>
    <td colspan="5" class="labeling">
    <span class="spacer" style="margin-left: 290px; font-weight: bold;">AFFIDAVIT FOR DELAYED REGISTRATION OF MARRIAGE</span> <br><span class="space" style="margin-left: 55px; font-weight: 300;">I, ___________________ , of legal age, single/married/divorce/widow/widower, with residence and postal address _________________________________________ , after having sworn to in accordance with law, do hereby depose and say:<br><br>
            1. That I am the applicant for the delayed registration of
             <span class="box-icon">⬜</span>my marriage with ______________ in _______________ on ________________ <span class="box-icon">⬜</span> the marriage between ________________ and _________________ in _________________ on _________________<br>
                <span class="box-icon">⬜</span> c. That the contracting party/ies _____________________________ and _____________________________ being at the point of death and physically unable to sign the foregoing certificate of marriage; sign for him or her by writting the dying party's name and beneath it, the witness' own signature preceded by the preposition "By";<br>
                2. That said marriage was solemnized by _________________ (Solemnizing Officer's name) under.<br>
                <span class="space" style="margin-left: 55px; font-weight: 300;"> a. <span class="box-icon">⬜</span> religious ceremony<span class="space" style="margin-left: 20px; font-weight: 300;">  b. <span class="box-icon">⬜</span> civil ceremony</span>  <span class="space" style="margin-left: 20px; font-weight: 300;">c. <span class="box-icon">⬜</span>Muslim rites</span>   <span class="space" style="margin-left: 20px; font-weight: 300;">d. <span class="box-icon">⬜</span> tribal rites</span></span><br>
            3. That the marriage solemnized:<br>
            <span class="space" style="margin-left: 20px; font-weight: 300;"><span class="box-icon">⬜</span>a. with marriage license _______________ issued on _______________ at _______________</span><br>
            <span class="space" style="margin-left: 20px; font-weight: 300;"><span class="box-icon">⬜</span>b. under Article __________ (marriage of exceptional character).</span><br>
            4. (If the applicant is either the wife or husband) That I am a citizen of _________________ and my spouse is a citizen of ____________;<br><span class="space" style="margin-left: 20px; font-weight: 300;"> (If the applicant is either the wife or husband) That the wife a citizen of _________________ the husband a citizen of ______________;</span><br>
            5. That the reason for delay is registeting out/their marriage is ___________________;<br>
            6. That I am executing this affidavit to attest to the truthfulness of the foregoing statements for all legal intents and purposes.<br><br>
            <span class="space" style="margin-left: 20px; font-weight: 300;">In truth whereof, I have affixed my signature below this _______ day of __________ , __________ at ____________ Philippines.</span><br>
            <span class="space" style="margin-left: 85px; font-weight: 300;">
        <div class="signature-containers" >
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Signature Over Printed Name of Affiant</div>
            </div>
        </div>
        </span><br><br><br>

        <span class="space" style="margin-left: 55px; font-weight: bold;"> SUBSCRIBED AND SWORN </span> to before me this __________ day of ___________________, ____________ at ________________ Philippines, affiant who exhibited to me his Community Tax Certificate _____________ issued on _______________ at ______________.<br>
        <span class="space" style="margin-left: 85px; font-weight: 300;">
        <div class="signature-container">
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Signature of the Administering Officer</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Position/Title/Designation</div>
            </div>
        </div><br>
        <div class="signature-container">
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Name in Print</div>
            </div>
            <div class="signature-line">
            <div class="underline"></div>
            <div class="labels">Address</div>
            </div>
        </div>
        </span>

    </td>
        </tr>
    </table>

</body>
</html>
