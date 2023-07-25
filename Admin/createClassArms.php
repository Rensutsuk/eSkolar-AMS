<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
  $classId = $_POST['classId'];
  $classArmName = $_POST['classArmName'];

  $query = mysqli_query($conn, "select * from tblclassarms where classArmName ='$classArmName' and classId = '$classId'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Arm Already Exists!</div>";
  } else {
    $query = mysqli_query($conn, "insert into tblclassarms(classId,classArmName,isAssigned) value('$classId','$classArmName','0')");
    if ($query) {
      $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "select * from tblclassarms where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {
    $classId = $_POST['classId'];
    $classArmName = $_POST['classArmName'];

    $query = mysqli_query($conn, "update tblclassarms set classId = '$classId', classArmName='$classArmName' where Id='$Id'");

    if ($query) {
      echo "<script type = \"text/javascript\">
                window.location = (\"createClassArms.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
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
  <title>Manage Subjects</title>
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
                  <h1 class="h5 mb-0 text-primary">Subjects</h1>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Subject</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $query = "SELECT tblclassarms.Id,tblclassarms.isAssigned,tblclass.className,tblclassarms.classArmName 
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
                                <td>
                                  <a href='#addClassSubjectModal' data-toggle='modal' data-target='#addClassSubjectModal' data-id='" . $rows['Id'] . "' data-classid='" . $rows['classId'] . "' data-classarmname='" . $rows['classArmName'] . "'>
                                    <i class='fas fa-fw fa-edit'></i>Edit
                                  </a>
                                </td>
                                <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
                              </tr>";
                        }
                      } else {
                        echo
                          "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }
                      ?>
                    </tbody>
                  </table>
                  <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                    data-target="#addClassSubjectModal">
                    Add Subject
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add/Edit Class Subject Modal -->
  <div class="modal fade" id="addClassSubjectModal" tabindex="-1" role="dialog"
    aria-labelledby="addClassSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-navbar">
          <h5 class="modal-title text-primary" id="addClassSubjectModalLabel">Add Subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="">
          <div class="modal-body">
            <input type="hidden" id="modalId" name="modalId">
            <div class="form-group">
              <label for="classId">Select Class:</label>
              <select class="form-control" id="classId" name="classId" required>
                <?php
                $classQuery = "SELECT * FROM tblclass";
                $classResult = $conn->query($classQuery);
                while ($classRow = $classResult->fetch_assoc()) {
                  echo "<option value='" . $classRow['Id'] . "'>" . $classRow['className'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="classArmName">Subject Name:</label>
              <input type="text" class="form-control" id="classArmName" name="classArmName" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="save">Save</button>
            <button type="submit" class="btn btn-primary" name="update">Update</button>
          </div>
        </form>
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

      // Handle Edit button click
      $('#addClassSubjectModal').on('show.bs.modal', function (e) {
        var link = e.relatedTarget;
        var Id = link.getAttribute('data-id');
        var classId = link.getAttribute('data-classid');
        var classArmName = link.getAttribute('data-classarmname');

        // Update the modal's form action based on whether it's an edit or add
        var form = $(this).find('form');
        var updateButton = form.find('[name="update"]');
        var saveButton = form.find('[name="save"]');
        form.attr('action', (Id ? 'createClassArms.php?action=edit&Id=' + Id : 'createClassArms.php'));
        updateButton.toggle(Id !== null);
        saveButton.toggle(Id === null);

        // Populate the form fields with data for editing
        form.find('#modalId').val(Id);
        form.find('#classId').val(classId);
        form.find('#classArmName').val(classArmName);
      });
    });
  </script>
</body>

</html>