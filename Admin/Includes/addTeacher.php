<?php
if (isset($_POST['save'])) {

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
}
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addTeacher">
    Add
</button>

<!-- Modal -->
<div class="modal fade" id="addTeacher" tabindex="-1" role="dialog" aria-labelledby="teacherAddTriger"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Teacher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="form-control-label">Firstname<span class="text-danger ml-2">*</span></label>
                <input type="text" class="form-control" required name="firstName"
                    value="<?php echo $row['firstName']; ?>" id="exampleInputFirstName">
                <label class="form-control-label">Lastname<span class="text-danger ml-2">*</span></label>
                <input type="text" class="form-control" required name="lastName" value="<?php echo $row['lastName']; ?>"
                    id="exampleInputFirstName">
                <label class="form-control-label">Email Address<span class="text-danger ml-2">*</span></label>
                <input type="email" class="form-control" required name="emailAddress"
                    value="<?php echo $row['emailAddress']; ?>" id="exampleInputFirstName">
                <label class="form-control-label">Phone No<span class="text-danger ml-2">*</span></label>
                <input type="text" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo']; ?>"
                    id="exampleInputFirstName">
                <label class="form-control-label">Select Class<span class="text-danger ml-2">*</span></label>
                <?php
                $qry = "SELECT * FROM tblclass ORDER BY className ASC";
                $result = $conn->query($qry);
                $num = $result->num_rows;
                if ($num > 0) {
                    echo ' <select required name="classId" onchange="classArmDropdown(this.value)" class="form-control mb-3">';
                    echo '<option value="">--Select Class--</option>';
                    while ($rows = $result->fetch_assoc()) {
                        echo '<option value="' . $rows['Id'] . '" >' . $rows['className'] . '</option>';
                    }
                    echo '</select>';
                }
                ?>
                <label class="form-control-label">Class Arm<span class="text-danger ml-2">*</span></label>
                <?php
                echo "<div id='txtHint'></div>";
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>