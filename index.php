<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php'); ?>

<?php if ($_VIEW !== 'api') { ?>

	<!DOCTYPE html>
	<html lang="en-US">
	<head>
	<meta charset="UTF-8">
	<title>Taxonomy Tool</title>
	<?php

		foreach($_STYLESHEETS as $stylesheet) {
			echo '<link rel="stylesheet" href="' . $stylesheet . '">';
		}

	?>
	</head>
	<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Taxonomy Tool</a>
			</div>

			<div class="collapse navbar-collapse" id="main-nav">
				<ul class="nav navbar-nav">
					<li><a href="/">Search</a></li>
					<li><a href="/term/new">Add a Term</a></li>
					<li><a href="/access-point/new">Add an Access Point</a></li>
					<!--<li><a href="/find-care-content/all">Find Care Content</a></li>
					<li><a href="/import">Import Content</a></li>-->
				</ul>
			</div>
		</div>
	</nav>
	<div class="container main-container">
		<?php
			if (file_exists($_ROOT . '/views/' . $_VIEW . '/' . $_VIEW . '.php')) {
				require_once($_ROOT . '/views/' . $_VIEW . '/' . $_VIEW . '.php');
			}
		?>
	</div>
	<?php

		foreach($_SCRIPTS as $script) {
			echo '<script src="' . $script[0] . '" ' . $script[1] . '></script>';
		}

	?>
	</body>
	</html>
<?php } ?>