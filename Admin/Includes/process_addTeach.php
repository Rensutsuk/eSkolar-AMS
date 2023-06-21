<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$emailAddress = $_POST['emailAddress'];

$phoneNo = $_POST['phoneNo'];
$classId = $_POST['classId'];
$classArmId = $_POST['classArmId'];
$dateCreated = date("Y-m-d");

$query = mysqli_query($conn, "select * from tblclassteacher where emailAddress ='$emailAddress'");
$ret = mysqli_fetch_array($query);

$sampPass = "pass123";
$sampPass_2 = md5($sampPass);

if ($ret > 0) {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
} else {

    $query = mysqli_query($conn, "INSERT into tblclassteacher(firstName,lastName,emailAddress,password,phoneNo,classId,classArmId,dateCreated) 
  value('$firstName','$lastName','$emailAddress','$sampPass_2','$phoneNo','$classId','$classArmId','$dateCreated')");

    if ($query) {

        $qu = mysqli_query($conn, "update tblclassarms set isAssigned='1' where Id ='$classArmId'");
        if ($qu) {

            $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
        } else {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }
    } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
}
// Redirect back to the form page with the status message
header("Location: your_form_page.php?status=" . urlencode($statusMsg));
exit;
?>