<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
	
	$parentId = NULL;
	$serviceLineId = NULL;
	$termName = '';
	$termDefinition = '';
	$termTypeId = '';

	if (!empty($_POST['parent_id'])) {
		$parentId = htmlspecialchars($_POST['parent_id']);
	}
	
	if (!empty($_POST['service_line_id'])) {
		$serviceLineId = htmlspecialchars($_POST['service_line_id']);
	}
	
	if (!empty($_POST['term_name'])) {
		$termName = htmlspecialchars($_POST['term_name']);
	}
	
	if (!empty($_POST['term_definition'])) {
		$termDefinition = htmlspecialchars($_POST['term_definition']);
	}
	
	if (!empty($_POST['term_type_id'])) {
		$termTypeId = htmlspecialchars($_POST['term_type_id']);
	}
	
	if ($termName != '' && $termTypeId != '') {
		
		$newTermId = getGUID();
	
		sqlQuery('INSERT INTO ' . $_TERM_TABLE . ' 
			(id, name, definition, term_type_id, root_id, parent_id, last_modified) 
			VALUES (?,?,?,?,?,?,?)', array($newTermId, $termName, $termDefinition, $termTypeId, $serviceLineId, $parentId, $_NOW));
			
		echo $newTermId;
			
	} else {
		
		echo 'Please supply a term name and term type';
		
	}
?>