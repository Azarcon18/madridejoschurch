<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Scheduling Form</title>
</head>
<body>
    <h1>Schedule Your Wedding</h1>
    <form action="" id="wedding-schedule-form">
        <div class="form-group">
            <label for="bride_name">Bride's Name:</label>
            <input type="text" id="bride_name" name="bride_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="groom_name">Groom's Name:</label>
            <input type="text" id="groom_name" name="groom_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="wedding_date">Wedding Date:</label>
            <input type="date" id="wedding_date" name="wedding_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="venue">Venue:</label>
            <input type="text" id="venue" name="venue" class="form-control" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save Wedding Schedule</button>
        </div>
    </form>
</body>

<script>
    $(document).ready(function(){
    $('#wedding-schedule-form').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();
        start_loader();

        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_wedding_schedule", // New endpoint
            data: new FormData(_this[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            error: function(err){
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp === 'object' && resp.status === 'success'){
                    location.href = "./?page=wedding_schedules"; // Redirect upon success
                } else if(resp.status === 'failed' && !!resp.msg){
                    var el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
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
</html>
