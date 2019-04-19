<?php

	header('Cache-Control: max-age=86400');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');

	include('api-logic.php');
	
	if ($fromCache === true) {
		echo $apiResults;
	} else {
		echo json_encode($apiResults);
	}

?>