<?php

	function route($route, $view) {
		
		global $_URI, $_URI_ARRAY, $_PARAMS, $_VIEW;
		
		$routeMatch = true;
		
		if ($_VIEW == '') {

			if ($route == '/') {
				$routeArray = [];
			} else {
				$routeArray = explode('/', trim($route, '/'));
			}
			
			// Make sure requested route and uri have the same number of folders
			if (count($routeArray) == count($_URI_ARRAY)) {
				
				$f = 0;
				
				// For each folder in the requested route, make sure it matches the corresponding folder in the uri
				// Mapped parameters ex: {userId} will be skipped
				foreach($routeArray as $routeFolder) {
					if (strpos($routeFolder, "{") == false && strpos($routeFolder, "}") == false) {
						if ($routeFolder != $_URI_ARRAY[$f]) {
							$routeMatch = false;
						}
					} else {
						$param = str_replace("{", "", $routeFolder);
						$param = str_replace("}", "", $param);
						
						$_PARAMS[$param] = $_URI_ARRAY[$f];
					}
					
					$f++;
				}
				
				if ($routeMatch == true) {
					$_VIEW = $view;
				}
			}
		}
		
	}
	
	//if (isset($_SESSION['userId'])) {
	
		route('/', 'home');
		route('/import', 'import');
		route('/access-point/{accessPointId}', 'access-point');
		route('/term/{termId}', 'term');
		route('/term-type/{termTypeId}', 'term-type');
		route('/find-care-content/{fcContentId}', 'find-care-content');
		
		if ($_VIEW !== '' && $_VIEW !== 'api') {
			
			// Add stylesheet
			if (file_exists($_ROOT . '/views/' . $_VIEW . '/css/' . $_VIEW . '.css')) {
				array_push($_STYLESHEETS, '/views/' . $_VIEW . '/css/' . $_VIEW . '.css');
			}
			
			// Add scripts
			if (file_exists($_ROOT . '/views/' . $_VIEW . '/js/' . $_VIEW . '.js')) {
				array_push($_SCRIPTS, ['/views/' . $_VIEW . '/js/' . $_VIEW . '.js', true]);
			}
			
			// Load view logic
			if (file_exists($_ROOT . '/views/' . $_VIEW . '/' . $_VIEW . '-logic.php')) {
				require_once($_ROOT . '/views/' . $_VIEW . '/' . $_VIEW . '-logic.php');
			}
		}
	
	/*} else {
		
		// Add stylesheet
		if (file_exists($_ROOT . '/views/login/css/login.css')) {
			array_push($_STYLESHEETS, '/fp5/views/login/css/login.css');
		}
		
		// Add scripts
		if (file_exists($_ROOT . '/views/login/js/login.js')) {
			array_push($_SCRIPTS, ['/fp5/views/login/js/login.js', true]);
		}
		
		// Load view logic
		if (file_exists($_ROOT . '/views/login/login-logic.php')) {
			require($_ROOT . '/views/login/login-logic.php');
		}
		
		// Redirect to login page if user is not logged in
		$_VIEW = 'login';
		
	}*/

?>