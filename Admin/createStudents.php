<?php
// Your database connection setup
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
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
  <title>Create Students</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <script>
    function classArmDropdown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxClassArms2.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
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
                  <h1 class="h5 mb-0 text-primary">Students</h1>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Class Arm</th>
                        <th>Date Created</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
          tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber,tblstudents.dateCreated
          FROM tblstudents
          INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
          INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId";
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
                              <td>" . $rows['firstName'] . "</td>
                              <td>" . $rows['lastName'] . "</td>
                              <td>" . $rows['otherName'] . "</td>
                              <td>" . $rows['admissionNumber'] . "</td>
                              <td>" . $rows['className'] . "</td>
                              <td>" . $rows['classArmName'] . "</td>
                              <td>" . $rows['dateCreated'] . "</td>
                              <td>
                                <a href='#' onclick='openEditModal(\"" . $rows['Id'] . "\", \"" . $rows['firstName'] . "\", \"" . $rows['lastName'] . "\", \"" . $rows['otherName'] . "\", \"" . $rows['classId'] . "\", \"" . $rows['classArmId'] . "\")'>
                                  <i class='fas fa-fw fa-edit'></i>
                                </a>
                              </td>
                              <td>
                                <a href='delete_student.php?Id=" . $rows['Id'] . "' onclick='return confirmDelete()'>
                                  <i class='fas fa-fw fa-trash'></i>
                                </a>
                              </td>
                            </tr>";
                        }
                      } else {
                        echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
                      }
                      ?>

                    </tbody>
                  </table>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal"
                    id="addStudentButton">
                    Add Student
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for adding/editing a student -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-navbar">
            <h5 class="modal-title text-primary" id="addStudentModalLabel">Add Student</h5>
            <button type="button" class="close text-primary" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="edit_student.php" method="POST" id="addStudentForm">
              <!-- The hidden field for storing the student ID for editing -->
              <input type="hidden" name="studentId" id="studentId">
              <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
              </div>
              <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
              </div>
              <div class="form-group">
                <label for="otherName">Middle Name</label>
                <input type="text" class="form-control" id="otherName" name="otherName" required>
              </div>
              <div class="form-group">
                <label for="classId">Class</label>
                <select class="form-control" id="classId" name="classId" required
                  onchange="updateClassArmDropdown(this.value)">
                  <option value="" disabled selected>Select Class</option>
                  <?php
                  // Fetch class options from the tblclass table
                  $query = "SELECT * FROM tblclass";
                  $result = $conn->query($query);
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Id'] . "'>" . $row['className'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="classArmId">Class Arm</label>
                <select class="form-control" id="classArmId" name="classArmId" required>
                  <option value="" disabled selected>Select Class Arm</option>
                </select>
              </div>
              <div class="form-group" hidden>
                <label for="admissionNumber">Admission Number</label>
                <input type="text" class="form-control" id="admissionNumber" name="admissionNumber" readonly>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" form="addStudentForm" id="modalSubmitButton">
              Add Student <!-- Default label for the button -->
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include "Includes/footer.php"; ?>
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

  <script>
    // JavaScript code to reset the modal fields and button label when adding a new student
    function openAddModal() {
      document.getElementById("addStudentModalLabel").innerHTML = "Add Student";
      document.getElementById("addStudentForm").action = "add_student.php"; // Change the form action URL for adding
      document.getElementById("studentId").value = ""; // Clear the student ID hidden field
      document.getElementById("firstName").value = "";
      document.getElementById("lastName").value = "";
      document.getElementById("otherName").value = "";
      document.getElementById("classId").value = "";
      document.getElementById("classArmId").value = "";

      // Set the value of the admission number input field
      document.getElementById("admissionNumber").value = admissionNumber;

      document.getElementById("modalSubmitButton").innerHTML = "Add Student"; // Change the button label for adding
      $('#addStudentModal').modal('show');
    }

    // Add an event listener to the "Add Student" button to open the add modal and reset data
    document.getElementById("addStudentButton").addEventListener("click", function () {
      openAddModal();
    });

    // Add an event listener to the modal form for submitting the data
    document.getElementById("addStudentForm").addEventListener("submit", function (event) {
      // Generate admission number automatically with the format AMS-year-random
      const year = new Date().getFullYear();
      const random = Math.floor(1000 + Math.random() * 9000);
      const admissionNumber = `AMS-${year}-${random}`;
      document.getElementById("admissionNumber").value = admissionNumber;

      // Allow the form to submit
      return true;
    });
  </script>

  <script>
    // JavaScript code to pre-fill the modal fields for editing and set the button label
    function openEditModal(Id, firstName, lastName, otherName, classId, classArmId) {
      document.getElementById("addStudentModalLabel").innerHTML = "Edit Student";
      document.getElementById("addStudentForm").action = "edit_student.php"; // Change the form action URL for editing
      document.getElementById("studentId").value = Id; // Set the student ID to the hidden field for editing
      document.getElementById("firstName").value = firstName;
      document.getElementById("lastName").value = lastName;
      document.getElementById("otherName").value = otherName;
      document.getElementById("classId").value = classId;
      document.getElementById("classArmId").value = classArmId;
      document.getElementById("modalSubmitButton").innerHTML = "Update Student"; // Change the button label for editing
      $('#addStudentModal').modal('show');
    }
  </script>

  <script>
    // JavaScript code to update class arm dropdown dynamically
    document.addEventListener("DOMContentLoaded", function () {
      // Fetch class arm options based on the selected class section
      document.getElementById("classId").addEventListener("change", function () {
        const classId = this.value;
        const classArmDropdown = document.getElementById("classArmId");

        // Clear existing options
        classArmDropdown.innerHTML = "<option value='' disabled selected>Select Class Arm</option>";
        classArmDropdown.disabled = true;

        if (classId) {
          // Send an AJAX request to fetch class arms for the selected class section
          const xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              // Update class arm options based on the server response
              classArmDropdown.innerHTML += this.responseText;
              classArmDropdown.disabled = false;
            }
          };
          xmlhttp.open("GET", "ajaxGetClassArms.php?classId=" + classId, true);
          xmlhttp.send();
        }
      });
    });
  </script>

  <!-- Delete -->
  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete this record?");
    }
  </script>
</body>

</html>