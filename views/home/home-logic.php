<?php

	$accessPoints = [];

	$accessPoints = sqlQuery('SELECT * FROM ' . $_ACCESS_POINT_TABLE . ' ORDER BY facility_name asc', array());
	
	$termTypes = sqlQuery('SELECT * FROM ' . $_TERM_TYPE_TABLE . ' ORDER BY name asc', array());

?>