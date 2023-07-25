<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
  $sessionName = $_POST['sessionName'];
  $termId = $_POST['termId'];
  $dateCreated = date("Y-m-d");

  $query = mysqli_query($conn, "SELECT * FROM tblsessionterm WHERE sessionName ='$sessionName' AND termId = '$termId'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Session and Term Already Exists!</div>";
  } else {
    $query = mysqli_query($conn, "INSERT INTO tblsessionterm (sessionName, termId, isActive, dateCreated) VALUES ('$sessionName', '$termId', '0', '$dateCreated')");
    if ($query) {
      $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "select * from tblsessionterm where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {
    $sessionName = $_POST['sessionName'];
    $termId = $_POST['termId'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "update tblsessionterm set sessionName='$sessionName',termId='$termId',isActive='0' where Id='$Id'");

    if ($query) {
      echo "<script type = \"text/javascript\">
                window.location = (\"createSessionTerm.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "DELETE FROM tblsessionterm WHERE Id='$Id'");

  if ($query == TRUE) {
    echo "<script type = \"text/javascript\">
                window.location = (\"createSessionTerm.php\")
                </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
  }
}

//--------------------------------ACTIVATE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "activate") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "update tblsessionterm set isActive='0' where isActive='1'");

  if ($query) {
    $que = mysqli_query($conn, "update tblsessionterm set isActive='1' where Id='$Id'");

    if ($que) {
      echo "<script type = \"text/javascript\">
                    window.location = (\"createSessionTerm.php\")
                    </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
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
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
                  <h1 class="h5 mb-0 text-primary">Sessions and Terms</h1>
                  <h1 class="h6 mb-0 text-warning"><i>Click on the check symbol besides each to make session and term active!</i></h1>
                  </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Activate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      $query = "SELECT tblsessionterm.Id,tblsessionterm.sessionName,tblsessionterm.isActive,tblsessionterm.dateCreated,
                      tblterm.termName
                      FROM tblsessionterm
                      INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn = 0;
                      if ($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          if ($rows['isActive'] == '1') {
                            $status = "Active";
                          } else {
                            $status = "InActive";
                          }
                          $sn = $sn + 1;
                          echo "
                              <tr>
                                <td>" . $sn . "</td>
                                <td>" . $rows['sessionName'] . "</td>
                                <td>" . $rows['termName'] . "</td>
                                <td>" . $status . "</td>
                                <td>" . $rows['dateCreated'] . "</td>
                                 <td><a href='?action=activate&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-check'></i></a></td>
                                <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i></a></td>
                                <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i></a></td>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSessionModal">
                    Add New Session
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include "Includes/footer.php"; ?>

  <!-- Modal for adding new session -->
  <div class="modal fade" id="addSessionModal" tabindex="-1" role="dialog" aria-labelledby="addSessionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSessionModalLabel">Add New Session</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Session form -->
          <form action="" method="post">
            <div class="form-group">
              <label for="sessionName">Session Name</label>
              <input type="text" class="form-control" name="sessionName" required>
            </div>
            <div class="form-group">
              <label for="termId">Term</label>
              <select class="form-control" name="termId" required>
                <?php
                // Fetch the terms from the tblterm table
                $query = "SELECT * FROM tblterm";
                $rs = $conn->query($query);
                while ($row = $rs->fetch_assoc()) {
                  echo '<option value="' . $row['Id'] . '">' . $row['termName'] . '</option>';
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary" name="save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

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
</body>

</html>