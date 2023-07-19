<?php
// error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dateTaken'])) {
  $dateTaken = $_POST['dateTaken'];

  $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
            tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
            tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
            FROM tblattendance
            INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
            INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
            INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
            INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
            INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
            WHERE tblattendance.dateTimeTaken = ? AND tblattendance.classId = ? AND tblattendance.classArmId = ?";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("sss", $dateTaken, $_SESSION['classId'], $_SESSION['classArmId']);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result) {
    // Fetch and process the attendance data
    $attendanceData = [];
    while ($row = $result->fetch_assoc()) {
      $status = ($row['status'] == '1') ? "Present" : "Absent";
      $row['status'] = $status;
      $attendanceData[] = $row;
    }

    echo json_encode($attendanceData);
    exit;
  } else {
    echo "Error retrieving attendance data: " . $conn->error;
    exit;
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
  <title>View Class Attendance</title>
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

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
                  <h1 class="h5 mb-0 text-primary">View Class Attendance</h1>
                </div>
                <div class="card-body">
                  <form id="attendanceForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label for="dateInput">Select Date:</label>
                        <input type="date" class="form-control" name="dateTaken" id="dateInput" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-2">
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#attendanceModal"
                          id="viewAttendanceBtn" disabled>
                          View Attendance
                        </button>
                      </div>
                      <div class="col-xl-2">
                        <a href="downloadRecord.php" class="btn btn-primary" target="_blank" id="downloadBtn" disabled>
                          Download Attendance
                        </a>
                      </div>
                    </div>
                  </form>
                </div>

                <!-- Input Group -->
                <div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog"
                  aria-labelledby="attendanceModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-navbar">
                        <h5 class="modal-title text-primary" id="attendanceModalLabel">Class Attendance</h5>
                        <button type="button" class="close text-primary" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Middle Name</th>
                              <th>Admission No</th>
                              <th>Class</th>
                              <th>Class Arm</th>
                              <th>Session</th>
                              <th>Term</th>
                              <th>Status</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody id="attendanceTableBody">
                            <!-- Attendance data will be dynamically inserted here -->
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
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include "Includes/footer.php"; ?>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Modal Script -->
  <script>
    $(document).ready(function () {
      $('#attendanceForm').submit(function (event) {
        event.preventDefault();
        var dateTaken = $('#dateInput').val();

        if (dateTaken !== '') {
          $.ajax({
            type: 'POST',
            url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
            data: {
              dateTaken: dateTaken
            },
            success: function (response) {
              var attendanceData = JSON.parse(response);
              var tableBody = $('#attendanceTableBody');
              tableBody.empty();

              if (attendanceData.length > 0) {
                var rows = '';
                $.each(attendanceData, function (index, data) {
                  var statusColor = data.status === 'Present' ? 'green' : 'red';

                  rows += `
                <tr>
                  <td>${index + 1}</td>
                  <td>${data.firstName}</td>
                  <td>${data.lastName}</td>
                  <td>${data.otherName}</td>
                  <td>${data.admissionNumber}</td>
                  <td>${data.className}</td>
                  <td>${data.classArmName}</td>
                  <td>${data.sessionName}</td>
                  <td>${data.termName}</td>
                  <td style="color: ${statusColor}">${data.status}</td>
                  <td>${data.dateTimeTaken}</td>
                </tr>
              `;
                });
                tableBody.html(rows);
                $('#attendanceTable').DataTable().destroy();
                $('#attendanceTable').DataTable({
                  "lengthMenu": [10, 25, 50, 75, 100],
                  "pageLength": 10,
                  "searching": true
                });
                $('#attendanceModal').modal('show');
              } else {
                var noDataMessage = $('<tr>').append($('<td colspan="11">').text('No attendance data found.'));
                tableBody.append(noDataMessage);
              }
            },
            error: function () {
              console.log('Error retrieving attendance data.');
            }
          });
        } else {
          $('#attendanceTableBody').empty();
          $('#attendanceModal').modal('hide');
        }
      });
    });
  </script>

  <!-- Download -->
  <script>
    document.getElementById('downloadBtn').addEventListener('click', function (event) {
      event.preventDefault();

      var dateTaken = document.getElementById('dateInput').value;
      var downloadLink = "downloadRecord.php?dateTaken=" + encodeURIComponent(dateTaken);
      window.open(downloadLink, '_blank');
    });
  </script>

  <!-- Buttons -->
  <script>
    // Enable or disable buttons based on the input date
    document.getElementById('dateInput').addEventListener('input', function () {
      var dateInputValue = this.value;
      var viewAttendanceBtn = document.getElementById('viewAttendanceBtn');
      var downloadBtn = document.getElementById('downloadBtn');

      if (dateInputValue.trim() !== '') {
        viewAttendanceBtn.removeAttribute('disabled');
        downloadBtn.removeAttribute('disabled');
      } else {
        viewAttendanceBtn.setAttribute('disabled', 'disabled');
        downloadBtn.setAttribute('disabled', 'disabled');
      }
    });
  </script>
</body>

</html>