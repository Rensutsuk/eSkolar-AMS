<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['saveClassArm'])) {
  $classId = $_POST['classId'];
  $classArmName = $_POST['classArmName'];

  $query = mysqli_query($conn, "SELECT * FROM tblclassarms WHERE classArmName ='$classArmName' AND classId = '$classId'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Arm Already Exists!</div>";
  } else {
    $query = mysqli_query($conn, "INSERT INTO tblclassarms (classId, classArmName, isAssigned) VALUES ('$classId','$classArmName','0')");
    if ($query) {
      $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------EDIT------------------------------------------------------------

// Initialize variables to store data for editing
$editId = "";
$editClassId = "";
$editClassArmName = "";

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $editId = $_GET['Id'];

  $query = mysqli_query($conn, "SELECT * FROM tblclassarms WHERE Id ='$editId'");
  $row = mysqli_fetch_array($query);

  // Populate variables for editing
  $editClassId = $row['classId'];
  $editClassArmName = $row['classArmName'];
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "DELETE FROM tblclassarms WHERE Id='$Id'");

  if ($query == TRUE) {

    echo "<script type = \"text/javascript\">
                window.location = (\"createClassArms.php\")
                </script>";
  } else {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
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
  <?php include 'includes/title.php'; ?>
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
        <div class="container-fluid" id="container-wrapper">
          <!-- Input Group -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
                  <h1 class="h5 mb-0 text-primary">Subjects</h1>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Class Arm Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $query = "SELECT tblclassarms.Id, tblclassarms.isAssigned, tblclass.className, tblclassarms.classArmName 
            FROM tblclassarms
            INNER JOIN tblclass ON tblclass.Id = tblclassarms.classId";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn = 0;
                      $status = "";
                      if ($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $sn = $sn + 1;
                          echo "
                            <tr>
                              <td>" . $sn . "</td>
                              <td>" . $rows['className'] . "</td>
                              <td>" . $rows['classArmName'] . "</td>
                              <td><a href='#addClassArmModal' class='edit-btn' data-id='" . $rows['Id'] . "' data-class-id='" . $rows['classId'] . "' data-class-arm-name='" . $rows['classArmName'] . "' data-toggle='modal'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                              <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
                            </tr>";
                        }
                      } else {
                        echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
                      }
                      ?>
                    </tbody>
                  </table>
                  <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                    data-target="#addClassArmModal">
                    Add Class Arm
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for adding a class arm -->
  <div class="modal fade" id="addClassArmModal" tabindex="-1" role="dialog" aria-labelledby="addClassArmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-navbar">
          <h5 class="modal-title text-primary" id="addClassArmModalLabel">Add Class Arm</h5>
          <button type="button" class="close text-primary" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" id="classArmForm">
            <div class="form-group">
              <label for="classId">Class</label>
              <select class="form-control" id="classId" name="classId" required>
                <?php
                $query = "SELECT * FROM tblclass";
                $rs = $conn->query($query);
                if ($rs->num_rows > 0) {
                  while ($row = $rs->fetch_assoc()) {
                    echo '<option value="' . $row['Id'] . '">' . $row['className'] . '</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="classArmName">Class Arm Name</label>
              <input type="text" class="form-control" id="classArmName" name="classArmName" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <?php if ($editId !== ""): ?>
                <!-- Display "Update" button if we are in Edit mode -->
                <button type="submit" class="btn btn-primary" name="update">Update Class Arm</button>
              <?php else: ?>
                <!-- Display "Save" button if we are in Add mode -->
                <button type="submit" class="btn btn-primary" name="saveClassArm">Save Class Arm</button>
              <?php endif; ?>
            </div>
          </form>
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
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

  <script>
    // JavaScript code to handle the modal for adding/editing a class arm
    $(document).ready(function () {
      // Function to open the modal for adding a class arm
      function openAddClassArmModal() {
        $("#addClassArmModalLabel").text("Add Class Arm");
        $("#editClassArmId").val(""); // Clear the edit ID
        $("#classId").val("");
        $("#classArmName").val("");
        $("#classArmForm").attr("action", ""); // Set action to empty for adding
        $("#saveClassArmBtn").show();
        $("#updateClassArmBtn").hide();
      }

      // Function to open the modal for editing a class arm
      function openEditClassArmModal(id, classId, classArmName) {
        $("#addClassArmModalLabel").text("Edit Class Arm");
        $("#editClassArmId").val(id);
        $("#classId").val(classId);
        $("#classArmName").val(classArmName);
        $("#classArmForm").attr("action", "?Id=" + id + "&action=edit"); // Set action for editing
        $("#saveClassArmBtn").hide();
        $("#updateClassArmBtn").show();
      }

      // Open the modal when the "Add Class Arm" button is clicked
      $("#addClassArmBtn").on("click", function () {
        openAddClassArmModal();
      });

      // Open the modal when the "Edit" button is clicked
      $(".edit-btn").on("click", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var classId = $(this).attr("data-class-id");
        var classArmName = $(this).attr("data-class-arm-name");
        openEditClassArmModal(id, classId, classArmName);
      });

      // Clear the modal content when it's closed
      $('#addClassArmModal').on('hidden.bs.modal', function (e) {
        openAddClassArmModal();
      });
    });
  </script>
</body>

</html>