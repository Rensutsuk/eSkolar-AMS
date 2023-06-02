<?php
	try {
		$conn = new PDO("sqlsrv:server = tcp:eskolar.database.windows.net,1433; Database = eSkolar-AMS", "Rensutsuki", "%4iJQg4@KKe8pVG&");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		print("Error connecting to SQL Server.");
		die(print_r($e));
	}

	// SQL Server Extension Sample Code:
	$connectionInfo = array("UID" => "Rensutsuki", "pwd" => "%4iJQg4@KKe8pVG&", "Database" => "eSkolar-AMS", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
	$serverName = "tcp:eskolar.database.windows.net,1433";
	$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
