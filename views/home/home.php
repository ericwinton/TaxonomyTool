<div class="row">
	<div class="col-sm-12 title-header">
		<h1>Search</h1>
	</div>
	<div class="col-sm-4">
		<div class="card">
			<h2>By Access Point</h2>
			
			<ul class="list-unstyled block-list">
			
				<?php
				
					foreach($accessPoints as $accessPoint) {
						echo '<li><a href="/access-point/' . strtolower($accessPoint['access_point_id']) . '">' . $accessPoint['facility_name'] . '</a></li>';
					}
				
				?>
			
			</ul>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="card">
			<div class="clearfix">
				<h2 class="pull-left">By Term Name</h2>
				<a class="pull-right" href="/term/all">View All</a>
			</div>
			<form method="POST" onsubmit="return false" autocomplete="off">
				<div class="form-group">
					<label>Term Type</label>
					<select class="form-control" id="term-type-filter">
						<option value="">All</option>
						<?php
							foreach($termTypes as $termType) {
								echo '<option value="' . strtolower($termType['id']) . '">' . $termType['name'] . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Access Point</label>
					<select class="form-control" id="access-point-filter">
						<option value="">All</option>
						<?php
							foreach($accessPoints as $accessPoint) {
								echo '<option value="' . strtolower($accessPoint['access_point_id']) . '">' . $accessPoint['facility_name'] . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Term Name</label>
					<input id="term-search-input" class="form-control" type="text" data-suggest="true" data-auto-submit="false" data-follow-link="true" data-is-parent="false" autocomplete="off">
				</div>
			</form>
		</div>
		<div class="card">
			<div class="clearfix">
				<h2 class="pull-left">By Term ID</h2>
			</div>
			<form class="term-id-search-form" method="POST" onsubmit="return false" autocomplete="off">
				<div class="form-group">
					<label>Term ID</label>
					<input id="term-id-search-input" class="form-control" type="text" autocomplete="off">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="card">
			<h2>By Term Type</h2>
			<ul class="list-unstyled block-list">
				<?php
					
					foreach($termTypes as $term) {
						echo '<li><a href="/term-type/' . $term['id'] . '">' . $term['name'] . '</a></li>';
					}
				
				?>
			</ul>
		</div>
	</div>
</div>