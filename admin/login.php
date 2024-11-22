<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php'); ?>
<style>
  body {
    background-color: #343a40; /* Fallback color */
    background: linear-gradient(45deg, #343a40, #007bff, #343a40, #007bff);
    background-size: 400% 400%;
    animation: gradientAnimation 15s ease infinite; /* Apply the animation */
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
    animation: loginBoxAnimation 2s ease-out; /* Apply the animation */
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
    border-radius: 15px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for a better look */
  }

  .card-header {
    background-color: #007bff; /* Primary color background */
    color: white; /* White text color */
    border-top-left-radius: 15px; /* Rounded corners for the header */
    border-top-right-radius: 15px; /* Rounded corners for the header */
  }

  .btn-primary {
    background-color: #007bff; /* Primary button color */
    border-color: #007bff; /* Primary button border color */
  }

  .form-control {
    border-radius: 5px; /* Slightly rounded input fields */
  }

  .input-group-text {
    background-color: #007bff; /* Primary color for input group text */
    border-color: #007bff; /* Primary color for input group border */
    color: white; /* White color for icons */
  }

  a {
    color: #007bff; /* Primary color for links */
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

  /* Responsive Design: Ensures the login box fits well on small screens */
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
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="./" class="h1"><b>Login</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form id="login-frm" action="login_action.php" method="post"> <!-- Action added for form submission -->
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus> <!-- Added autofocus for user experience -->
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required> <!-- Required attribute for better validation -->
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
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.social-auth-links -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    function start_loader() {
    console.log('Loader started');
    // Add your loader logic here
}

function end_loader() {
    console.log('Loader ended');
    // Add your loader hiding/removal logic here
}
  </script>
</body>
</html>
