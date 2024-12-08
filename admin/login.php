<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php'); ?>
<style>
  body {
    background-color: #343a40; /* Fallback color */
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
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="show-password">
            <label class="form-check-label" for="show-password">Show Password</label>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="<?php echo base_url; ?>">Go to Website</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function(){
      end_loader();
    });

    document.getElementById('show-password').addEventListener('change', function() {
      const passwordField = document.getElementById('password');
      if (this.checked) {
        passwordField.type = 'text';
      } else {
        passwordField.type = 'password';
      }
    });
  </script>
</body>
</html>
