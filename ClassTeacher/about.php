<?php
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
	<title>eSkolar - Students</title>
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/ruang-admin.min.css" rel="stylesheet">

	<style>
		.about-container {
			border-bottom: 30px solid #810403;
			border-top: 20px solid #810403;
		}

		.bg-about {
			background-color: #dba729;
		}

		.large-text {
			font-size: 35px;
			font-weight: bold;
		}

		.description {
			font-size: 20px;
		}

		.card {
			border: 10px solid white;
			background-color: #810403;
		}

		#container-wrapper {
			background-color: #810403;
		}

		.square-image-container {
			display: flex;
			justify-content: space-between;
			margin-top: 10px;
		}

		.square-image {
			width: 288px;
			height: 288px;
			object-fit: cover;
			border-radius: 10px;
			margin-right: 10px;
		}
	</style>
</head>

<body id="page-top">
	<div id="wrapper">
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<!-- TopBar -->
				<?php include "Includes/topbar.php"; ?>
				<div class="card-header bg-about py-3 d-flex flex-row align-items-center justify-content-between">
					<h1 class="h5 mb-0 text-primary">About Us</h1>
				</div>
				<div class="container-fluid about-container" id="container-wrapper">
					<div class="row">
						<div class="col-lg-4">
							<div class="card">
								<div class="card-body text-center">
									<p class="card-text text-uppercase large-text text-primary">
										CREATING A PATH TO SUCCESS, UNLEASH THE POTENTIAL OF STUDENTS THROUGH OUR COMPREHENSIVE
										STUDENT
										MANAGEMENT PLATFORM.
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-8">
							<div class="container mt-4">
								<div class="container-body">
									<p class="text-justify description text-primary">
										A school management software that has an easy-to-read interface, a simple learning curve, and a
										robust feature set. These systems work to coordinate scheduling and communications between
										faculty
										regarding students. They can check their academic records, enroll in classes, and oversee their
										day-to-day.
									</p>
								</div>
							</div>
							<div class="container mt-2">
								<div class="container-body text-center square-image-container">
									<img src="img/about/Picture1.jpg" alt="Image 1" class="square-image">
									<img src="img/about/Picture2.jpg" alt="Image 2" class="square-image">
									<img src="img/about/Picture3.jpg" alt="Image 3" class="square-image">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>