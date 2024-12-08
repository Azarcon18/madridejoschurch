<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Wedding Requests</h3>
		<div class="card-tools">
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="3%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Schedule</th>
						<th>Husband's Fullname</th>
						<th>Wife's Fullname</th>
						<th>Places of Marriage</th>
						<th>Date & Time of Marriage</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT r.*, t.sched_type FROM `wedding_schedules` r 
										 INNER JOIN `schedule_type` t ON r.sched_type_id = t.id 
										 ORDER BY FIELD(r.status, 0, 1, 2) ASC, unix_timestamp(r.`date_created`) ASC");
					while($row = $qry->fetch_assoc()): ?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['sched_type'] ?></td>
							<td><?php echo $row['husband_fname'] . ' ' . $row['husband_mname'] . ' ' . $row['husband_lname'] ?></td>
							<td><?php echo $row['wife_fname'] . ' ' . $row['wife_mname'] . ' ' . $row['wife_lname'] ?></td>
							<td>
								<small class="truncate" title="<?php echo $row['place_of_marriage1'] . ', ' . $row['place_of_marriage2'] . ', ' . $row['place_of_marriage3'] ?>">
									<?php echo $row['place_of_marriage1'] . ', ' . $row['place_of_marriage2'] . ', ' . $row['place_of_marriage3'] ?>
								</small>
							</td>
							<td>
								<?php 
								echo date("M d, Y", strtotime($row['date_of_marriage'])) . ' at ' . date("h:i A", strtotime($row['time_of_marriage']));
								?>
							</td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">Confirmed</span>
								<?php elseif($row['status'] == 2): ?>
									<span class="badge badge-danger">Cancelled</span>
								<?php else: ?>
									<span class="badge badge-primary">Pending</span>
								<?php endif; ?>
							</td>
							<td align="center">
								<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-edit text-primary"></span>  Update
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-trash text-danger"></span> Delete
									</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Wedding Request permanently?","delete_wedding_request",[$(this).attr('data-id')])
		})
		$('.edit_data').click(function(){
			uni_modal("Manage Wedding Request","wedding/manage_wedding.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table th, .table td').addClass("py-1 px-1 align-middle");
		$('.table').dataTable();
	})

	function delete_wedding_request($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_wedding_request",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occurred.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occurred.",'error');
					end_loader();
				}
			}
		})
	}
</script>
