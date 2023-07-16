<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT * FROM tblclassteacher WHERE Id = " . $_SESSION['userId'] . "";
$rs = $conn->query($query);
$num = $rs->num_rows;
$rrw = $rs->fetch_assoc();

// Fill Profile Info
$userProfile = [
	'firstName' => $rrw['firstName'],
	'lastName' => $rrw['lastName'],
	'emailAddress' => $rrw['emailAddress'],
	'phoneNo' => $rrw['phoneNo']
];

// Edit Profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$emailAddress = $_POST["emailAddress"];
	$password = md5($_POST["password"]);
	$phoneNo = $_POST["phoneNo"];

	$sql = "UPDATE tblclassteacher SET firstName='$firstName', lastName='$lastName', emailAddress='$emailAddress', password='$password', phoneNo='$phoneNo' WHERE Id = " . $_SESSION['userId'];

	if ($conn->query($sql) === TRUE) {
		if (mysqli_affected_rows($conn) > 0) {
			echo '<script>location.reload();</script>';
			exit;
		}
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
	<link href="img/logo/attnlg.jpg" rel="icon">
	<title>Profile</title>
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
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4">
								<div class="card-header bg-navbar py-3 d-flex flex-row align-items-center justify-content-between">
									<h1 class="h5 mb-0 text-primary">
										<?php echo $rrw['firstName'] . ' ' . $rrw['lastName']; ?>
									</h1>
								</div>
								<div class="card-body">
									<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="form-group">
											<label for="firstName">First Name</label>
											<input type="text" class="form-control" name="firstName"
												value="<?php echo $userProfile['firstName']; ?>" required>
										</div>
										<div class="form-group">
											<label for="lastName">Last Name</label>
											<input type="text" class="form-control" name="lastName"
												value="<?php echo $userProfile['lastName']; ?>" required>
										</div>
										<div class="form-group">
											<label for="emailAddress">Email</label>
											<input type="email" class="form-control" name="emailAddress"
												value="<?php echo $userProfile['emailAddress']; ?>" required>
										</div>
										<div class="form-group">
											<label for="password">Password</label>
											<input type="password" class="form-control" name="password" required>
										</div>
										<div class="form-group">
											<label for="phoneNo">Phone Number</label>
											<input type="tel" class="form-control" name="phoneNo"
												value="<?php echo $userProfile['phoneNo']; ?>" required>
										</div>
										<button type="submit" class="btn btn-primary">Save</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php include 'includes/footer.php'; ?>

	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="js/ruang-admin.min.js"></script>
	<script src="../vendor/chart.js/Chart.min.js"></script>
	<script src="js/demo/chart-area-demo.js"></script>

</body>

</html>