<?php
// Your database connection setup
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['save'])) {
    // Code for creating a new student
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $otherName = $_POST['otherName'];
    $admissionNumber = $_POST['admissionNumber'];
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "select * from tblstudents where admissionNumber ='$admissionNumber'");
    $ret = mysqli_fetch_array($query);

    if ($ret > 0) {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
    } else {
      $query = mysqli_query($conn, "insert into tblstudents(firstName,lastName,otherName,admissionNumber,password,classId,classArmId,dateCreated) 
      value('$firstName','$lastName','$otherName','$admissionNumber','12345','$classId','$classArmId','$dateCreated')");

      if ($query) {
        $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
      } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
      }
    }

  } elseif (isset($_POST['update'])) {
    // Code for updating a student
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $otherName = $_POST['otherName'];
    $admissionNumber = $_POST['admissionNumber'];
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $dateCreated = date("Y-m-d");
    $Id = $_POST['studentId'];

    $query = mysqli_query($conn, "update tblstudents set firstName='$firstName', lastName='$lastName',
    otherName='$otherName', admissionNumber='$admissionNumber',password='12345', classId='$classId',classArmId='$classArmId'
    where Id='$Id'");

    if ($query) {
      echo "<script type='text/javascript'>
              window.location = ('createStudents.php')
            </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  // Code for deleting a student
  $Id = $_GET['Id'];
  $classArmId = $_GET['classArmId'];

  $query = mysqli_query($conn, "DELETE FROM tblstudents WHERE Id='$Id'");

  if ($query == TRUE) {
    echo "<script type='text/javascript'>
            window.location = ('createStudents.php')
          </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>Create Students</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">



  <script>
    function classArmDropdown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxClassArms2.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
                  <h1 class="h5 mb-0 text-primary">Students</h1>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Other Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Class Arm</th>
                        <th>Date Created</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
                      tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber,tblstudents.dateCreated
                      FROM tblstudents
                      INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                      INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn = 0;
                      $status = "";
                      if ($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $sn = $sn + 1;
                          echo "
                              <tr>
                                <td>" . $sn . "</td>
                                <td>" . $rows['firstName'] . "</td>
                                <td>" . $rows['lastName'] . "</td>
                                <td>" . $rows['otherName'] . "</td>
                                <td>" . $rows['admissionNumber'] . "</td>
                                <td>" . $rows['className'] . "</td>
                                <td>" . $rows['classArmName'] . "</td>
                                 <td>" . $rows['dateCreated'] . "</td>
                                <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i></a></td>
                                <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i></a></td>
                              </tr>";
                        }
                      } else {
                        echo
                          "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }

                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include "Includes/footer.php"; ?>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>