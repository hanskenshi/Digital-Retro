<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Digital Retro | Login</title>
  <link rel="icon" href="images/logo.jpg">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Digital</b>Retro
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicio de sesion</p>
<?php
  if( isset($_REQUEST['login'])) {
    session_start();
    $email=$_REQUEST['email']??'';
    $password=$_REQUEST['pass']??'';
    $password=md5($password);
    include_once "bdecommerce.php";
    $con=mysqli_connect($host, $user, $pass, $db);
    $query="SELECT id, email, nombre from usuarios where email='".$email."' and pass='".$password."'; ";
    $res=mysqli_query($con, $query);
    $row=mysqli_fetch_assoc($res);
    if($row){
      $_SESSION['id'] =$row['id'];
      $_SESSION['email'] =$row['email'];
      $_SESSION['nombre'] =$row['nombre'];
      header("location: panel.php");

    }
    else{
 ?>
  <div class="alert alert-danger" role="alert">
  Error al inciar sesion <!--<img src="images/error.jpg" width="200"> -->
    </div>
 <?php
    }
  }
  ?>
      <form method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="login">inicio de sesion</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <!-- <p class="mb-1"> -->
        <!-- <a href="forgot-password.html">¿has olvidado la contraseña?</a> -->
      <!-- </p> -->
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
