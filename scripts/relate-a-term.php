<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');

	if (!empty($_POST['term1Id'])) {
		
		$term1Id = htmlspecialchars($_POST['term1Id']);
		
		if (!empty($_POST['term2Id'])) {
			
			$term2Id = htmlspecialchars($_POST['term2Id']);
		
			// Check if access point has already opted into this term
			$checkTermRel = sqlQuery('SELECT * 
				FROM ' . $_TERM_RELATIONSHIP_TABLE . '  
				WHERE ((term1_id = ? AND term2_id = ?) 
				OR (term2_id = ? AND term1_id = ?))', array($term1Id, $term2Id, $term1Id, $term2Id));
			
			if (count($checkTermRel) == 0) {
				// Opt in term to access point
				sqlQuery('INSERT INTO ' . $_TERM_RELATIONSHIP_TABLE . ' (term1_id, term2_id, last_modified) VALUES (?,?,?)', array($term1Id, $term2Id, $_NOW));
			} else {
				echo 'Sorry, that term is already related';
			}
				
		}
	
	}
	
?>