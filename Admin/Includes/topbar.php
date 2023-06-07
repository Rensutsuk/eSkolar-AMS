<?php
$query = "SELECT * FROM tbladmin WHERE Id = " . $_SESSION['userId'] . "";
$rs = $conn->query($query);
$num = $rs->num_rows;
$rows = $rs->fetch_assoc();
$fullName = $rows['firstName'] . " " . $rows['lastName'];

?>
<nav class="navbar navbar-expand bg-body-tertiary navbar-light bg-gradient-primary topbar mb-4 static-top">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="img\logo\attnlg.png" alt="Bootstrap" width="45" height="45">
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
    </a>
  </div>

  <div class="topbar-divider d-none d-sm-block"></div>
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
      aria-haspopup="true" aria-expanded="false">
      <img class="img-profile rounded-circle" src="img/user-icn.png" style="max-width: 60px">
      <span class="ml-2 d-none d-lg-inline text-white small"><b>Welcome
          <?php echo $fullName; ?>
        </b></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#">
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
        Profile
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="logout.php">
        <i class="fas fa-power-off fa-fw mr-2 text-danger"></i>
        Logout
      </a>
    </div>
  </li>
  </ul>
</nav>