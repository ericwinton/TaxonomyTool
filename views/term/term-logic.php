<?php

	$termName = '';
	$termDefinition = '';

	if (!empty($_PARAMS['termId'])) {
		$termId = htmlspecialchars($_PARAMS['termId']);
	}
	
	if ($termId == 'all') {
		
		$termsHtml = groupTermsByServiceLine('all');
		
	} elseif ($termId != 'new'){

		// Get mapped term info
		$term = sqlQuery('SELECT TOP 1 t.id AS term_id,
			t.name AS term_name,
			t.definition,
			t.root_id,
			t.parent_id,
			t.term_type_id,
			tt.name AS term_type
			FROM ' . $_TERM_TABLE . ' t
			INNER JOIN ' . $_TERM_TYPE_TABLE . ' tt ON t.term_type_id = tt.id
			WHERE t.id = ?', array($termId));
		
		if (count($term) > 0) {
			$term = $term[0];
			$termName = $term['term_name'];
			$termType = $term['term_type'];
			$parentText = 'None';
			$parentName = 'None';
			$serviceLineText = 'None';
			$serviceLineName = 'None';
			
			if ($term['definition'] != '' && $term['definition'] != 'NA') {
				$termDefinition = $term['definition'];
			}
			
			$accessPoints = sqlQuery('SELECT * 
				FROM ' . $_ACCESS_POINT_TABLE . ' ap
				INNER JOIN ' . $_OPT_IN_TABLE . ' opt ON ap.access_point_id = opt.access_point_id
				WHERE opt.term_id = ? 
				ORDER BY ap.facility_name asc', array($termId));
			
			$childTerms = sqlQuery('SELECT t.id AS term_id,
				t.name AS term_name,
				tt.name AS term_type
				FROM ' . $_TERM_TABLE . ' t 
				INNER JOIN ' . $_TERM_TYPE_TABLE . ' tt ON t.term_type_id = tt.id
				WHERE t.parent_id = ? 
				ORDER BY t.name asc', array($termId));
			
			$relatedTerms1 = sqlQuery('SELECT * 
				FROM ' . $_TERM_RELATIONSHIP_TABLE . ' tr
				INNER JOIN term t ON (tr.term2_id = t.id)
				WHERE tr.term1_id = ? 
				ORDER BY t.name asc', array($termId));
				
			$relatedTerms2 = sqlQuery('SELECT * 
				FROM ' . $_TERM_RELATIONSHIP_TABLE . ' tr
				INNER JOIN ' . $_TERM_TABLE . ' t ON (tr.term1_id = t.id)
				WHERE tr.term2_id = ? 
				ORDER BY t.name asc', array($termId));
			
			$relatedTerms = array_merge($relatedTerms1, $relatedTerms2);
		
			if ($term['root_id'] !== 'NULL') {
				$serviceLine = sqlQuery('SELECT TOP 1 * FROM ' . $_TERM_TABLE . ' WHERE id = ?', array($term['root_id']));
				
				foreach($serviceLine as $sl) {
					$serviceLineName = $sl['name'];
					$serviceLineText = '<a href="/term/' . strtolower($sl['id']) . '">' . $serviceLineName . '</a>';
				}
			}
			
			if ($term['parent_id'] !== 'NULL') {
				$parent = sqlQuery('SELECT TOP 1 * FROM ' . $_TERM_TABLE . ' WHERE id = ?', array($term['parent_id']));
			
				foreach($parent as $p) {
					$parentName = $p['name'];
					$parentText = '<a href="/term/' . strtolower($p['id']) . '">' . $parentName . '</a>';
				}
			}
		}
		
	}

?>