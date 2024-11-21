<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }
  .btn-rounded {
    border-radius: 50px;
  }
  .notification-bell {
    position: relative;
    cursor: pointer;
  }
  .notification-bell .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: red;
    color: white;
    border-radius: 50%;
    padding: 3px 6px;
    font-size: 10px;
  }
  .dropdown-menu-notifications {
    max-height: 300px;
    overflow-y: auto;
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-blue border border-light border-top-0 border-left-0 border-right-0 navbar-light text-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url ?>" class="nav-link"><?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?> - Admin</a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notification Bell -->
    <li class="nav-item dropdown">
      <a class="nav-link notification-bell" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span class="badge" id="notification-count">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-menu-notifications">
        <span class="dropdown-item dropdown-header">Pending Requests</span>
        <div id="notification-list">
          <a href="#" class="dropdown-item">No pending requests</a>
        </div>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">View All</a>
      </div>
    </li>
    <!-- User Profile Dropdown -->
    <li class="nav-item">
      <div class="btn-group nav-link">
        <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
          <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span>
          <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
        </div>
      </div>
    </li>
  </ul>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Fetch the pending requests from the server
    fetch('./get_pending_requests.php')
      .then(response => response.json())
      .then(data => {
        const pendingRequests = [
          { type: 'Burial', location: './?page=appointment', count: data.burial },
          { type: 'Baptism', location: './?page=baptism', count: data.baptism },
          { type: 'Wedding', location: './?page=wedding', count: data.wedding },
        ];

        const notificationCountElem = document.getElementById('notification-count');
        const notificationListElem = document.getElementById('notification-list');

        // Calculate total pending requests
        const totalPending = pendingRequests.reduce((total, request) => total + request.count, 0);
        notificationCountElem.textContent = totalPending;

        // Populate the dropdown list
        notificationListElem.innerHTML = '';
        if (totalPending > 0) {
          pendingRequests.forEach(request => {
            if (request.count > 0) {
              const item = document.createElement('a');
              item.classList.add('dropdown-item');
              item.href = request.location;
              item.textContent = `${request.count} pending ${request.type} request(s)`;
              notificationListElem.appendChild(item);
            }
          });
        } else {
          const noRequestsItem = document.createElement('a');
          noRequestsItem.classList.add('dropdown-item');
          noRequestsItem.textContent = 'No pending requests';
          notificationListElem.appendChild(noRequestsItem);
        }
      })
      .catch(error => console.error('Error fetching pending requests:', error));
  });
</script>