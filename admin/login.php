<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php'); ?>
<style>
  body {
    background-color: #343a40;
    background: linear-gradient(45deg, #343a40, #007bff, #343a40, #007bff);
    background-size: 400% 400%;
    animation: gradientAnimation 15s ease infinite;
  }

  @keyframes gradientAnimation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .login-box {
    width: 100%;
    max-width: 360px;
    margin: 7% auto;
    animation: loginBoxAnimation 2s ease-out;
  }

  @keyframes loginBoxAnimation {
    0% {
      opacity: 0;
      transform: translateY(-50px) scale(0.8);
    }
    50% {
      opacity: 0.5;
      transform: translateY(0) scale(1.05);
    }
    100% {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .card {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .card-header {
    background-color: #007bff;
    color: white;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
  }

  .form-control {
    border-radius: 5px;
  }

  .input-group-text {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
  }

  a {
    color: #007bff;
  }

  .login-box-msg, .card-header .h1 {
    font-size: 1.2em;
    font-weight: bold;
    background: linear-gradient(45deg, #007bff, #343a40);
    -webkit-background-clip: text;
    color: transparent;
    animation: textAnimation 5s ease infinite;
  }

  @keyframes textAnimation {
    0%, 100% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
  }

  #attempt-message {
    color: red;
    font-weight: bold;
    margin-bottom: 10px;
  }

  @media (max-width: 480px) {
    .login-box {
      width: 100%;
      margin: 10% auto;
    }
  }
</style>
<body class="hold-transition login-page">
  <script>
    start_loader();
  </script>

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="./" class="h1"><b>Login</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        
        <div id="attempt-message"></div>

        <form id="login-frm" action="login_action.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="<?php echo base_url; ?>">Go to Website</a>
            </div>
            <div class="col-4">
              <button type="submit" id="login-btn" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function(){
      end_loader();
      
      // Login attempt management
      const MAX_ATTEMPTS = 3;
      const LOCKOUT_TIME = 3 * 60 * 1000; // 3 minutes in milliseconds
      
      // Function to check and update login attempts
      function checkLoginAttempts() {
        const attempts = parseInt(localStorage.getItem('loginAttempts') || '0');
        const lastAttemptTime = parseInt(localStorage.getItem('lastAttemptTime') || '0');
        const currentTime = new Date().getTime();

        // Check if lockout period has expired
        if (currentTime - lastAttemptTime > LOCKOUT_TIME) {
          // Reset attempts if lockout time has passed
          localStorage.removeItem('loginAttempts');
          localStorage.removeItem('lastAttemptTime');
          $('#login-btn').prop('disabled', false);
          $('#attempt-message').text('');
          return true;
        }

        // Check number of attempts
        if (attempts >= MAX_ATTEMPTS) {
          const remainingTime = Math.ceil((LOCKOUT_TIME - (currentTime - lastAttemptTime)) / 1000 / 60);
          $('#login-btn').prop('disabled', true);
          $('#attempt-message').text(`Too many failed attempts. Please try again in ${remainingTime} minutes.`);
          return false;
        }

        return true;
      }

      // On page load, check login attempts
      checkLoginAttempts();

      // Intercept form submission
      $('#login-frm').on('submit', function(e) {
        const currentTime = new Date().getTime();
        let attempts = parseInt(localStorage.getItem('loginAttempts') || '0');

        // If login attempts check fails, prevent submission
        if (!checkLoginAttempts()) {
          e.preventDefault();
          return;
        }

        // Increment attempts if not already locked out
        localStorage.setItem('loginAttempts', attempts + 1);
        localStorage.setItem('lastAttemptTime', currentTime);

        // You may want to add AJAX login validation here instead of direct form submission
        // This would allow more precise attempt tracking
      });
    });
  </script>
</body>
</html>