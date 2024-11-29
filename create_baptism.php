<div class="container-fluid">
    <form action="" id="appointment-form" method="POST">
        <input type="hidden" name="sched_type_id" value="<?php echo htmlspecialchars($_GET['sched_type_id'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="col-12">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="child_fullname" class="control-label">Child Fullname</label>
                        <input type="text" name="child_fullname" id="child_fullname" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="birthplace" class="control-label">Birthplace</label>
                        <input type="text" name="birthplace" id="birthplace" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="birthdate" class="control-label">Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="father" class="control-label">Father's Name</label>
                        <input type="text" name="father" id="father" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="mother" class="control-label">Mother's Name</label>
                        <input type="text" name="mother" id="mother" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" class="form-control rounded-0" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date_of_baptism" class="control-label">Date of Baptism</label>
                        <input type="date" name="date_of_baptism" id="date_of_baptism" class="form-control rounded-0" required>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="minister" class="control-label">Minister's Name</label>
                        <input type="text" name="minister" id="minister" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="position" class="control-label">Position</label>
                        <input type="text" name="position" id="position" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="sponsors" class="control-label">Sponsors</label>
                        <input type="text" name="sponsors" id="sponsors" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="book_no" class="control-label">Baptismal Register Book No.</label>
                        <input type="number" name="book_no" id="book_no" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="page" class="control-label">Page No.</label>
                        <input type="number" name="page" id="page" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="volume" class="control-label">Volume</label>
                        <input type="number" name="volume" id="volume" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="date_issue" class="control-label">Date Issue</label>
                        <input type="date" name="date_issue" id="date_issue" class="form-control rounded-0" required>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#appointment-form').submit(function(e){
            e.preventDefault();

            // Check form validity before submitting
            if (!this.checkValidity()) {
                this.reportValidity(); // Display browser validation messages
                return; // Stop form submission if invalid
            }

            var form = $(this);

            // Remove existing error messages
            $('.err-msg').remove();

            // Start the loader animation
            start_loader();

            // Prepare FormData
            var formData = new FormData(this);

            // Optional: Debug - Log the form data for inspection
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ': ' + pair[1]);
            }

            // Ajax form submission
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_baptism_req",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err){
                    console.error("AJAX error: ", err);
                    alert_toast("An error occurred while submitting the form", 'error');
                    end_loader();
                },
                success: function(resp){
                    if (typeof resp === 'object' && resp.status === 'success') {
                        end_loader();
                        setTimeout(() => {
                            uni_modal('', 'success_msg.php'); // Show success modal
                        }, 200);
                    } else if (resp.status === 'failed' && resp.msg) {
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
