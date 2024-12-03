<div class="container-fluid">
    <form action="" id="appointment-form">
        <input type="hidden" name="id">
        <input type="hidden" name="sched_type_id" value="<?php echo $_GET['sched_type_id'] ?>">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fullname" class="control-label">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
    <label for="contact" class="control-label">Contact</label>
    <input type="text" name="contact" id="contact" class="form-control rounded-0" required
        pattern="09\d{9}" maxlength="11" value="09" oninput="this.value = '09' + this.value.slice(2).replace(/[^0-9]/g, '')" 
        placeholder="09XXXXXXXXX">
</div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" class="form-control rounded-0" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="facebook" class="control-label">Facebook</label>
                        <input type="text" name="facebook" id="facebook" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="schedule" class="control-label">Desired Schedule</label>
                        <input type="datetime-local" name="schedule" id="schedule" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control rounded-0" required></textarea>
                    </div>
                </div>
            </div>

            <h5>Death Person </h5>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="death_person_fullname" class="control-label">Full Name</label>
                        <input type="text" name="death_person_fullname" id="death_person_fullname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
    <label for="gender" class="control-label">Gender</label>
    <select name="gender" id="gender" class="form-control rounded-0" required>
        <option value="" disabled selected>Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Gay">Gay</option>
        <option value="Lesbian">Lesbian</option>
        <option value="Bisexual/Bi">Bisexual/Bi</option>
        <option value="Trans Gender">Trans Gender</option>
    </select>
</div>
<div class="form-group">
    <label for="date_of_death" class="control-label">Date of Death</label>
    <input type="date" name="date_of_death" id="date_of_death" class="form-control rounded-0" required>
</div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
    <label for="birthdate" class="control-label">Birthdate</label>
    <input type="date" name="birthdate" id="birthdate" class="form-control rounded-0" required>
</div>
                    <div class="form-group">
    <label for="civil_status" class="control-label">Civil Status</label>
    <select name="civil_status" id="civil_status" class="form-control rounded-0" required>
        <option value="" disabled selected>Select Civil Status</option>
        <option value="single">Single</option>
        <option value="married">Married</option>
        <option value="divorced">Divorced</option>
        <option value="widowed">Widowed</option>
    </select>
</div>
                    <div class="form-group">
                        <label for="resident" class="control-label">Resident</label>
                        <input type="text" name="resident" id="resident" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
    <label for="nationality" class="control-label">Nationality</label>
    <select name="nationality" id="nationality" class="form-control rounded-0" required>
        <option value="" disabled selected>Select your nationality</option>
        <option value="Filipino">Filipino</option>
        <option value="American">American</option>
        <option value="Canadian">Canadian</option>
        <option value="British">British</option>
        <option value="Australian">Australian</option>
        <option value="Indian">Indian</option>
    </select>
</div>
                    <div class="form-group">
                        <label for="mother" class="control-label">Entrepreneur of (Mother)</label>
                        <input type="text" name="mother" id="mother" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="father" class="control-label">Entrepreneur of (Father)</label>
                        <input type="text" name="father" id="father" class="form-control rounded-0" required>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    
     // Get today's date in YYYY-MM-DD format
     const today = new Date().toISOString().split('T')[0];
    
    // Set the 'max' attribute of the date input to today's date
    document.getElementById('birthdate').setAttribute('max', today);

    
    $(function(){
        $('#appointment-form').submit(function(e){
            e.preventDefault();
            
            // Check form validity before proceeding
            if (!this.checkValidity()) {
                this.reportValidity(); // Triggers browser's default validation messages
                return; // Stop if form is invalid
            }

            var _this = $(this);
            $('.err-msg').remove();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_appointment_req",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        end_loader();
                        setTimeout(() => {
                            uni_modal('', 'success_msg.php');
                        }, 200);
                    } else if (resp.status === 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                        
                    }
                }
            });
        });
    });
</script>
