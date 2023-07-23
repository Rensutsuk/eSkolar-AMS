<?php
// Your database connection setup
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $otherName = $_POST["otherName"];
  $classId = $_POST["classId"];
  $classArmId = $_POST["classArmId"];
  $password = $_POST["password"]; // md5("pass123")
  $admissionNumber = $_POST["admissionNumber"]; // Automatically generated

  // Prepare the SQL query to insert the student record
  $query = "INSERT INTO tblstudents (firstName, lastName, otherName, admissionNumber, password, classId, classArmId, dateCreated) 
            VALUES ('$firstName', '$lastName', '$otherName', '$admissionNumber', '$password', '$classId', '$classArmId', CURDATE())";

  // Execute the query
  if ($conn->query($query) === TRUE) {
    // Student record inserted successfully
    // You can redirect back to the students page or display a success message
    header("Location: createStudents.php"); // Replace 'students.php' with the actual URL of the page showing the students table
    exit;
  } else {
    // Handle the case where the record insertion failed
    // You can redirect back to the students page or display an error message
    echo "Error: " . $conn->error;
    // header("Location: students.php"); // Uncomment this line if you want to redirect on error
    // exit;
  }
}
?>