<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Baptism Request</h3>
		<div class="card-tools">
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="3%">
					<col width="10%">
					<col width="10%">
					<col width="25%">
					<col width="30%">
					<col width="30%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Schedule</th>
						<th>Child's Fullname</th>
						<th>Birthplace</th>
						<th>Father's Name</th>
						<th>Mother's Name</th>
						<th>Address</th>
						<th>Date of Baptism</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT r.*, t.sched_type from `baptism_schedule` r inner join `schedule_type` t on r.sched_type_id = t.id order by FIELD(r.status,0, 1, 2) asc, unix_timestamp(r.`date_created`) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['sched_type'] ?></td>
							<td><?php echo $row['child_fullname'] ?></td>
							<td><?php echo $row['birthplace'] ?></td>
							<td><?php echo $row['father'] ?></td>
							<td><?php echo $row['mother'] ?></td>
							<td>
								<small class="truncate" title="<?php echo $row['address'] ?>"><?php echo $row['address'] ?></small>
							</td>
							<td>
								<?php echo date("M d,Y",strtotime($row['date_of_baptism'])) ?>
								
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
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Update</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Baptism Request permanently?","delete_baptism_request",[$(this).attr('data-id')])
		})
		$('.edit_data').click(function(){
			uni_modal("Manage Baptism Request","baptism/manage_baptism.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table th, .table td').addClass("py-1 px-1 align-middle");
		$('.table').dataTable();
	})
	function delete_baptism_request($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_baptism_request",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>