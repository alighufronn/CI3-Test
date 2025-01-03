<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/adminlte.min.css')?>">
  <script src="<?= base_url('assets/AdminLTE/plugins/jquery/jquery.min.js') ?>"></script>


</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= base_url('assets/AdminLTE/index2.html')?>"><b>User</b> Sign-In</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="loginForm" action="<?= site_url('login/login_process') ?>" method="post">
        <input type="hidden" name="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" id="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<script>
  $(document).ready(function() {

    if (localStorage.getItem('username') && localStorage.getItem('password')) {
      $('#username').val(localStorage.getItem('username'));
      $('#password').val(localStorage.getItem('password'));
      $('#remember').prop('checked', true);
    }

    $('#remember').on('change', function() {
      if ($(this).is(':checked')) {
        // Add
        localStorage.setItem('username', $('#username').val());
        localStorage.setItem('password', $('#password').val());
      } else {
        // Remove
        localStorage.removeItem('username');
        localStorage.removeItem('password');
      }
    });

    $('#loginForm').on('submit', function() {
      if ($('#remember').is(':checked')) {
        localStorage.setItem('username', $('#username').val());
        localStorage.setItem('password', $('#password').val());
      }
    });


    
  })
</script>

<!-- jQuery -->
<script src="<?= base_url('assets/AdminLTE/plugins/jquery/jquery.min.js')?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/AdminLTE/dist/js/adminlte.min.js')?>"></script>
</body>
</html>