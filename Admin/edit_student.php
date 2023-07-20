<?php
// Your database connection setup
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data and update the database record for the corresponding student ID
  $Id = $_POST['studentId']; // Corrected: Use 'studentId' instead of 'Id'
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $otherName = $_POST['otherName'];
  $classId = $_POST['classId'];
  $classArmId = $_POST['classArmId'];

  // Perform the database update query using the provided data
  $query = "UPDATE tblstudents SET firstName = '$firstName', lastName = '$lastName', otherName = '$otherName', classId = '$classId', classArmId = '$classArmId' WHERE Id = '$Id'";

  if ($conn->query($query) === TRUE) {
    // Redirect back to the main page after editing
    header("Location: createStudents.php");
    exit();
  } else {
    echo "Error updating record: " . $conn->error;
  }
}
?>