<?php
require_once('../../config.php');

// Check if ID is set in GET request
if (isset($_GET['id']) && $_GET['id'] > 0) {
    // Fetch baptism request from the database
    $qry = $conn->query("SELECT r.*, t.sched_type FROM `baptism_schedule` r 
                         INNER JOIN `schedule_type` t ON r.sched_type_id = t.id 
                         WHERE r.id = '{$_GET['id']}'");
    
    // Check if a record was found
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v; // Dynamically create variables from the fetched row
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="baptism-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="sched_type_id" value="<?php echo isset($sched_type_id) ? $sched_type_id : '' ?>">
        <div class="col-12">
            <h4>Request For: <?php echo isset($sched_type) ? $sched_type : '' ?></h4>
            <div class="row">
                <div class="col-md-6">
                    <!-- Child Fullname -->
                    <div class="form-group">
                        <label for="child_fullname" class="control-label">Child Fullname</label>
                        <input type="text" name="child_fullname" id="child_fullname" class="form-control rounded-0" value="<?php echo isset($child_fullname) ? $child_fullname : '' ?>" required>
                    </div>
                    <!-- Birthplace -->
                    <div class="form-group">
                        <label for="birthplace" class="control-label">Birthplace</label>
                        <input type="text" name="birthplace" id="birthplace" class="form-control rounded-0" value="<?php echo isset($birthplace) ? $birthplace : '' ?>" required>
                    </div>
                    <!-- Birthdate -->
                    <div class="form-group">
                        <label for="birthdate" class="control-label">Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate" class="form-control rounded-0" value="<?php echo isset($birthdate) ? $birthdate : '' ?>" required>
                    </div>
                    <!-- Father Name -->
                    <div class="form-group">
                        <label for="father" class="control-label">Father Name</label>
                        <input type="text" name="father" id="father" class="form-control rounded-0" value="<?php echo isset($father) ? $father : '' ?>" required>
                    </div>
                    <!-- Mother Name -->
                    <div class="form-group">
                        <label for="mother" class="control-label">Mother Name</label>
                        <input type="text" name="mother" id="mother" class="form-control rounded-0" value="<?php echo isset($mother) ? $mother : '' ?>" required>
                    </div>
                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" class="form-control rounded-0" required><?php echo isset($address) ? $address : '' ?></textarea>
                    </div>
                    <!-- Date of Baptism -->
                    <div class="form-group">
                        <label for="date_of_baptism" class="control-label">Date of Baptism</label>
                        <input type="datetime-local" name="date_of_baptism" id="date_of_baptism" class="form-control rounded-0" value="<?php echo isset($date_of_baptism) ? date("Y-m-d\TH:i", strtotime($date_of_baptism)) : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Minister Name -->
                    <div class="form-group">
                        <label for="minister" class="control-label">Minister Name</label>
                        <input type="text" name="minister" id="minister" class="form-control rounded-0" value="<?php echo isset($minister) ? $minister : '' ?>" required>
                    </div>
                    <!-- Position -->
                    <div class="form-group">
                        <label for="position" class="control-label">Position</label>
                        <input type="text" name="position" id="position" class="form-control rounded-0" value="<?php echo isset($position) ? $position : '' ?>" required>
                    </div>
                    <!-- Sponsors -->
                    <div class="form-group">
                        <label for="sponsors" class="control-label">Sponsors</label>
                        <input type="text" name="sponsors" id="sponsors" class="form-control rounded-0" value="<?php echo isset($sponsors) ? $sponsors : '' ?>" required>
                    </div>
                    <!-- Book Number -->
                    <div class="form-group">
                        <label for="book_no" class="control-label">Book Number</label>
                        <input type="number" name="book_no" id="book_no" class="form-control rounded-0" value="<?php echo isset($book_no) ? $book_no : '' ?>" required>
                    </div>
                    <!-- Page -->
                    <div class="form-group">
                        <label for="page" class="control-label">Page</label>
                        <input type="number" name="page" id="page" class="form-control rounded-0" value="<?php echo isset($page) ? $page : '' ?>" required>
                    </div>
                    <!-- Volume -->
                    <div class="form-group">
                        <label for="volume" class="control-label">Volume</label>
                        <input type="number" name="volume" id="volume" class="form-control rounded-0" value="<?php echo isset($volume) ? $volume : '' ?>" required>
                    </div>
                    <!-- Date Issue -->
                    <div class="form-group">
                        <label for="date_issue" class="control-label">Date Issue</label>
                        <input type="datetime-local" name="date_issue" id="date_issue" class="form-control rounded-0" value="<?php echo isset($date_issue) ? date("Y-m-d\TH:i", strtotime($date_issue)) : '' ?>" required>
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
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('#baptism-form').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally
            var _this = $(this);
            $('.err-msg').remove(); // Clear previous error messages
            start_loader(); // Start the loader

            // Send an AJAX request to save the baptism request
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_baptism_req",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader(); // Stop the loader
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload(); // Reload the page on success
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                            .addClass("alert alert-danger err-msg")
                            .text(resp.msg);
                        _this.prepend(el); // Show the error message
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader(); // Stop the loader
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader(); // Stop the loader
                        console.log(resp); // Log the response
                    }
                }
            });
        });
    });
</script>
