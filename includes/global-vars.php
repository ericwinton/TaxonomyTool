<?php

	$_ROOT = $_SERVER['DOCUMENT_ROOT'];
	
	$_PROTOCOL = 'http://';
	
	$_SERVER_NAME = $_SERVER['SERVER_NAME'];
	
	$_PAGE_TITLE = '';
	
	$_VIEW = '';
	
	$_PARAMS = [];
	
	$_URI = '';
	$_URI_ARRAY = [];
	
	date_default_timezone_set('America/Chicago');
	
	$_NOW = date("Y-m-d H:i:s");
	
	if (isset($_GET['uri'])) {
		$_URI = htmlspecialchars($_GET['uri']);
		$_URI_ARRAY = explode("/", trim($_URI, '/'));
	}
	
	$_STYLESHEETS = [
		'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css',
		'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
		'https://fonts.googleapis.com/css?family=Open+Sans',
		'/css/global.css'
	];
	
	$_SCRIPTS = [
		['https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js', false],
		['https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', false],
		['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false],
		['/js/global.js', false]
	];

	$_BREADCRUMBS = '';
	
	$_BACK_BTN = '<p><button class="btn btn-primary btn-sm" onclick="window.history.back()"><i class="glyphicon glyphicon-chevron-left"></i> Back</button></p>';
	
	$_ENABLE_CACHE = true;
	
	$_OPT_IN_TABLE = 'AccessPointOptin';
	$_ACCESS_POINT_TABLE = 'Facility_Accesspoint';
	$_TERM_TABLE = 'Term';
	$_TERM_TYPE_TABLE = 'TermType';
	$_TERM_RELATIONSHIP_TABLE = 'TermRelationship';
	$_ATTRIBUTE_TABLE = 'Attribute';
	$_ATTRUBUTE_TYPE_TABLE = 'AttributeType';
	
?>