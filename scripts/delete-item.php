<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');

	if (!empty($_POST['mappedId']) && !empty($_POST['itemId']) && !empty($_POST['itemType'])) {
		
		$mappedId = htmlspecialchars($_POST['mappedId']);
		$itemId = htmlspecialchars($_POST['itemId']);
		$itemType = htmlspecialchars($_POST['itemType']);
		
		if ($itemType == "term_relationship") {
			
			// Delete a term relationship
			sqlQuery('DELETE FROM ' . $_TERM_RELATIONSHIP_TABLE . '
				WHERE ((term1_id = ? AND term2_id = ?) 
				OR (term2_id = ? AND term1_id = ?))', array($mappedId, $itemId, $mappedId, $itemId));
			
		} elseif ($itemType == "access_point_opt_in") {
		
			// Delete an access point opt in
			sqlQuery('DELETE FROM ' . $_OPT_IN_TABLE . ' 
				WHERE term_id = ? 
				AND access_point_id = ?', array($mappedId, $itemId));
			
		}
	
	}
	
?>