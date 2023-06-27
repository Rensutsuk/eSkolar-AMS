<?php
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>eSkolar - Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-login align-center">
  <div class="container-login d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-sm my-5 bg-login-form">
      <div class="card-body p-0">
        <div class="row justify-content-center align-items-center">
          <div class="col-md-8">
            <img src="img\PUP_thumbnail.png" class="img-fluid" alt="PUP">
          </div>
          <div class="col-6 col-md-4">
            <div class="login-form">
              <div class="text-center">
                <img src="img/logo/attnlg.jpg" style="width:60px;height:60px">
              </div>
              <h5 align="center" style="color: yellow;">eSkolar Attendance</h5>
              <form class="user" method="Post" action="">
                <div class="form-group">
                  <select required name="userType" class="form-control mb-3">
                    <option value="">--Select User Roles--</option>
                    <option value="Administrator">Administrator</option>
                    <option value="ClassTeacher">ClassTeacher</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" required name="username" id="exampleInputEmail"
                    placeholder="Enter Email Address">
                </div>
                <div class="form-group">
                  <input type="password" name="password" required class="form-control" id="exampleInputPassword"
                    placeholder="Enter Password">
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                </div>
              </form>

              <?php

              if (isset($_POST['login'])) {

                $userType = $_POST['userType'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $password = md5($password);

                if ($userType == "Administrator") {

                  $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
                  $rs = $conn->query($query);
                  $num = $rs->num_rows;
                  $rows = $rs->fetch_assoc();

                  if ($num > 0) {

                    $_SESSION['userId'] = $rows['Id'];
                    $_SESSION['firstName'] = $rows['firstName'];
                    $_SESSION['lastName'] = $rows['lastName'];
                    $_SESSION['emailAddress'] = $rows['emailAddress'];

                    echo "<script type = \"text/javascript\">
        window.location = (\"Admin/index.php\")
        </script>";
                  } else {

                    echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

                  }
                } else if ($userType == "ClassTeacher") {

                  $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
                  $rs = $conn->query($query);
                  $num = $rs->num_rows;
                  $rows = $rs->fetch_assoc();

                  if ($num > 0) {

                    $_SESSION['userId'] = $rows['Id'];
                    $_SESSION['firstName'] = $rows['firstName'];
                    $_SESSION['lastName'] = $rows['lastName'];
                    $_SESSION['emailAddress'] = $rows['emailAddress'];
                    $_SESSION['classId'] = $rows['classId'];
                    $_SESSION['classArmId'] = $rows['classArmId'];

                    echo "<script type = \"text/javascript\">
        window.location = (\"ClassTeacher/index.php\")
        </script>";
                  } else {

                    echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

                  }
                } else {

                  echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>