<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');

	$apArray = [];
	$response = '';

	if (!empty($_POST['access_point_batch'])) {
		$accessPointBatch = htmlspecialchars(trim($_POST['access_point_batch']));
		
		$apPiped = str_replace("\t", "|", $accessPointBatch);
		
		$apArray = explode("\n", $apPiped);
		
	} elseif (!empty($_POST['access_point_id']) && !empty($_POST['facility_name'])) {
		$accessPointId = htmlspecialchars(trim($_POST['access_point_id']));
		$facilityName = htmlspecialchars(trim($_POST['facility_name']));
		
		$apArray = [$accessPointId . '|' . $facilityName];
	}
	
	if (count($apArray) > 0) {
		
		foreach($apArray as $ap) {
			
			if (strpos($ap, "|") !== false) {
				$accessPointParts = explode("|", $ap);
				$accessPointId = $accessPointParts[0];
				$facilityName = $accessPointParts[1];
				
				if (strlen($accessPointId) === 36) {
			
					$checkAP = sqlQuery('SELECT access_point_id FROM ' . $_ACCESS_POINT_TABLE . ' WHERE access_point_id = ?', array($accessPointId));
					
					if (count($checkAP) === 0) {

						sqlQuery('INSERT INTO ' . $_ACCESS_POINT_TABLE . ' (access_point_id, facility_name, last_modified) VALUES (?,?,?)', array($accessPointId, $facilityName, $_NOW));
					
						$response .= $facilityName . " - Successfully Added!\n";
						
					} else {
						
						$response .= $facilityName . " - Already Exists\n";
						
					}
				
				} else {
					
					$response .= $accessPointId . " - Incorrect ID Length\n";
					
				}
				
			} else {
				
				$response .= $ap . " - Line is malformed\n";
				
			}
		
		}
			
	} else {
		
		$response .= "Please supply an Access Point ID and a Facility Name\n";
		
	}
	
	echo $response;
	
?>