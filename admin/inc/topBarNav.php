<?php
// Function to get all notifications
function getNotifications() {
    $host = "127.0.0.1";
    $username = "u510162695_church_db";
    $password = "1Church_db";
    $dbname = "u510162695_church_db";
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get appointment (death) notifications with status = 0
        $deathStmt = $conn->prepare("SELECT id, death_person_fullname, date_created, 'death' as type 
                                    FROM appointment_schedules 
                                    WHERE sched_type_id = 1 
                                    AND status = 0 
                                    ORDER BY id DESC");
        $deathStmt->execute();
        $deaths = $deathStmt->fetchAll(PDO::FETCH_ASSOC);

        // Get baptism notifications with status = 0
        $baptismStmt = $conn->prepare("SELECT id, child_fullname, date_created, 'baptism' as type 
                                      FROM baptism_schedule 
                                      WHERE sched_type_id = 2 
                                      AND status = 0 
                                      ORDER BY id DESC");
        $baptismStmt->execute();
        $baptisms = $baptismStmt->fetchAll(PDO::FETCH_ASSOC);

        // Get wedding notifications with status = 0
        $weddingStmt = $conn->prepare("SELECT id, husband_fname, husband_lname, wife_fname, wife_lname, date_created, 'wedding' as type 
                                      FROM wedding_schedules 
                                      WHERE sched_type_id = 3 
                                      AND status = 0 
                                      ORDER BY id DESC");
        $weddingStmt->execute();
        $weddings = $weddingStmt->fetchAll(PDO::FETCH_ASSOC);

        // Combine and sort notifications
        $notifications = array_merge($deaths, $baptisms, $weddings);
        usort($notifications, function($a, $b) {
            return $b['id'] - $a['id'];
        });

        return $notifications;
    } catch(PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return [];
    }
}

$notifications = getNotifications();
$notificationCount = count($notifications);

// Provide an identifier for notifications
$lastNotificationId = !empty($notifications) ? $notifications[0]['id'] : 0;
?>

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
  .notification-text {
    white-space: normal;
    line-height: 1.2;
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-blue border border-light border-top-0 border-left-0 border-right-0 navbar-light text-sm">
  <ul class="navbar-nav ml-auto">
    <!-- Notification Bell -->
    <li class="nav-item dropdown">
      <a class="nav-link notification-bell" data-toggle="dropdown" aria-expanded="false" id="notification-bell">
        <i class="fas fa-bell"></i>
        <span class="badge" id="notification-count"><?php echo $notificationCount; ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-menu-notifications">
        <span class="dropdown-item dropdown-header">Pending Requests (<?php echo $notificationCount; ?>)</span>
        <div id="notification-list">
          <?php if ($notificationCount > 0): ?>
            <?php foreach($notifications as $notification): ?>
              <?php if ($notification['type'] === 'death'): ?>
                <a href="<?php echo base_url.'admin/?page=appointment'; ?>" class="dropdown-item">
                  <div class="text-sm notification-text">
                    <i class="fas fa-pray mr-2"></i>
                    New death certificate request for <?php echo htmlspecialchars($notification['death_person_fullname']); ?>
                    <small class="text-muted d-block"><?php echo $notification['date_created']; ?></small>
                  </div>
                </a>
              <?php elseif ($notification['type'] === 'baptism'): ?>
                <a href="<?php echo base_url.'admin/?page=baptism'?>" class="dropdown-item">
                  <div class="text-sm notification-text">
                    <i class="fas fa-cross mr-2"></i>
                    <?php echo htmlspecialchars($notification['child_fullname']); ?> is added in the pending baptism request
                    <small class="text-muted d-block"><?php echo $notification['date_created']; ?></small>
                  </div>
                </a>
              <?php else: ?>
                <a href="<?php echo base_url.'admin/?page=wedding' ?>" class="dropdown-item">
                  <div class="text-sm notification-text">
                    <i class="fas fa-heart mr-2"></i>
                    New wedding schedule request for 
                    <?php 
                      echo htmlspecialchars($notification['husband_fname'].' '.$notification['husband_lname']);
                      echo " & ";
                      echo htmlspecialchars($notification['wife_fname'].' '.$notification['wife_lname']);
                    ?>
                    <small class="text-muted d-block"><?php echo $notification['date_created']; ?></small>
                  </div>
                </a>
              <?php endif; ?>
              <div class="dropdown-divider"></div>
            <?php endforeach; ?>
          <?php else: ?>
            <a href="#" class="dropdown-item">
              <div class="text-sm">No pending requests</div>
            </a>
            <div class="dropdown-divider"></div>
          <?php endif; ?>
        </div>
        <a href="<?php echo base_url.'admin/?page=requests' ?>" class="dropdown-item dropdown-footer">View All Requests</a>
      </div>
    </li>

      <!-- User Profile Dropdown remains unchanged -->
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
  document.addEventListener("DOMContentLoaded", function () {
      const badge = document.getElementById("notification-count");
      const lastNotificationId = "<?php echo $lastNotificationId; ?>";
      const savedLastNotificationId = localStorage.getItem("lastNotificationId");
      const notifications = <?php echo json_encode($notifications); ?>;
      const currentDate = new Date();
      let newNotificationCount = 0;

      // Check each notification date_created against last viewed time
      notifications.forEach(notification => {
          const notificationDate = new Date(notification.date_created);
          if (!savedLastNotificationId || notificationDate > new Date(savedLastNotificationId)) {
              newNotificationCount++;
          }
      });

      // Update badge count and visibility
      if (newNotificationCount > 0) {
          badge.textContent = newNotificationCount;
          badge.style.display = "inline-block";
      } else {
          badge.style.display = "none";
      }

      // Hide badge on dropdown click and update last viewed time
      document.getElementById("notification-bell").addEventListener("click", function () {
          badge.style.display = "none";
          localStorage.setItem("lastNotificationId", currentDate.toISOString());
      });
  });
</script>
