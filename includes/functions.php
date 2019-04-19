<?php

	function sqlQuery($sql, $valuesArray) {
		global $pdo;
		
		$queryResults = [];
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute($valuesArray);
		
		if (strpos($sql, "SELECT") !== false) {
			while ($row = $stmt->fetch()) {
				$queryResults[] = $row;
			}
			
			return $queryResults;
		}
	}
	
	function getGUID() {
		if (function_exists('com_create_guid')) {
			return com_create_guid();
		} else {
			mt_srand((double)microtime()*10000);
			
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			
			$uuid = substr($charid, 0, 8).$hyphen
				.substr($charid, 8, 4).$hyphen
				.substr($charid,12, 4).$hyphen
				.substr($charid,16, 4).$hyphen
				.substr($charid,20,12);
				
			return $uuid;
		}
	}
	
	function groupTermsByServiceLine($contentId = '') {
		
		global $_ROOT, $_VIEW, $_BACK_BTN, $_ENABLE_CACHE, $_PAGE_TITLE, $_TERM_TABLE, $_OPT_IN_TABLE, $_ACCESS_POINT_TABLE, $_TERM_TYPE_TABLE;
		
		$termsHtml = '';
		$cacheDir = $_ROOT . '/cache/';
		
		$cacheFile = $cacheDir . $_VIEW . '-' . $contentId . '-cache.php';
		$termLinkPath = '/term/';
		
		if (file_exists($cacheFile) && $_ENABLE_CACHE == true) {
			
			// Retrieve html from cache
			$termsHtml = file_get_contents($cacheFile);
			
		} else {

			if ($_VIEW == 'access-point') {
				$terms = sqlQuery('SELECT t.id AS term_id,
					t.name AS term_name,
					t.root_id,
					ap.facility_name
					FROM ' . $_ACCESS_POINT_TABLE . ' ap
					INNER JOIN ' . $_OPT_IN_TABLE . ' opt ON (ap.access_point_id = opt.access_point_id)
					INNER JOIN ' . $_TERM_TABLE . ' t ON (opt.term_id = t.id)
					WHERE ap.access_point_id = ? 
					ORDER BY t.name asc', array($contentId));
			} elseif ($_VIEW == 'term-type') {
				$terms = sqlQuery('SELECT t.id AS term_id,
					t.name AS term_name,
					t.root_id,
					tt.name AS term_type_name
					FROM ' . $_TERM_TABLE . ' t 
					INNER JOIN ' . $_TERM_TYPE_TABLE . ' tt ON t.term_type_id = tt.id
					WHERE tt.id = ? 
					ORDER BY t.name asc', array($contentId));
			} elseif ($_VIEW == 'find-care-content') {
				$terms = sqlQuery('SELECT find_care_id AS term_id, 
					title AS term_name,
					root_id 
					FROM find_care_content 
					ORDER BY title asc', array());
					
				$termLinkPath = '/find-care-content/';
			} elseif ($contentId == 'all') {
				$terms = sqlQuery('SELECT t.id AS term_id,
					t.name AS term_name,
					t.root_id
					FROM ' . $_TERM_TABLE . ' t ORDER BY name asc', array());
			}
			
			if (count($terms) > 0) {
				
				if ($_VIEW == 'access-point') {
					$_PAGE_TITLE = $terms[0]['facility_name'];
				} elseif ($_VIEW == 'term-type') {
					$_PAGE_TITLE = $terms[0]['term_type_name'];
				}
				
				$serviceLines = [];
				
				foreach($terms as $term) {
					
					$termClass = '';
					
					if (substr($term['term_name'], -1) == ' ') {
						$termClass .= 'trailing-space ';
					}
					
					if (substr($term['term_name'], 0, 1) == ' ') {
						$termClass .= 'leading-space';
					}
					
					$termServiceLine = 'AAA - Service Lines';
					
					$termObj = array(
						'term_name' => $term['term_name'],
						'term_id' => $term['term_id'],
						'term_class' => $termClass
					);
					
					if ($term['root_id'] != NULL) {
						$serviceLine = sqlQuery('SELECT name FROM ' . $_TERM_TABLE . ' WHERE id = ?', array($term['root_id']));
						
						if (count($serviceLine) > 0) {
							$termServiceLine = $serviceLine[0]['name'];
						}
					}
					
					if (isset($serviceLines[$termServiceLine])) {
						array_push($serviceLines[$termServiceLine], $termObj);
					} else {
						$serviceLines[$termServiceLine] = array($termObj);
					}

				}
				
				// Sort
				ksort($serviceLines);
				
				// Build html
				foreach($serviceLines as $key => $value) {
					
					$termsHtml .= '<div class="service-line">
						<h2>' . str_replace("AAA - ", "", $key) . '</h2>
						<ul class="list-unstyled column-count-4 filterable-list">';
					
					foreach($serviceLines[$key] as $term) {
						$termsHtml .= '<li><a class="' . $term['term_class'] . '" href="' . $termLinkPath . strtolower($term['term_id']) . '">' . $term['term_name'] . '</a></li>';
					}
					
					$termsHtml .= '</ul>
						</div>';
				}
				
				if ($_ENABLE_CACHE === true) {
					
					if (!file_exists($cacheDir)) {
						mkdir($cacheDir, 0755);
					}
					
					// Write html to cache
					$fp = fopen($cacheFile, 'w');
					fwrite($fp, $termsHtml);
					fclose($fp);
				}
			}
		}
		
		return $termsHtml;
	}
	
	$_TERM_TYPES = sqlQuery('SELECT * FROM ' . $_TERM_TYPE_TABLE . ' ORDER BY name asc', array());

?>