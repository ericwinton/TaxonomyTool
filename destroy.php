<?php

	$cacheFiles = glob('cache/*');
	
	foreach($cacheFiles as $cacheFile) {
		if (is_file($cacheFile)) {
			unlink($cacheFile);
		}
	}
	
	echo 'Cache successfully deleted';

?>