<?php
	$serverName = "eskolar.database.windows.net";
	$connectionOptions = array(
		"Database" => "eSkolar-AMS",
		"Uid" => "Rensutsuki",
		"PWD" => "%4iJQg4@KKe8pVG&"
	);
	
	$conn = sqlsrv_connect($serverName, $connectionOptions);
	
	if ($conn === false) {
		die(print_r(sqlsrv_errors(), true));
	} else {
		echo "Connected to SQL Server successfully!";
	}
?>
