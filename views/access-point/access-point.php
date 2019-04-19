<div class="row">
	<div class="title-header">
		<div class="col-sm-8">
			<h1><?php echo $_PAGE_TITLE; ?></h1>
		</div>
		<?php if ($accessPointId !== 'new') { ?>
			<div class="col-sm-4">
				<input class="form-control filter-search-input" type="text" placeholder="Search">
			</div>
		<?php } ?>
	</div>
	<div class="col-sm-12">
		<?php
			if ($accessPointId === 'new' || $accessPointId === 'all') {
				echo '<p class="breadcrumbs"><a href="/">Home</a> &nbsp; / &nbsp; ' . $_PAGE_TITLE . '</p>';
			} else {
				echo '<p class="breadcrumbs"><a href="/">Home</a> &nbsp; / &nbsp; <a href="/access-point/all">Access Points</a> &nbsp; / &nbsp; ' . $_PAGE_TITLE . '</p>';
			}
		?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php if ($accessPointId === 'new') { ?>

			<div class="row">
				<div class="col-sm-5">
					<h3>Single Upload</h3>
					<form class="add-access-point-form" autocomplete="off" method="POST">
						<div class="form-group">
							<label>Access Point ID</label>
							<input class="form-control" type="text" name="access_point_id" autocomplete="off">
						</div>
						<div class="form-group">
							<label>Facility Name</label>
							<input class="form-control" type="text" name="facility_name" autocomplete="off">
						</div>
						<div class="form-group">
							<button class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
				<div class="col-sm-6 col-sm-offset-1">
					<h3>Batch Upload</h3>
					<form class="access-point-batch-form" autocomplete="off" method="POST">
						<div class="form-group">
							<label>Copy and paste all cells from excel spreadsheet</label>
							<p>Example:<br />
							0C6A36BA-10E4-438F-BA86-0D5B68A2BB15&nbsp;&nbsp;&nbsp;&nbsp;Tristar Health<br />
							CF628202-33F3-49CF-8828-CB2D93C69675&nbsp;&nbsp;&nbsp;&nbsp;Centennial Medical Center<br />
							DF215E10-8BD4-4401-B2DC-99BB03135F2E&nbsp;&nbsp;&nbsp;&nbsp;Southern Hills Medical Center</p>
							<textarea rows="5" class="form-control" name="access_point_batch" autocomplete="off"></textarea>
						</div>
						<div class="form-group">
							<button class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>

		<?php } elseif ($accessPointId == 'all') {
				echo '<ul class="list-unstyled">';
				
				foreach($accessPoints as $ap) {
					echo '<li><a href="/access-point/' . strtolower($ap['access_point_id']) . '">' . $ap['facility_name'] . '</a></li>';
				}
				
				echo '</ul>';
			} else {
				echo $termsHtml;
			}
		?>
	</div>
</div>