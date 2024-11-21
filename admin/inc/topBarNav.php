<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
</style>
<!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-blue border border-light border-top-0  border-left-0 border-right-0 navbar-light text-sm">
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
          <!-- Navbar Search -->
          <!-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li> -->

        <!-- Add this to your existing navbar, after the user dropdown -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <?php
        // Fetch pending requests from different schedule tables
        $total_pending = 0;
        
        // Burial Schedules Pending
        $burial_pending = $conn->query("SELECT COUNT(*) as count FROM burial_schedules WHERE status = 0")->fetch_assoc()['count'];
        
        // Baptism Schedules Pending
        $baptism_pending = $conn->query("SELECT COUNT(*) as count FROM baptism_schedules WHERE status = 0")->fetch_assoc()['count'];
        
        // Wedding Schedules Pending
        $wedding_pending = $conn->query("SELECT COUNT(*) as count FROM wedding_schedules WHERE status = 0")->fetch_assoc()['count'];
        
        $total_pending = $burial_pending + $baptism_pending + $wedding_pending;
        
        // Only show badge if there are pending requests
        if ($total_pending > 0) {
            echo '<span class="badge badge-warning navbar-badge">' . $total_pending . '</span>';
        }
        ?>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">Pending Requests</span>
        <div class="dropdown-divider"></div>
        <a href="?page=burial_schedules" class="dropdown-item">
            <i class="fas fa-grave mr-2"></i> Burial Requests 
            <span class="float-right badge badge-warning"><?php echo $burial_pending; ?></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="?page=baptism_schedules" class="dropdown-item">
            <i class="fas fa-church mr-2"></i> Baptism Requests 
            <span class="float-right badge badge-warning"><?php echo $baptism_pending; ?></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="?page=wedding_schedules" class="dropdown-item">
            <i class="fas fa-ring mr-2"></i> Wedding Requests 
            <span class="float-right badge badge-warning"><?php echo $wedding_pending; ?></span>
        </a>
    </div>
</li>

          <!-- Messages Dropdown Menu -->
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
          <li class="nav-item">
            
          </li>
         <!--  <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.navbar -->