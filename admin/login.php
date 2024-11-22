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
</style><style>
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
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="./" class="h1"><b>Login</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form id="login-frm" action="" method="post">
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
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
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
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = $_POST['username'];
      $password = $_POST['password'];

      // Use prepared statements to prevent SQL injection
      $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
      $stmt->bind_param("ss", $username, md5($password));
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          // Successful login
          session_start();
          $_SESSION['user'] = $username;
          echo "window.location.href = 'dashboard.php';";
      } else {
          // Failed login
          echo "alert('Invalid username or password');";
      }
  }
  ?>
  </script>
</body>
</html>