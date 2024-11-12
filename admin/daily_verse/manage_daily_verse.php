<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `daily_verses` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<style>
	img#cimg{
		height: 20vh;
		width: 15vw;
		object-fit: cover;
		object-position: center top;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Daily Verse</h3>
	</div>
	<div class="card-body">
		<form action="" id="daily_verse-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
				<label for="display_date" class="control-label">Display Date</label>
                <input type="date" class="form-control form" required name="display_date" value="<?php echo isset($display_date) ? $display_date : '' ?>">
            </div>
			<div class="form-group">
				<label for="verse" class="control-label">Verse</label>
                <textarea rows="2" class="form-control form" required name="verse"><?php echo isset($verse) ? stripslashes($verse) : '' ?></textarea>
            </div>
			<div class="form-group">
				<label for="verse_from" class="control-label">From</label>
                <input type="text" class="form-control form" required name="verse_from" value="<?php echo isset($verse_from) ? $verse_from : '' ?>">
            </div>
			<div class="form-group">
				<label for="" class="control-label">Background Image</label>
				<div class="custom-file">
					<input type="hidden" name="cur_img" value="<?php echo isset($image_path) ? $image_path : '' ?>">
	              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
	              <label class="custom-file-label" for="customFile">Choose file</label>
	            </div>
			</div>
			<div class="form-group d-flex justify-content-center">
				<img align="center" src="<?php echo validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="daily_verse-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=daily_verse">Cancel</a>
	</div>
</div>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		$('#daily_verse-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_daily_verse",
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
						location.href = "./?page=daily_verse";
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