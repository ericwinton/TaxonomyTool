<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
	
	if (!empty($_POST['termId']) && !empty($_POST['termName']) && !empty($_POST['termTypeId'])) { 
		
		$termId = htmlspecialchars($_POST['termId']);
		$termName = htmlspecialchars($_POST['termName']);
		$termTypeId = htmlspecialchars($_POST['termTypeId']);
		$termDescription = '';
		$termParentId = 'NULL';
		$termServiceLineId = 'NULL';
		
		if (isset($_POST['termDescription'])) {
			$termDescription = htmlspecialchars($_POST['termDescription']);
		}
		
		if (isset($_POST['termParentId'])) {
			$termParentId = htmlspecialchars($_POST['termParentId']);
		}
		
		if (isset($_POST['termServiceLineId'])) {
			$termServiceLineId = htmlspecialchars($_POST['termServiceLineId']);
		}
		
		// Delete a term relationship
		sqlQuery('UPDATE ' . $_TERM_TABLE . ' SET name = ?, 
			term_type_id = ?,
			definition = ?, 
			parent_id = ?,
			root_id = ?,
			last_modified = ? 
			WHERE id = ?', array($termName, $termTypeId, $termDescription, $termParentId, $termServiceLineId, $_NOW, $termId));
	
	}
	
?>