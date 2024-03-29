<?php
$query = "SELECT * FROM tbladmin WHERE Id = " . $_SESSION['userId'] . "";
$rs = $conn->query($query);
$num = $rs->num_rows;
$rows = $rs->fetch_assoc();
$fullName = $rows['firstName'] . " " . $rows['lastName'];

?>

<nav class="navbar navbar-expand bg-body-tertiary navbar-light bg-gradient-primary topbar mb-4 static-top">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand nav-link text-white" href="index.php">
      <img src="img\logo\attnlg.png" width="40" height="40" class="d-inline-block align-text-center">
      eSkolar AMS
    </a>
    <!-- Navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="createStudents.php">Students</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="createClassTeacher.php">Teachers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="createClass.php">Class</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="createClassArms.php">Subject</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="createSessionTerm.php">Term</a>
        </li>
      </ul>
    </div>
    <!-- UserProfile Button -->
    <div class="dropdown no-arrow open">
      <button class="btn dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <img class="img-profile rounded-circle" src="img/user-icn.png" style="max-width: 40px">
        <span class="ml-2 d-none d-lg-inline text-white small"><b>Welcome
            <?php echo $fullName; ?>
          </b></span>
      </button>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="triggerId">
        <a class="dropdown-item" href="#">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="logout.php">
          <i class="fas fa-power-off fa-fw mr-2 text-danger"></i>
          Logout
        </a>
      </div>
    </div>
    </li>
  </div>
</nav>