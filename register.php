<?php  
  require 'config/koneksi_db.php';
  session_start();

  if (isset($_SESSION['masuk'])) {
    header('Location: login.php');
    exit;
  }

  if (isset($_POST['register'])) {
    $username = htmlspecialchars(stripcslashes($_POST['user']));

    $cekUser = "SELECT username FROM data_user WHERE username = '$username'";
    $hasilUser = mysqli_query($koneksi, $cekUser);

    if (mysqli_fetch_assoc($hasilUser)) {
      echo "<script>
              alert('Username Telah Terpakai');
              document.location.href = 'register.php';
           </script>";
      return false;
    } 
    
    // konfirmasi password
    $password = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['password']));
    $confirmPass = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['confirm']));

    if ($password !== $confirmPass) {
      echo "<script>
              alert('Mohon Cek Kembali Password Anda');
              document.location.href = 'register.php';
           </script>";
      return false;
    }

    // Masuk ke database
    $sql = "INSERT INTO data_user VALUES ('', '$username','$password')";
    mysqli_query($koneksi, $sql);

    echo "<script>
              alert('Register Berhasil');
              document.location.href = 'login.php';
           </script>";
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPK Menu Terlaris RM. Berdikari | Mendaftar</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

  <style>
     .btn-primary {
        background-color: #0c2461;
        border-color: #0c2461;
      }

      .btn-primary:hover {
        background-color: green;
        border-color: green;
      } 

      a {
        color: #0c2461;
      }
      
      .register-card-body {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
      }

      .register-box {
        width: 800px;
      }

      .register-image {
        max-width: 400px;
        height: 400px;
      }

      .register-form {
        flex: 1;
        padding: 20px;
      }

      .register-img {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f4f6f9;
      }

      .card {
        background-color: #333; 
      }

      .input-group-text {
        background-color: #555; 
        border-color: #555;
      }

      .form-control {
        background-color: #444;
        border-color: #444; 
        color: #fff; 
      }
  </style>
</head>
<body class="hold-transition register-page" style="background-color:#0c2461 ">
<div class="register-box">
  <div class="register-logo">
    <a href="register.php"  style="color : #fff;">SISTEM PEDUKUNG KEPUTUSAN - MENENTUKAN MENU TERLARIS DI RM. BERDIKARI - METODE SAW</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <div class="register-img">
        <img src="img\berdikari.jpg" class="register-image">
      </div>
      <div class="register-form">
        <p class="login-box-msg">Daftar Pengguna Baru</p>

        <form method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="user" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-4">
            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block" name="register"><i class="fas fa-sign-in-alt"></i> Register</button>
            </div>
          </div>
        </form>

        <a href="login.php" class="text-center">Sudah Mendaftar Akun</a>
      </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
