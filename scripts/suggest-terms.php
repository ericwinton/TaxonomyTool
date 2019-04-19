<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
	
	if (!empty($_POST['q'])) {
		
		$q = htmlspecialchars($_POST['q']);
		$qWild = $q . '%';
		$queryValues = array($qWild);
		$accessPointJoin = '';
		$accessPointWhere = '';
		$termTypeWhere = '';
		$isParentWhere = '';
		$finalResults = [];
		$baseWhere = ' WHERE t.name LIKE ?';
	
		// Filter by term type
		if (!empty($_POST['termTypeId'])) {
			$termTypeId = htmlspecialchars($_POST['termTypeId']);
			$termTypeWhere = ' AND t.term_type_id = ?';
			array_push($queryValues, $termTypeId);
		}
		
		// Filter by access point
		if (!empty($_POST['accessPointId'])) {
			$accessPointId = htmlspecialchars($_POST['accessPointId']);
			$accessPointJoin = ' INNER JOIN ' . $optInTable . ' opt ON t.id = opt.term_id';
			$accessPointWhere = ' AND opt.access_point_id = ?';
			array_push($queryValues, $accessPointId);
		}
		
		// Filter by access point
		if (!empty($_POST['isParent']) && $_POST['isParent'] === true) {
			$isParent = htmlspecialchars($_POST['isParent']);
			$isParentWhere = ' AND t.id IN (SELECT parent_id FROM ' . $termTable . ')';
		}	
		
		// Query
		$results = sqlQuery('SELECT TOP 10 * 
			FROM ' . $_TERM_TABLE . ' t 
			' . $accessPointJoin . '
			' . $baseWhere . '
			' . $termTypeWhere . '
			' . $accessPointWhere . '
			' . $isParentWhere . '
			ORDER BY t.name asc', $queryValues);
			
		// Loop
		foreach($results as $result) {
			
			$termParent = '';
			$termServiceLine = 'Service Line';
		
			if ($result['root_id'] != NULL) {
				$serviceLine = sqlQuery('SELECT TOP 1 name FROM ' . $_TERM_TABLE . ' WHERE id = ?', array($result['root_id']));
			
				if (count($serviceLine) > 0) {
					$termServiceLine = $serviceLine[0]['name'];
				}
			}
			
			if ($result['parent_id'] != NULL) {
				$parent = sqlQuery('SELECT TOP 1 name FROM ' . $_TERM_TABLE . ' WHERE id = ?', array($result['parent_id']));
				
				if (count($parent) > 0) {
					$termParent = ' / ' . $parent[0]['name'];
				}
			}
			
			$serviceLineAndGroup = '<br /> (' . $termServiceLine . $termParent . ')';
			
			array_push($finalResults, array(
				'id' => $result['id'],
				'name' => $result['name'] . ' ' . $termServiceLine . ' ' . $termParent,
				'link' => '<a href="/term/' . strtolower($result['id']) . '"><strong>' . $result['name'] . '</strong>' . $serviceLineAndGroup . '</a>'
			));
		}
		
		// Sort
		usort($finalResults, function($item1, $item2) {
			if ($item1['name'] == $item2['name']) {
				return 0;
			}
			
			return $item1['name'] < $item2['name'] ? -1 : 1;
		});
			
		// Encode
		echo json_encode(array('results' => $finalResults));
	}

?>