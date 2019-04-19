<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
	
	if (!empty($_POST['q'])) {
		
		$q = htmlspecialchars($_POST['q']);
		$qWild = '%' . $q . '%';
		$finalResults = [];
		
		// Query
		$results = sqlQuery('SELECT TOP 10 * 
			FROM ' . $_ACCESS_POINT_TABLE . ' 
			WHERE facility_name LIKE ?
			ORDER BY facility_name asc', array($qWild));
			
		// Loop
		foreach($results as $result) {			
			array_push($finalResults, array(
				'id' => $result['access_point_id'],
				'link' => '<a href="/access-point/' . strtolower($result['access_point_id']) . '/">' . $result['facility_name'] . '</a>'
			));
		}
			
		// Encode
		echo json_encode(array('results' => $finalResults));
	}

?>