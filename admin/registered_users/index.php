<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Registered Users</h3>
        <div class="card-tools">
            <a href="?page=users/manage_user" class="btn btn-flat btn-primary">
                <span class="fas fa-plus"></span> Add New User
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="25%">
                    <col width="10%">
                    <col width="5%">
                    <col width="5%">
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
                        // Query to fetch data from the registered_users table
                        $qry = $conn->query("SELECT * FROM `registered_users` ORDER BY `date_created` ASC");
                        
                        // Loop through the rows fetched from the database
                        while ($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_no']); ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'active'): ?>
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
                                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['user_id']; ?>">
                                        <span class="fa fa-edit text-primary"></span> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['user_id']; ?>">
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
    $(document).ready(function() {
        // Bind delete button action
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this user permanently?", "delete_user", [$(this).attr('data-id')]);
        });

        // Bind edit button action
        $('.edit_data').click(function() {
            uni_modal("Edit User Details", "users/manage_user.php?id=" + $(this).attr('data-id'), 'mid-large');
        });

        // DataTable Initialization
        $('.table').dataTable();
    });

    // Delete user function
    function delete_user(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_user",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: function(err) {
                console.error(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
