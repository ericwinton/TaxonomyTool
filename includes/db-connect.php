<?php
	
	$serverName = 'xrdcwddbscdm01.hcadev.corpaddev.net';
	$dbName = 'CRM_Taxonomy';
	
	try {
		$pdo = new PDO("sqlsrv:Server=" . $serverName . ";Database=" . $dbName, "", "");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

?>