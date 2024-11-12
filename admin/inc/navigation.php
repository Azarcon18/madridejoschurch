<style>
/* Add touch effect with linear gradient and clip-path */
.nav-sidebar .nav-link {
  position: relative;
  overflow: hidden;
  padding: 10px 20px; /* Ensure there's enough space for the effect */
  text-decoration: none;
  color: inherit;
  display: inline-block; /* Ensure it behaves like a block element inline */
  transition: color 0.6s;
}

.nav-sidebar .nav-link::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0) 90%);
  clip-path: polygon(30% 0, 70% 0, 100% 100%, 0% 100%);
  transform: translate(-50%, -50%) rotate(45deg); /* Adding rotation for a dynamic effect */
  transition: width 0.6s ease-in-out, height 0.6s ease-in-out, transform 0.6s ease-in-out; /* Adding transition for transform */
  pointer-events: none; /* Ensures the pseudo-element does not interfere with hover */
}

.nav-sidebar .nav-link:hover::after,
.nav-sidebar .nav-link:focus::after {
  width: 200%;
  height: 500%;
  transform: translate(-50%, -50%) rotate(45deg) scale(1.2); /* Scale up for a more pronounced effect */
}

.nav-sidebar .nav-link:hover,
.nav-sidebar .nav-link:focus {
  color: white; /* Change text color on hover/focus */
}

/* Optional: Adding keyframes for an initial subtle animation */
@keyframes initialEffect {
  0% {
    transform: translate(-50%, -50%) rotate(45deg) scale(0);
  }
  100% {
    transform: translate(-50%, -50%) rotate(45deg) scale(1);
  }
}

.nav-sidebar .nav-link::after {
  animation: initialEffect 1s ease-in-out;
}

/* Enhancing icons with hover effects */
.nav-sidebar .nav-icon {
  transition: transform 0.3s ease, color 0.3s ease;
}

.nav-sidebar .nav-link:hover .nav-icon,
.nav-sidebar .nav-link:focus .nav-icon {
  transform: scale(1.2) rotate(20deg); /* Adding scale and rotation effect */
  color: #007bff; /* Change icon color on hover/focus */
}

/* Specific enhancement for different icons */
.nav-sidebar .nav-link.nav-home .nav-icon {
  transition: transform 0.3s ease, color 0.3s ease;
}

.nav-sidebar .nav-link.nav-home:hover .nav-icon,
.nav-sidebar .nav-link.nav-home:focus .nav-icon {
  transform: scale(1.3) rotate(360deg); /* Full rotation for home icon */
  color: #28a745; /* Different color for home icon */
}



</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4 sidebar-no-expand bs-primary-rgb">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
    <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="width: 1.8rem;height: 1.8rem;max-height: unset">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=daily_verse" class="nav-link nav-daily_verse">
                  <i class="nav-icon fas fa-quote-left"></i>
                  <p>Daily Verses</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=blogs" class="nav-link nav-blogs">
                  <i class="nav-icon fas fa-blog"></i>
                  <p>Blog List</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=events" class="nav-link nav-events">
                  <i class="nav-icon fas fa-calendar-day"></i>
                  <p>Event List</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=appointment" class="nav-link nav-appointment">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Appointment Requests</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=baptism" class="nav-link nav-baptism">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Baptism Requests</p>   
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=wedding" class="nav-link nav-wedding">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Wedding Requests</p>   
                </a>
              </li>
              </li>
             <li class="nav-item dropdown">
             <a href="<?php echo base_url ?>admin/?page=registered_users" class="nav-link nav-registered_users">
             <i class="nav-icon fas fa-user-plus"></i>
              <p>Registered Users</p>
              </a>
              <li class="nav-item dropdown">
              <a href="<?php echo base_url ?>admin/?page=donate" class="nav-link nav-donation">
              <i class="nav-icon fas fa-hand-holding-heart"></i>
              <p>Donation</p>
             </a>
              </li>

              <li class="nav-header">Maintenance</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=maintenance/topics" class="nav-link nav-topics">
                  <i class="nav-icon fas fa-th-list"></i>
                  <p>Topic List</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=maintenance/sched_type" class="nav-link nav-sched_type">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Schedule Type List</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user/list">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Staff List</p>
                </a>

              </li>
              <li class="nav-item dropdown ">
    <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Reports</p>
    </a>
</li>
</li>
</li>
              <li class="nav-item dropdown ">
    <a href="<?php echo base_url ?>admin/?page=Certificate/sched_type" class="nav-link nav-sched_type">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Certificate</p>
    </a>
</li>
</li>


              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>Settings</p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
  </div>
  <!-- /.sidebar -->
</aside>

<script>
$(document).ready(function(){
  var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
  page = page.split('/');
  page = page[0];
  if(s != '')
    page = page + '_' + s;

  if($('.nav-link.nav-' + page).length > 0){
    $('.nav-link.nav-' + page).addClass('active');
    if($('.nav-link.nav-' + page).hasClass('tree-item') == true){
      $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
      $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
    }
    if($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true){
      $('.nav-link.nav-' + page).parent().addClass('menu-open');
    }
  }
});
</script>
