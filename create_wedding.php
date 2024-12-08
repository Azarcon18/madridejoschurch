<div class="container-fluid">
    <form action="" id="appointment-form">
        <input type="hidden" name="id">
        <input type="hidden" name="sched_type_id" value="<?php echo htmlspecialchars($_GET['sched_type_id'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="col-12">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                <p><strong>Husband</strong></p>
                    <div class="form-group">
                        <label for="husband_fname" class="control-label">First Name</label>
                        <input type="text" name="husband_fname" id="husband_fname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="husband_mname" class="control-label">Middle Name</label>
                        <input type="text" name="husband_mname" id="husband_mname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="husband_lname" class="control-label">Last Name</label>
                        <input type="text" name="husband_lname" id="husband_lname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="birthdate" class="control-label">Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate" class="form-control rounded-0" required onchange="calculateAge()">
                    </div>
                    <div class="form-group">
                        <label for="age" class="control-label">Age</label>
                        <input type="number" name="age" id="age" class="form-control rounded-0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="birthplace" class="control-label">Place of Birth</label>
                        <input type="text" name="birthplace" id="birthplace" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                    <label for="gender" class="control-label">Sex/Gender</label>
                    <select name="gender" id="gender" class="form-control rounded-0" required>
                        <option value="">Select Sex/Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="non-binary">Non-binary</option>
                        <option value="other">Other</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                </div>
                    <div class="form-group">
                        <label for="citizenship" class="control-label">Citizenship</label>
                        <input type="text" name="citizenship" id="citizenship" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="religion" class="control-label">Religion</label>
                        <input type="text" name="religion" id="religion" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Residence</label>
                        <textarea name="address" id="address" class="form-control rounded-0" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="civil_status" class="control-label">Civil Status</label>
                        <input type="text" name="civil_status" id="civil_status" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="father_name" class="control-label">Father Name</label>
                        <input type="text" name="father_name" id="father_name" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="fcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="fcitizenship" id="fcitizenship" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="mother_name" class="control-label">Mother Name</label>
                        <input type="text" name="mother_name" id="mother_name" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="mcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="mcitizenship" id="mcitizenship" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="advice" class="control-label">Name of a Persons Was Who Given Consent or Advice</label>
                        <input type="text" name="advice" id="advice" class="form-control rounded-0" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
                        <label for="relationship" class="control-label">Relationship</label>
                        <input type="text" name="relationship" id="relationship" class="form-control rounded-0" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
                        <label for="residence" class="control-label">Residence</label>
                        <textarea name="residence" id="residence" class="form-control rounded-0" required></textarea>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                <p><strong>Wife</strong></p>
                    <div class="form-group">
                        <label for="wife_fname" class="control-label">First Name</label>
                        <input type="text" name="wife_fname" id="wife_fname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_mname" class="control-label">Middle Name</label>
                        <input type="text" name="wife_mname" id="wife_mname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_lname" class="control-label">Last Name</label>
                        <input type="text" name="wife_lname" id="wife_lname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_birthdate" class="control-label">Birthdate</label>
                        <input type="date" name="wife_birthdate" id="wife_birthdate" class="form-control rounded-0" required onchange="calculateWifeAge()">
                    </div>
                    <div class="form-group">
                        <label for="wife_age" class="control-label">Age</label>
                        <input type="number" name="wife_age" id="wife_age" class="form-control rounded-0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="wife_birthplace" class="control-label">Place of Birth</label>
                        <input type="text" name="wife_birthplace" id="wife_birthplace" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                    <label for="wife_gender" class="control-label">Sex/Gender</label>
                    <select name="wife_gender" id="wife_gender" class="form-control rounded-0" required>
                        <option value="">Select Sex/Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="non-binary">Non-binary</option>
                        <option value="other">Other</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="wife_citizenship" class="control-label">Citizenship</label>
                        <input type="text" name="wife_citizenship" id="wife_citizenship" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wreligion" class="control-label">Religion</label>
                        <input type="text" name="wreligion" id="wreligion" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_address" class="control-label">Residence</label>
                        <textarea name="wife_address" id="wife_address" class="form-control rounded-0" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="wife_civil_status" class="control-label">Civil Status</label>
                        <input type="text" name="wife_civil_status" id="wife_civil_status" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_father_name" class="control-label">Father Name</label>
                        <input type="text" name="wife_father_name" id="wife_father_name" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_fcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="wife_fcitizenship" id="wife_fcitizenship" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_mother_name" class="control-label">Mother Name</label>
                        <input type="text" name="wife_mother_name" id="wife_mother_name" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_mcitizenship" class="control-label">Citizenship</label>
                        <input type="text" name="wife_mcitizenship" id="wife_mcitizenship" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="wife_advice" class="control-label">Name of a Persons Was Who Given Consent or Advice</label>
                        <input type="text" name="wife_advice" id="wife_advice" class="form-control rounded-0" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
                        <label for="wife_relationship" class="control-label">Relationship</label>
                        <input type="text" name="wife_relationship" id="wife_relationship" class="form-control rounded-0" required>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                    <div class="form-group">
                        <label for="wife_residence" class="control-label">Residence</label>
                        <textarea name="wife_residence" id="wife_residence" class="form-control rounded-0" required></textarea>
                        <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                    </div>
                </div>
                <div class="form-group">
                <div class="form-group">
                    <label class="control-label">Witnesses</label>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <input type="text" name="witnesses_<?php echo $i; ?>" id="witnesses_<?php echo $i; ?>" class="form-control rounded-0 mb-2" required>
                    <?php endfor; ?>
                    <span class="ml-2 text-muted">* Enter N/A if not applicable</span>
                </div>


                <div class="form-group">
                <p><strong>Place of Marriage</strong></p>
                        <textarea name="place_of_marriage1" id="place_of_marriage1" class="form-control rounded-0" required></textarea>
                        <label for="place_of_marriage1" class="control-label">(Office of the/ House of/ Barangay of/ Church of/ Mosque of)</label>
                        <textarea name="place_of_marriage2" id="place_of_marriage2" class="form-control rounded-0" required></textarea>
                        <label for="place_of_marriage2" class="control-label">(City/Municipality)</label>
                        <textarea name="place_of_marriage3" id="place_of_marriage3" class="form-control rounded-0" required></textarea>
                        <label for="place_of_marriage3" class="control-label">(Province)</label>
                </div>
                <div class="form-group">
                        <label for="date_of_marriage" class="control-label">Date of Marriage</label>
                        <input type="date" name="date_of_marriage" id="date_of_marriage" class="form-control rounded-0" required>
                        <span class="ml-2 text-muted">(Day)  (Month)  (Year)</span>
                    </div>
                <div class="form-group">
                        <label for="time_of_marriage" class="control-label">Time of Marriage</label>
                        <input type="time" name="time_of_marriage" id="time_of_marriage" class="form-control rounded-0" required>
                        <span class="ml-2 text-muted">(AM / PM)</span>
                </div>
                <div class="form-group">
                        <label for="marriage_license_no" class="control-label">Marriage License No.</label>
                        <input type="text" name="marriage_license_no" id="marriage_license_no" class="form-control rounded-0" readonly>
                </div>
            </div>
        </div>
    </form>
</div>

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

<script>
   $(function(){
    $('#appointment-form').submit(function(e){
        e.preventDefault();

        // Check form validity before proceeding
        if (!this.checkValidity()) {
            this.reportValidity(); // Triggers the browser's default validation messages
            return; // Prevent form submission if any required field is not filled
        }

        var form = $(this);

        // Remove existing error messages
        $('.err-msg').remove();

        // Start the loader animation
        start_loader();

        // Ajax form submission
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_wedding_req",
            data: new FormData(this), // Collects form data
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json', // Expecting a JSON response
            error: function(err){
                // Enhanced error logging
                console.error("AJAX error: ", err);
                alert_toast("An error occurred while submitting the form", 'error');
                end_loader();
            },
            success: function(resp){
                if (typeof resp == 'object' && resp.status == 'success') {
                    end_loader();
                    setTimeout(() => {
                        uni_modal('', 'success_msg.php'); // Show success modal
                    }, 200);
                } else if (resp.status == 'failed' && resp.msg) {
                    // Displaying error message from response
                    var el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                    form.prepend(el);
                    el.show('slow');
                    $("html, body").animate({ scrollTop: form.offset().top }, "fast");
                    end_loader();
                } else {
                    alert_toast("An unexpected error occurred", 'error');
                    console.log(resp);
                    end_loader();
                }
            }
        });
    });
});

</script>

<script>
function calculateAge() {
    var birthdate = new Date(document.getElementById("birthdate").value);
    var today = new Date();
    var age = today.getFullYear() - birthdate.getFullYear();
    var monthDiff = today.getMonth() - birthdate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    
    document.getElementById("age").value = age;
}
</script>

<script>
function calculateWifeAge() {
    var birthdate = new Date(document.getElementById("wife_birthdate").value);
    var today = new Date();
    var age = today.getFullYear() - birthdate.getFullYear();
    var monthDiff = today.getMonth() - birthdate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    
    document.getElementById("wife_age").value = age;
}
</script>
