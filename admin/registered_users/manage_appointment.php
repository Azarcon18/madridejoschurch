<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT r.*, t.sched_type from `appointment_request` r inner join `schedule_type` t on r.sched_type_id = t.id where r.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="appointment-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="sched_type_id" value="<?php echo isset($sched_type_id) ? $sched_type_id : '' ?>">
        <div class="col-12">
			<h4>Request For: <?php echo $sched_type ?></h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fullname" class="control-label">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control rounded-0" value="<?php echo isset($fullname) ? $fullname : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control rounded-0" value="<?php echo isset($contact) ? $contact : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea colspan='3' type="text" name="address" id="address" class="form-control rounded-0" required><?php echo isset($address) ? $address : '' ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="schedule" class="control-label">Desired Schedule</label>
                        <input type="datetime-local" name="schedule" id="schedule" class="form-control rounded-0"  value="<?php echo isset($schedule) ? date("Y-m-d\TH:i",strtotime($schedule)) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <textarea colspan='3' type="text" name="remarks" id="remarks" class="form-control rounded-0" required><?php echo isset($remarks) ? $remarks : '' ?></textarea>
                    </div>
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
    $(function(){
        $('#appointment-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_appointment_req",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
					        location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
    })
</script>