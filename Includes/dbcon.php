<?php
	$connectionInfo = array("UID" => "Rensutsuki", "pwd" => "%4iJQg4@KKe8pVG&", "Database" => "eSkolar-AMS", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
	$serverName = "tcp:eskolar.database.windows.net,1433";
	$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
