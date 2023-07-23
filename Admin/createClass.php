<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
  $className = $_POST['className'];

  $query = mysqli_query($conn, "SELECT * FROM tblclass WHERE className ='$className'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Already Exists!</div>";
  } else {
    $query = mysqli_query($conn, "INSERT INTO tblclass (className) VALUES ('$className')");
    if ($query) {
      $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------------------EDIT-----------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "SELECT * FROM tblclass WHERE Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {
    $className = $_POST['className'];
    $query = mysqli_query($conn, "UPDATE tblclass SET className='$className' WHERE Id='$Id'");
    if ($query) {
      echo "<script type=\"text/javascript\">window.location = (\"createClass.php\");</script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------------------DELETE----------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "DELETE FROM tblclass WHERE Id='$Id'");
  if ($query == TRUE) {
    echo "<script type=\"text/javascript\">window.location = (\"createClass.php\");</script>";
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
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
                  <h1 class="h5 mb-0 text-primary">Classes</h1>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $query = "SELECT * FROM tblclass";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn = 0;
                      if ($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $sn = $sn + 1;
                          $classId = $rows['Id']; // Get the ID of the class
                          echo "
                            <tr>
                              <td>" . $sn . "</td>
                              <td>" . $rows['className'] . "</td>
                              <td>
                                <a href=\"#addClassModal\" class=\"edit-btn\" data-id=\"" . $classId . "\" data-toggle=\"modal\">
                                  <i class=\"fas fa-fw fa-edit\"></i>Edit
                                </a>
                              </td>
                              <td>
                                <a href='?action=delete&Id=" . $classId . "'>
                                  <i class='fas fa-fw fa-trash'></i>Delete
                                </a>
                              </td>
                            </tr>";
                        }
                      } else {
                        echo "
                          <tr>
                            <td colspan='4' class='text-center'>No Record Found!</td>
                          </tr>";
                      }
                      ?>
                    </tbody>

                  </table>
                  <button type="button" class="btn btn-primary mb-3" id="add-btn" data-toggle="modal"
                    data-target="#addClassModal"> Add Class
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Modal for adding/editing a class -->
  <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-navbar">
          <h5 class="modal-title text-primary" id="addClassModalLabel">Add Class</h5>
          <button type="button" class="close text-primary" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" id="classForm">
            <div class="form-group">
              <label for="className">Class Name</label>
              <input type="text" class="form-control" id="className" name="className" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" name="save">Add Class</button>
              <button type="submit" class="btn btn-primary" name="update" form="classForm" style="display: none;">Update
                Class</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

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
    $(document).ready(function () {
      // Function to open the modal for adding a class
      function openAddModal() {
        $("#addClassModalLabel").text("Add Class");
        $("#className").val("");
        $("#classForm").attr("action", ""); // Set action to empty for adding
        $("button[name='save']").show();
        $("button[name='update']").hide();
      }

      // Function to open the modal for editing a class
      function openEditModal(id, className) {
        $("#addClassModalLabel").text("Edit Class");
        $("#className").val(className);
        $("#classForm").attr("action", "?Id=" + id + "&action=edit");
        $("button[name='save']").hide();
        $("button[name='update']").show();
        $('#addClassModal').modal('show');
      }

      // Open the modal when the "Add" button is clicked
      $("#add-btn").on("click", function () {
        openAddModal();
      });

      // Open the modal when the "Edit" button is clicked
      $(document).on("click", ".edit-btn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var className = $(this).closest("tr").find("td:eq(1)").text();
        openEditModal(id, className);
      });

      // Clear the modal content when it's closed
      $('#addClassModal').on('hidden.bs.modal', function (e) {
        openAddModal();
      });
    });
  </script>

</body>

</html>