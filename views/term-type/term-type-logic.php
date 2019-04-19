<?php

	if (!empty($_PARAMS['termTypeId'])) {
		$termTypeId = htmlspecialchars($_PARAMS['termTypeId']);
		$termTypes = sqlQuery('SELECT * FROM ' . $_TERM_TYPE_TABLE . ' ORDER BY name asc', array());
		
		if ($termTypeId !== 'all') {
			$termsHtml = groupTermsByServiceLine($termTypeId);
			
			foreach ($termTypes as $termType) {
				if ($termType['id'] === $termTypeId) {
					$_PAGE_TITLE = $termType['name'];
					break;
				}
			}
		}
	}

?>