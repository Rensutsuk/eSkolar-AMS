<?php
	$serverName = "tcp:eskolar.database.windows.net,1433";
	$connectionOptions = array(
		"Database" => "eSkolar-AMS",
		"Uid" => "Rensutsuki",
		"PWD" => "%4iJQg4@KKe8pVG&"
	);
	
	$conn = sqlsrv_connect($serverName, $connectionOptions);
	
	if ($conn === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	
	// Perform database operations using $conn
?>
