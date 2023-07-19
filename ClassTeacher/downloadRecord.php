<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_GET['dateTaken'])) {
	$dateTaken = $_GET['dateTaken'];
} else {
	// If the dateTaken parameter is not provided, you can set a default date or handle the error as needed.
	// For this example, let's set the default to the current date.
	$dateTaken = date("Y-m-d");
}

$filename = "Attendance_List_" . $dateTaken . ".xls"; // Modify the filename to include the date

$ret = mysqli_query($conn, "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
        tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
        tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
        FROM tblattendance
        INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
        INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
        INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
        WHERE tblattendance.dateTimeTaken = '$dateTaken' AND tblattendance.classId = '$_SESSION[classId]' AND tblattendance.classArmId = '$_SESSION[classArmId]'");

// Set the appropriate headers for Excel file download
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
			<th>Other Name</th>
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
		if (mysqli_num_rows($ret) > 0) {
			while ($row = mysqli_fetch_array($ret)) {
				if ($row['status'] == '1') {
					$status = "Present";
					$colour = "#00FF00";
				} else {
					$status = "Absent";
					$colour = "#FF0000";
				}

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
      <td>' . $status . '</td>	 	
      <td>' . $row['dateTimeTaken'] . '</td>	 					
    </tr>  
    ';

				$cnt++;
			}
		}
		?>
	</tbody>
</table>