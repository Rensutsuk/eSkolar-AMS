<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';



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
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
                  <h1 class="h5 mb-0 text-primary">View Class Attendance</h1>
                  <?php echo $statusMsg; ?>
                </div>
                <!-- Form Input -->
                <div class="card-body">
                  <form id="AttendanceForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Date<span class="text-danger ml-2">*</span></label>
                        <input type="date" class="form-control" name="dateTaken" id="exampleInputFirstName"
                          placeholder="Class Arm Name">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#classAttendance">
                      View Attendance
                    </button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
              <div class="modal fade" id="classAttendance" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-navbar">
                      <h5 class="modal-title text-primary">Class Attendance</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php
                      if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $dateTaken = $_POST['dateTaken'];

                        $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblclass.className,
                          tblclassarms.classArmName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                          tblstudents.firstName,tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber
                          FROM tblattendance
                          INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                          INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                          INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                          INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                          INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                          WHERE tblattendance.dateTimeTaken = '$dateTaken' AND tblattendance.classId = '$_SESSION[classId]' AND tblattendance.classArmId = '$_SESSION[classArmId]'";

                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn = 0;
                        $status = "";
                        if ($num > 0) {
                          echo '<div class="table-responsive p-3">';
                          echo '<table class="table align-items-center table-flush table-hover" id="dataTableHover">';
                          echo '<thead class="thead-light">';
                          echo '<tr>';
                          echo '<th>#</th>';
                          echo '<th>First Name</th>';
                          echo '<th>Last Name</th>';
                          echo '<th>Other Name</th>';
                          echo '<th>Admission No</th>';
                          echo '<th>Class</th>';
                          echo '<th>Class Arm</th>';
                          echo '<th>Session</th>';
                          echo '<th>Term</th>';
                          echo '<th>Status</th>';
                          echo '<th>Date</th>';
                          echo '</tr>';
                          echo '</thead>';
                          echo '<tbody>';

                          while ($rows = $rs->fetch_assoc()) {
                            if ($rows['status'] == '1') {
                              $status = "Present";
                              $colour = "#00FF00";
                            } else {
                              $status = "Absent";
                              $colour = "#FF0000";
                            }
                            $sn = $sn + 1;
                            echo '<tr>';
                            echo '<td>' . $sn . '</td>';
                            echo '<td>' . $rows['firstName'] . '</td>';
                            echo '<td>' . $rows['lastName'] . '</td>';
                            echo '<td>' . $rows['otherName'] . '</td>';
                            echo '<td>' . $rows['admissionNumber'] . '</td>';
                            echo '<td>' . $rows['className'] . '</td>';
                            echo '<td>' . $rows['classArmName'] . '</td>';
                            echo '<td>' . $rows['sessionName'] . '</td>';
                            echo '<td>' . $rows['termName'] . '</td>';
                            echo '<td style="background-color:' . $colour . '">' . $status . '</td>';
                            echo '<td>' . $rows['dateTimeTaken'] . '</td>';
                            echo '</tr>';
                          }

                          echo '</tbody>';
                          echo '</table>';
                          echo '</div>';
                        } else {
                          echo '<div class="alert alert-danger" role="alert">';
                          echo 'No Record Found!';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
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
  <!-- Footer -->

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
  <!-- Intercept default form behaviour -->
  <script>
    document.getElementById("AttendanceForm").addEventListener("submit", function (event) {
      event.preventDefault();
      $('#classAttendance').modal('show');
    });
  </script>
</body>

</html>