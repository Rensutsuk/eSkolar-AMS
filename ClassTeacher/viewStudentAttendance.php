<?php
// error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

function getStudentsInUserClass()
{
  global $conn;
  $classId = $_SESSION['classId'];
  $query = "SELECT * FROM tblstudents WHERE classId = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $classId);
  $stmt->execute();
  $result = $stmt->get_result();
  $students = [];
  while ($row = $result->fetch_assoc()) {
    $students[] = $row;
  }
  return $students;
}

// Function to fetch attendance data for a specific student and date range
function getStudentAttendanceData($studentId, $startDate = null, $endDate = null)
{
  global $conn;
  $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
            tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
            tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
            FROM tblattendance
            INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
            INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
            INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
            INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
            INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
            WHERE tblstudents.Id = ?";

  $parameters = array($studentId);

  if (!empty($startDate) && !empty($endDate)) {
    $query .= " AND tblattendance.dateTimeTaken BETWEEN ? AND ?";
    $parameters[] = $startDate;
    $parameters[] = $endDate;
  }

  $stmt = $conn->prepare($query);
  $stmt->bind_param(str_repeat('s', count($parameters)), ...$parameters);
  $stmt->execute();
  $result = $stmt->get_result();

  $attendanceData = [];
  while ($row = $result->fetch_assoc()) {
    $status = ($row['status'] == '1') ? "Present" : "Absent";
    $row['status'] = $status;
    $attendanceData[] = $row;
  }

  return $attendanceData;
}

// Check if form is submitted and handle the request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['viewAttendance'])) {
  $studentId = $_POST['student'];
  $startDate = null;
  $endDate = null;

  if ($_POST['dateRangeOption'] === 'range') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
  }

  $attendanceData = getStudentAttendanceData($studentId, $startDate, $endDate);
  echo json_encode($attendanceData);
  exit;
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
                  <h1 class="h5 mb-0 text-primary">View Student Attendance</h1>
                </div>
                <div class="card-body">
                  <form id="attendanceForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label for="studentSelect">Select Student:</label>
                        <select class="form-control" name="student" id="studentSelect" required>
                          <option value="" disabled selected>Select a student</option>
                          <?php
                          $students = getStudentsInUserClass(); // Fetch students within the class of the user/teacher
                          foreach ($students as $student) {
                            echo "<option value='{$student['Id']}'>{$student['firstName']} {$student['lastName']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label for="dateRangeOption">Date Range:</label>
                        <select class="form-control" name="dateRangeOption" id="dateRangeOption" required>
                          <option value="all">All Dates</option>
                          <option value="range">Specific Range</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row mb-3 dateRangeFields" style="display: none;">
                      <div class="col-xl-6">
                        <label for="startDate">Start Date:</label>
                        <input type="date" class="form-control" name="startDate" id="startDate">
                      </div>
                      <div class="col-xl-6">
                        <label for="endDate">End Date:</label>
                        <input type="date" class="form-control" name="endDate" id="endDate">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-2">
                        <button type="submit" class="btn btn-primary" id="viewAttendanceBtn">
                          View Attendance
                        </button>
                      </div>
                      <div class="col-xl-2">
                        <button type="button" class="btn btn-primary" id="downloadBtn">
                          Download Attendance
                        </button>
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
      // Show/hide date range fields based on selection
      $('#dateRangeOption').change(function () {
        var option = $(this).val();
        if (option === 'range') {
          $('.dateRangeFields').show();
        } else {
          $('.dateRangeFields').hide();
        }
      });

      $('#attendanceForm').submit(function (event) {
        event.preventDefault();
        var studentId = $('#studentSelect').val();
        var dateRangeOption = $('#dateRangeOption').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        $.ajax({
          type: 'POST',
          url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
          data: {
            viewAttendance: true,
            student: studentId,
            dateRangeOption: dateRangeOption,
            startDate: startDate,
            endDate: endDate
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
      });

      $('#downloadBtn').click(function () {
        var studentId = $('#studentSelect').val();
        var dateRangeOption = $('#dateRangeOption').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        
        $.ajax({
          type: 'POST',
          url: 'generateAttendanceExcel.php',
          data: {
            downloadAttendance: true,
            student: studentId,
            dateRangeOption: dateRangeOption,
            startDate: startDate,
            endDate: endDate
          },
          success: function (data) {
            var blob = new Blob([data], { type: 'application/vnd.ms-excel' });
            var downloadUrl = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = downloadUrl;
            a.download = 'Attendance_List_' + new Date().toISOString().slice(0, 19).replace(/:/g, "") + '.xls';
            document.body.appendChild(a);
            a.click();
            URL.revokeObjectURL(downloadUrl);
          },
          error: function () {
            console.log('Error downloading attendance record.');
          }
        });
      });
    });
  </script>
</body>

</html>