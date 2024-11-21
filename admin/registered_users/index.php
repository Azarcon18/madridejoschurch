<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Registered Users</h3>
        <div class="card-tools">
            <a href="?page=appointment/manage_appointment" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="10%">
                    <col width="25%">
                    <col width="30%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone #</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT * FROM `registered_users` ORDER BY unix_timestamp(`date_created`) ASC");
                    while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['user_name'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo $row['phone_no'] ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 'active'): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['user_id'] ?>">
                                        <span class="fa fa-edit text-primary"></span> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['user_id'] ?>">
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
        // Delete Button Event
        $(document).on('click', '.delete_data', function(){
            _conf("Are you sure to delete this user permanently?", "delete_user", [$(this).data('id')]);
        });

        // Edit Button Event
        $('.edit_data').click(function(){
            uni_modal("Manage User", "registered_users/manage_user.php?id=" + $(this).data('id'), 'mid-large');
        });

        $('.table th, .table td').addClass("py-1 px-1 align-middle");
        $('.table').dataTable();
    });

    function delete_user(id){
        start_loader(); // Show loader
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_user",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader(); // Hide loader
            },
            success: function(resp){
                if (resp && resp.status === 'success') {
                    alert_toast("User deleted successfully.", 'success');
                    setTimeout(() => location.reload(), 1500); // Reload after success
                } else {
                    alert_toast(resp.error || "An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
