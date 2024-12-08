<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `registered_users` WHERE `user_id` = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="user-form">
        <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : '' ?>">
        <div class="col-12">
            <h4>User Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control rounded-0" value="<?php echo isset($name) ? $name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="user_name" class="control-label">Username</label>
                        <input type="text" name="user_name" id="user_name" class="form-control rounded-0" value="<?php echo isset($user_name) ? $user_name : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control rounded-0" value="<?php echo isset($email) ? $email : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone_no" class="control-label">Phone Number</label>
                        <input type="text" name="phone_no" id="phone_no" class="form-control rounded-0" value="<?php echo isset($phone_no) ? $phone_no : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" class="form-control rounded-0" required><?php echo isset($address) ? $address : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="custom-select custom-select-sm rounded-0" required>
                            <option value="active" <?php echo (isset($status) && $status == 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?php echo (isset($status) && $status == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        $('#user-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_user",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.error(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload();
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
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
