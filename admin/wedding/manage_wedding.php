<?php
require_once('../../config.php');

// Check if ID is set in GET request
if (isset($_GET['id']) && $_GET['id'] > 0) {
    // Use prepared statement to prevent SQL injection
    $id = intval($_GET['id']);
    $qry = $conn->prepare("SELECT r.*, t.sched_type FROM `wedding_schedules` r 
                           INNER JOIN `schedule_type` t ON r.sched_type_id = t.id 
                           WHERE r.id = ?");
    $qry->bind_param('i', $id);
    $qry->execute();
    $result = $qry->get_result();
    
    // Check if a record was found
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        foreach ($data as $k => $v) {
            $$k = $v; // Dynamically create variables from the fetched row
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="wedding-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="sched_type_id" value="<?php echo isset($sched_type_id) ? $sched_type_id : '' ?>">
        <div class="col-12">
            <h4>Request For: <?php echo isset($sched_type) ? $sched_type : '' ?></h4><br>
            <div class="row">
                <div class="col-md-6">
                    <!-- Husband's Fullname -->
                    <p><strong>Husband</strong></p>
                    <div class="form-group">
                        <label for="husband_fname" class="control-label">First Name</label>
                        <input type="text" name="husband_fname" id="husband_fname" class="form-control rounded-0" value="<?php echo isset($husband_fname) ? $husband_fname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="husband_mname" class="control-label">Middle Name</label>
                        <input type="text" name="husband_mname" id="husband_mname" class="form-control rounded-0" value="<?php echo isset($husband_mname) ? $husband_mname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="husband_lname" class="control-label">Last Name</label>
                        <input type="text" name="husband_lname" id="husband_lname" class="form-control rounded-0" value="<?php echo isset($husband_lname) ? $husband_lname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="birthdate1" class="control-label">Birthdate</label>
                        <input type="date" name="birthdate1" id="birthdate1" class="form-control rounded-0" value="<?php echo isset($birthdate1) ? $birthdate1 : '' ?>" required onchange="calculateAge('birthdate1', 'age')">
                    </div>
                    <div class="form-group">
                        <label for="age" class="control-label">Age</label>
                        <input type="number" name="age" id="age" class="form-control rounded-0" value="<?php echo isset($age) ? $age : '' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="birthplace" class="control-label">Place of Birth</label>
                        <input type="text" name="birthplace" id="birthplace" class="form-control rounded-0" value="<?php echo isset($birthplace) ? $birthplace : '' ?>" required>
                    </div>
                    <div class="form-group">
    <label for="gender" class="control-label">Sex/Gender</label>
    <select name="gender" id="gender" class="form-control rounded-0" required>
        <option value="">Select Sex/Gender</option>
        <option value="male" <?php echo isset($gender) && $gender == 'male' ? 'selected' : '' ?>>Male</option>
        <option value="female" <?php echo isset($gender) && $gender == 'female' ? 'selected' : '' ?>>Female</option>
        <option value="non-binary" <?php echo isset($gender) && $gender == 'non-binary' ? 'selected' : '' ?>>Non-binary</option>
        <option value="other" <?php echo isset($gender) && $gender == 'other' ? 'selected' : '' ?>>Other</option>
        <option value="prefer-not-to-say" <?php echo isset($gender) && $gender == 'prefer-not-to-say' ? 'selected' : '' ?>>Prefer not to say</option>
    </select>
</div>

                    <div class="form-group">
                        <label for="citizenship" class="control-label">Citizenship</label>
                        <input type="text" name="citizenship" id="citizenship" class="form-control rounded-0" value="<?php echo isset($citizenship) ? $citizenship : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="religion" class="control-label">Religion</label>
                        <input type="text" name="religion" id="religion" class="form-control rounded-0" value="<?php echo isset($religion) ? $religion : '' ?>" required>
                    </div>
                    <div class="form-group">
    <label for="address" class="control-label">Residence</label>
    <textarea name="address" id="address" class="form-control rounded-0" required><?php echo isset($address) ? $address : '' ?></textarea>
</div>

                    <div class="form-group">
                        <label for="civil_status" class="control-label">Civil Status</label>
                        <input type="text" name="civil_status" id="civil_status" class="form-control rounded-0" value="<?php echo isset($civil_status) ? $civil_status : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="father_name" class="control-label">Father Name</label>
                        <input type="text" name="father_name" id="father_name" class="form-control rounded-0" value="<?php echo isset($father_name) ? $father_name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="fcitizenship" id="fcitizenship" class="form-control rounded-0" value="<?php echo isset($fcitizenship) ? $fcitizenship : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mreligion" class="control-label">Religion</label>
                        <input type="text" name="mreligion" id="mreligion" class="form-control rounded-0" value="<?php echo isset($mreligion) ? $mreligion : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mother_name" class="control-label">Mother Name</label>
                        <input type="text" name="mother_name" id="mother_name" class="form-control rounded-0" value="<?php echo isset($mother_name) ? $mother_name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="mcitizenship" id="mcitizenship" class="form-control rounded-0" value="<?php echo isset($mcitizenship) ? $mcitizenship : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="advice" class="control-label">Name of a Persons Was Who Given Consent or Advice</label>
                        <input type="text" name="advice" id="advice" class="form-control rounded-0" value="<?php echo isset($advice) ? $advice : '' ?>" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
                        <label for="relationship" class="control-label">Relationship</label>
                        <input type="text" name="relationship" id="relationship" class="form-control rounded-0" value="<?php echo isset($relationship) ? $relationship : '' ?>" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
    <label for="residence" class="control-label">Residence</label>
    <textarea name="residence" id="residence" class="form-control rounded-0" required><?php echo isset($residence) ? $residence : '' ?></textarea>
    <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
</div>
                </div>
                <div class="col-md-6">
                    <!-- Wife's Fullname -->
                    <p><strong>Wife</strong></p>
                    <div class="form-group">
                        <label for="wife_fname" class="control-label">First Name</label>
                        <input type="text" name="wife_fname" id="wife_fname" class="form-control rounded-0" value="<?php echo isset($wife_fname) ? $wife_fname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_mname" class="control-label">Middle Name</label>
                        <input type="text" name="wife_mname" id="wife_mname" class="form-control rounded-0" value="<?php echo isset($wife_mname) ? $wife_mname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_lname" class="control-label">Last Name</label>
                        <input type="text" name="wife_lname" id="wife_lname" class="form-control rounded-0" value="<?php echo isset($wife_lname) ? $wife_lname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_birthdate" class="control-label">Birthdate</label>
                        <input type="date" name="wife_birthdate" id="wife_birthdate" class="form-control rounded-0" value="<?php echo isset($wife_birthdate) ? $wife_birthdate : '' ?>" required onchange="calculateAge('wife_birthdate', 'wife_age')">
                    </div>
                    <div class="form-group">
                        <label for="wife_age" class="control-label">Age</label>
                        <input type="number" name="wife_age" id="wife_age" class="form-control rounded-0" value="<?php echo isset($wife_age) ? $wife_age : '' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="wife_birthplace" class="control-label">Place of Birth</label>
                        <input type="text" name="wife_birthplace" id="wife_birthplace" class="form-control rounded-0" value="<?php echo isset($wife_birthplace) ? $wife_birthplace : '' ?>" required>
                    </div>
                    <div class="form-group">
    <label for="gender" class="control-label">Sex/Gender</label>
    <select name="gender" id="gender" class="form-control rounded-0" required>
        <option value="">Select Sex/Gender</option>
        <option value="male" <?php echo isset($gender) && $gender == 'male' ? 'selected' : '' ?>>Male</option>
        <option value="female" <?php echo isset($gender) && $gender == 'female' ? 'selected' : '' ?>>Female</option>
        <option value="non-binary" <?php echo isset($gender) && $gender == 'non-binary' ? 'selected' : '' ?>>Non-binary</option>
        <option value="other" <?php echo isset($gender) && $gender == 'other' ? 'selected' : '' ?>>Other</option>
        <option value="prefer-not-to-say" <?php echo isset($gender) && $gender == 'prefer-not-to-say' ? 'selected' : '' ?>>Prefer not to say</option>
    </select>
</div>
                    <div class="form-group">
                        <label for="wife_citizenship" class="control-label">Citizenship</label>
                        <input type="text" name="wife_citizenship" id="wife_citizenship" class="form-control rounded-0" value="<?php echo isset($wife_age) ? $wife_age : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wreligion" class="control-label">Religion</label>
                        <input type="text" name="wreligion" id="wreligion" class="form-control rounded-0" value="<?php echo isset($wreligion) ? $wreligion : '' ?>" required>
                    </div>
                    <div class="form-group">
    <label for="wife_address" class="control-label">Residence</label>
    <textarea name="wife_address" id="wife_address" class="form-control rounded-0" required><?php echo isset($wife_address) ? $wife_address : '' ?></textarea>
</div>
                    <div class="form-group">
                        <label for="wife_civil_status" class="control-label">Civil Status</label>
                        <input type="text" name="wife_civil_status" id="wife_civil_status" class="form-control rounded-0" value="<?php echo isset($wife_civil_status) ? $wife_civil_status : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_father_name" class="control-label">Father Name</label>
                        <input type="text" name="wife_father_name" id="wife_father_name" class="form-control rounded-0" value="<?php echo isset($wife_father_name) ? $wife_father_name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_fcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="wife_fcitizenship" id="wife_fcitizenship" class="form-control rounded-0" value="<?php echo isset($wife_fcitizenship) ? $wife_fcitizenship : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wreligion" class="control-label">Religion</label>
                        <input type="text" name="wreligion" id="wreligion" class="form-control rounded-0" value="<?php echo isset($wreligion) ? $wreligion : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_mother_name" class="control-label">Mother Name</label>
                        <input type="text" name="wife_mother_name" id="wife_mother_name" class="form-control rounded-0" value="<?php echo isset($wife_mother_name) ? $wife_mother_name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_mcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="wife_mcitizenship" id="wife_mcitizenship" class="form-control rounded-0" value="<?php echo isset($wife_mcitizenship) ? $wife_mother_name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_advice" class="control-label">Name of a Persons Was Who Given Consent or Advice</label>
                        <input type="text" name="wife_advice" id="wife_advice" class="form-control rounded-0" value="<?php echo isset($wife_advice) ? $wife_advice : '' ?>" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
                        <label for="wife_relationship" class="control-label">Relationship</label>
                        <input type="text" name="wife_relationship" id="wife_relationship" class="form-control rounded-0" value="<?php echo isset($wife_relationship) ? $wife_relationship : '' ?>" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
    <label for="residence" class="control-label">Residence</label>
    <textarea name="residence" id="residence" class="form-control rounded-0" required><?php echo isset($residence) ? $residence : '' ?></textarea>
    <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
</div>
                </div>
</div>
<!-- Witnesses -->
<div class="form-group">
    <label class="control-label">Witnesses</label>
    <?php for ($i = 1; $i <= 8; $i++): ?>
        <input type="text" name="witnesses_<?php echo $i; ?>" id="witnesses_<?php echo $i; ?>" class="form-control rounded-0 mb-2" value="<?php echo isset(${'witnesses_' . $i}) ? ${'witnesses_' . $i} : '' ?>" required>
    <?php endfor; ?>
    <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
</div>


            <!-- Marriage Details -->
            <div class="form-group">
                <label for="place_of_marriage1" class="control-label">Place of Marriage</label>
                <textarea name="place_of_marriage1" id="place_of_marriage1" class="form-control rounded-0" required><?php echo isset($place_of_marriage1) ? $place_of_marriage1 : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_of_marriage" class="control-label">Date of Marriage</label>
                <input type="date" name="date_of_marriage" id="date_of_marriage" class="form-control rounded-0" value="<?php echo isset($date_of_marriage) ? $date_of_marriage : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="time_of_marriage" class="control-label">Time of Marriage</label>
                <input type="time" name="time_of_marriage" id="time_of_marriage" class="form-control rounded-0" value="<?php echo isset($time_of_marriage) ? $time_of_marriage : '' ?>" required>
            </div>

            <!-- Marriage License -->
            <div class="form-group">
                <label for="marriage_license_no" class="control-label">Marriage License No.</label>
                <input type="text" name="marriage_license_no" id="marriage_license_no" class="form-control rounded-0" value="<?php echo isset($marriage_license_no) ? $marriage_license_no : '' ?>" readonly>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select custom-select-sm rounded-0" required>
                    <option value="0" <?php echo (isset($status) && $status == 0) ? "selected" : "" ?>>Pending</option>
                    <option value="1" <?php echo (isset($status) && $status == 1) ? "selected" : "" ?>>Confirmed</option>
                    <option value="2" <?php echo (isset($status) && $status == 2) ? "selected" : "" ?>>Cancelled</option>
                </select>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
    $('#wedding-form').submit(function(e) {
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();
        start_loader();

        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_wedding_req",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    location.reload();
                } else if (resp.status === 'failed' && resp.msg) {
                    var el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                    _this.prepend(el);
                    el.show('slow');
                    $("html, body").scrollTop(0);
                } else {
                    alert_toast("An error occurred.", 'error');
                }
                end_loader();
            }
        });
    });
});
</script>
<script>
function calculateAge(birthdateId, ageId) {
    var birthdate = new Date(document.getElementById(birthdateId).value);
    var today = new Date();
    var age = today.getFullYear() - birthdate.getFullYear();
    var monthDiff = today.getMonth() - birthdate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    
    document.getElementById(ageId).value = age;
}
</script>

<script>
        function generateLicenseNumber() {
            // Generate a simple license number: current timestamp + random number
            const timestamp = new Date().getTime();
            const randomNumber = Math.floor(Math.random() * 1000);  // Add a random 3-digit number
            const licenseNo = `ML-${timestamp}-${randomNumber}`;

            // Set the value of the Marriage License No. input
            document.getElementById("marriage_license_no").value = licenseNo;
        }

        window.onload = generateLicenseNumber;
    </script>
    