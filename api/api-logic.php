<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
	
	$apiType = '';
	$apiFilter = '';
	$apiId = '';
	$apiLimit = 10;
	$apiResults['results'] = [];
	$whereStmt = '';
	$queryValues = [];
	$fromCache = false;
	
	if (!empty($_GET['type']) && !empty($_GET['query'])) {
		$apiType = htmlspecialchars($_GET['type']);
		$apiQuery = htmlspecialchars($_GET['query']);
	
		if (!empty($_GET['limit'])) {
			$apiLimit = htmlspecialchars($_GET['limit']);
		}
		
		$cacheDir = $_SERVER['DOCUMENT_ROOT'] . '/cache/';
		
		if (!file_exists($cacheDir)) {
			mkdir($cacheDir, 0755);
		}
		
		$cacheFile = $cacheDir . $apiType . '-' . $apiQuery . '-' . $apiLimit . '.php';
	
		if (file_exists($cacheFile) && $_ENABLE_CACHE === true) {
			
			$fp = fopen($cacheFile, 'r');
			$apiResults = fread($fp, filesize($cacheFile));
			fclose($fp);
			
			$fromCache = true;
			
		} else {
				
			if ($apiType === 'term') {
				
				// TERMS API
				
				//$joinStmt = 'INNER JOIN term_type tt ON (t.term_type_id = tt.id)';
				$orderStmt = 't.name ASC';
				
				if (!empty($apiQuery)) {
					
					$apiQueryArray = explode(',', $apiQuery);
					
					$i = 0;
					
					foreach($apiQueryArray as $apiQueryPart) {
						if (strpos($apiQueryPart, '~~') !== false) {
							$queryPart = explode('~~', $apiQueryPart);
							$queryOperator = ' LIKE ';
							$queryVal = $queryPart[1] . '%';
						} elseif (strpos($apiQueryPart, '~') !== false) {
							$queryPart = explode('~', $apiQueryPart);
							$queryOperator = ' = ';
							$queryVal = $queryPart[1];
						}
						
						$queryCol = $queryPart[0];
						
						if ($i == 0) {
							$whereStmt .= ' WHERE ' . $queryCol . $queryOperator . '?';
						} else {
							$whereStmt .= ' AND ' . $queryCol . $queryOperator . '?';
						}
						
						array_push($queryValues, $queryVal);
						
						$i++;
					}
							
				}
				
				// Form query
				$queryStmt = 'SELECT t.id AS term_id,
					t.name,
					t.definition,
					t.term_type_id,
					t.parent_id,
					t.service_line_id
					FROM term t 
					' . $whereStmt . ' 
					ORDER BY ' . $orderStmt . '
					LIMIT ' . $apiLimit;
					
				// Run query
				$results = sqlQuery($queryStmt, $queryValues);
			}
			
			foreach($results as $r) {
				$resultObj = array();
				
				foreach($r as $key => $val) {
					if (!is_int($key)) {
						$resultObj[$key] = $val;
					}
				}
				
				array_push($apiResults['results'], $resultObj);
			}
			
			// Cache file
			if ($_ENABLE_CACHE === true) {
				$fp = fopen($cacheFile, 'w');			
				fwrite($fp, json_encode($apiResults));
				fclose($fp);
			}

		}
	
	} else {
				
		$apiResults['error'] = 'You screwed up';
		
	}

?>