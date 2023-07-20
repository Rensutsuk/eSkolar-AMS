<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Check if the form is submitted and handle the request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['downloadAttendance'])) {
  $studentId = $_POST['student'];
  $dateRangeOption = $_POST['dateRangeOption'];
  $startDate = null;
  $endDate = null;

  if ($dateRangeOption === 'range') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
  }

  // Fetch attendance data for the specified student and date range if applicable
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

  if ($dateRangeOption === 'range') {
    $query .= " AND tblattendance.dateTimeTaken BETWEEN ? AND ?";
    $parameters[] = $startDate;
    $parameters[] = $endDate;
  }

  $stmt = $conn->prepare($query);
  $stmt->bind_param(str_repeat('s', count($parameters)), ...$parameters);
  $stmt->execute();
  $result = $stmt->get_result();

  // Set the appropriate headers for Excel file download
  $filename = "Attendance_List_" . date("Y-m-d_H-i-s") . ".xls";
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=" . $filename);
  header("Pragma: no-cache");
  header("Expires: 0");
  ?>

  <table border="1">
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
    <tbody>
      <?php
      $cnt = 1;
      while ($row = $result->fetch_assoc()) {
        $status = ($row['status'] == '1') ? "Present" : "Absent";
        $statusColor = $row['status'] == '1' ? 'green' : 'red';

        echo '
        <tr>  
          <td>' . $cnt . '</td> 
          <td>' . $row['firstName'] . '</td> 
          <td>' . $row['lastName'] . '</td> 
          <td>' . $row['otherName'] . '</td> 
          <td>' . $row['admissionNumber'] . '</td> 
          <td>' . $row['className'] . '</td> 
          <td>' . $row['classArmName'] . '</td>	
          <td>' . $row['sessionName'] . '</td>	 
          <td>' . $row['termName'] . '</td>	
          <td style="color: ' . $statusColor . '">' . $status . '</td>	 	
          <td>' . $row['dateTimeTaken'] . '</td>	 					
        </tr>  
        ';

        $cnt++;
      }
      ?>
    </tbody>
  </table>
  <?php
  // Exit the script to prevent further output
  exit;
} else {
  // If the form is not submitted, you can handle the error or redirect the user as needed.
  // For this example, let's redirect the user back to the main page.
  header("Location: index.php");
  exit;
}