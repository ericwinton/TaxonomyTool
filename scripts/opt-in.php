<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');

	if (!empty($_POST['termId'])) {
		
		$termId = htmlspecialchars($_POST['termId']);
		
		if (!empty($_POST['accessPointId'])) {
			
			$accessPointId = htmlspecialchars($_POST['accessPointId']);
			
			// Check if access point exists
			$accessPoint = sqlQuery('SELECT access_point_id FROM ' . $_ACCESS_POINT_TABLE . ' WHERE access_point_id = ?', array($accessPointId));
			
			if (count($accessPoint) > 0) {
		
				// Check if access point has already opted into this term
				$checkOptIns = sqlQuery('SELECT * FROM ' . $_OPT_IN_TABLE . ' WHERE term_id = ? AND access_point_id = ?', array($termId, $accessPointId));
				
				if (count($checkOptIns) === 0) {
					// Opt in term to access point
					sqlQuery('INSERT INTO ' . $_OPT_IN_TABLE . ' (term_id, access_point_id, last_modified) VALUES (?,?,?)', array($termId, $accessPointId, $_NOW));
				} else {
					echo 'Sorry, that access point has already been opted into this term';
				}
				
			} else {
				
				echo 'Sorry, that access point does not exist';
				
			}
			
		}
	
	}
	
?>