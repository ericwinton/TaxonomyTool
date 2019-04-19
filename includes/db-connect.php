<?php
	
	if ($_SERVER['SERVER_NAME'] == 'localhost') {
		//$userName = 'root';
		//$password = '';
		$serverName = 'xrdcwddbscdm01.hcadev.corpaddev.net';
		
		$dbName = 'CRM_Taxonomy';
	} else {
		$userName = 'admin';
		$password = 'df47bdb874fd9225c26e89085a4b4e799665e46d671a9fab';
		$serverName = 'localhost';
		$dbName = 'taxonomy_tool';
	}
	
	/*try {
		$pdo = new PDO('mysql:host=' . $serverName . ';dbname=' . $dbName, $userName, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8"'));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}*/
	
	try {
		$pdo = new PDO("sqlsrv:Server=" . $serverName . ";Database=" . $dbName, "", "");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

?>