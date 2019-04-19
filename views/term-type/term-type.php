<div class="row">
	<div class="title-header">
		<div class="col-sm-8">
			<h1>Terms</h1>
		</div>
		<div class="col-sm-4">
			<input class="form-control filter-search-input" type="text" placeholder="Search">
		</div>
	</div>

	<div class="col-sm-12">
		<?php
			if ($termTypeId == 'all') {
				
				echo '<ul class="list-unstyled">';
				
				foreach($termTypes as $tt) {
					echo '<li><a href="/term-type/' . $tt['id'] . '">' . $tt['name'] . '</a></li>';
				}
				
				echo '</ul>';
				
			} else {
				
				echo '<p class="breadcrumbs"><a href="/">Home</a> &nbsp; / &nbsp; <a href="/term-type/all">Term Types</a> &nbsp; / &nbsp; ' . $_PAGE_TITLE . '</p>';
				
				echo $termsHtml;
				
			}
		?>
	</div>
</div>