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
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-blue border border-light border-top-0 border-left-0 border-right-0 navbar-light text-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url ?>" class="nav-link">
        <?php echo (!isMobileDevice()) ? $_settings->info('name') : $_settings->info('short_name'); ?> - Admin
      </a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notification Bell -->
    <li class="nav-item dropdown">
      <a class="nav-link" href="#" id="notificationBell" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span id="notificationCount" class="badge badge-danger navbar-badge"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" id="notificationMenu">
        <span class="dropdown-item dropdown-header">Pending Requests</span>
        <div id="notificationItems" class="dropdown-item text-wrap">
          <!-- Dynamic Items will be added here -->
        </div>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item text-center text-primary" id="viewAllRequests">View All</a>
      </div>
    </li>
    <!-- User Profile -->
    <li class="nav-item">
      <div class="btn-group nav-link">
        <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
          <span>
            <img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image">
          </span>
          <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>">
            <span class="fa fa-user"></span> My Account
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>">
            <span class="fas fa-sign-out-alt"></span> Logout
          </a>
        </div>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Fetch pending requests
    fetchPendingRequests();

    // Redirect to specific location on click
    document.getElementById('notificationItems').addEventListener('click', function (event) {
      if (event.target && event.target.dataset.href) {
        window.location.href = event.target.dataset.href;
      }
    });

    // Function to fetch and render pending requests
    function fetchPendingRequests() {
      fetch('<?php echo base_url ?>/api/pending_requests.php')
        .then(response => response.json())
        .then(data => {
          const notificationCount = document.getElementById('notificationCount');
          const notificationItems = document.getElementById('notificationItems');
          let count = 0;

          // Clear existing notifications
          notificationItems.innerHTML = '';

          // Render notifications
          ['burial', 'baptism', 'wedding'].forEach(type => {
            if (data[type] && data[type].length > 0) {
              count += data[type].length;
              data[type].forEach(request => {
                const item = document.createElement('div');
                item.className = 'dropdown-item';
                item.innerHTML = `<b>${type.charAt(0).toUpperCase() + type.slice(1)}</b>: ${request.name}`;
                item.dataset.href = request.url;
                notificationItems.appendChild(item);
              });
            }
          });

          // Update notification count
          notificationCount.textContent = count > 0 ? count : '';
        })
        .catch(error => console.error('Error fetching pending requests:', error));
    }
  });
</script>
