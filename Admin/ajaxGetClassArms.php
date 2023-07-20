<?php
// Your database connection setup
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];

    // Fetch class arms for the selected class section
    $query = "SELECT * FROM tblclassarms WHERE classId = '$classId'";
    $result = $conn->query($query);

    // Build the response string with class arm options
    $response = "";
    while ($row = $result->fetch_assoc()) {
        $response .= "<option value='" . $row['Id'] . "'>" . $row['classArmName'] . "</option>";
    }

    // Return the response
    echo $response;
}
?>