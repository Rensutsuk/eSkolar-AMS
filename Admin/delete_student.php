<?php
// Your database connection setup
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_GET['Id'])) {
    $studentId = $_GET['Id'];

    // Prepare the SQL query to delete the student record
    $query = "DELETE FROM tblstudents WHERE Id = '$studentId'";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Student record deleted successfully
        // You can redirect back to the students page or display a success message
        header("Location: createStudents.php"); // Replace 'createStudent.php' with the actual URL of the page showing the students table
        exit;
    } else {
        // Handle the case where the record deletion failed
        // You can redirect back to the students page or display an error message
        echo "Error: " . $conn->error;
        // header("Location: ../createStudent.php"); // Uncomment this line if you want to redirect on error
        // exit;
    }
}
?>