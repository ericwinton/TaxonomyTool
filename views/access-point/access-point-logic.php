<?php

	$_PAGE_TITLE = 'Access Points';

	if (!empty($_PARAMS['accessPointId'])) {
		$accessPointId = htmlspecialchars($_PARAMS['accessPointId']);
		
		if ($accessPointId === 'new') {
			$_PAGE_TITLE = 'New Access Point';
		} elseif ($accessPointId !== 'all') {
			$termsHtml = groupTermsByServiceLine($accessPointId);
			$accessPoint = sqlQuery('SELECT facility_name FROM ' . $_ACCESS_POINT_TABLE . ' WHERE access_point_id = ?', array($accessPointId));
			
			if (count($accessPoint) > 0) {
				$_PAGE_TITLE = $accessPoint[0]['facility_name'];
			}
		}
	}

?>