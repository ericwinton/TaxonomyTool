<div class="row">

	<?php if ($termId == 'all') { ?>
	
		<div class="title-header">
			<div class="col-sm-8">
				<h1>Terms</h1>
			</div>
			<div class="col-sm-4">
				<input class="form-control filter-search-input" type="text" placeholder="Search">
			</div>
		</div>
	
		<div class="col-sm-12">
			<p class="breadcrumbs"><a href="/">Home</a> &nbsp; / &nbsp; Terms</p>
			<?php echo $termsHtml; ?>
		</div>
	
	<?php } elseif ($termId == 'new') { ?>
		
		<div class="col-sm-12">
		
			<div class="title-header"><h1>Add a Term</h1></div>
			
			<p class="breadcrumbs"><a href="/">Home</a> &nbsp; / &nbsp; New Term</p>
			
			<div class="row">
				<div class="col-sm-5">
				
					<form class="add-a-term-form" autocomplete="off" method="POST">
						<input type="hidden" name="service_line_id" id="term-service-line-id" value="">
						<input type="hidden" name="parent_id" id="term-parent-id" value="">
						<div class="form-group">
							<label>Term Name</label>
							<input class="form-control" type="text" name="term_name" autocomplete="off">
						</div>
						<div class="form-group">
							<label>Term Type</label>
							<select class="form-control" name="term_type_id">
								<option value="">Please select</option>
								<?php
									foreach($_TERM_TYPES as $tt) {
										echo '<option value="' . $tt['id'] . '">' . $tt['name'] . '</option>';
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Term Definition</label>
							<textarea class="form-control" name="term_definition" rows="5"></textarea>
						</div>
						<div class="form-group">
							<label>Service Line</label>
							<input class="form-control" type="text" name="term_service_line" data-suggest="true" data-auto-submit="false" data-follow-link="false" data-term-type="1" autocomplete="off">
						</div>
						<div class="form-group">
							<label>Parent</label>
							<input class="form-control" type="text" name="term_parent" data-suggest="true" data-auto-submit="false" data-follow-link="false" data-is-parent="true" autocomplete="off">
						</div>
						<div class="form-group">
							<button class="btn btn-primary btn-block">Submit</button>
						</div>
					</form>
				
				</div>
			</div>
			
		</div>
		
	<?php } else { ?>
	
		<div class="col-sm-8">
		
			<div class="title-header clearfix"><h1 class="pull-left"><?php echo $termName; ?></h1> <a class="pull-right btn btn-default" data-toggle="modal" data-target="#modal-edit-term" href="#"><i class="glyphicon glyphicon-pencil"></i> Edit Term</a></div>
			
			<p class="breadcrumbs"><a href="/">Home</a> &nbsp; / &nbsp; <a href="/term/all">Terms</a> &nbsp; / &nbsp; <?php echo $termName; ?></p>
			
			<?php
				if ($termDefinition != '') {
					echo '<h2>Definition</h2><p class="definition"> ' . $termDefinition . '</p>';
				}
			?>
			
			<div class="row">
				<div class="col-md-4">
					<h2>Child Terms</h2>
						
					<!--<div class="form-group">
						<input aria-label="Assign a new child term" class="form-control" type="text" data-suggest="true" data-suggest-type="blank-parent" data-auto-submit="false" data-follow-link="false" placeholder="Assign a new child term">
					</div>-->
					
					<p><a href="#" class="groups-only">Show groups only</a></p>
					
					<ul class="list-unstyled block-list delete-list" data-mapped-id="<?php echo $termId; ?>">
					
						<?php
						
							if (count($childTerms) > 0) {
								foreach($childTerms as $ct) {
									$groupClass = '';
									
									if ($ct['term_type'] === 'Group') {
										$groupClass = 'group';
									}
									
									echo '<li class="' . $groupClass . '" data-id="' . $ct['term_id'] . '"><a class="delete-item" href="#"><i class="glyphicon glyphicon-remove"></i></a><a href="/term/' . strtolower($ct['term_id']) . '">' . $ct['term_name'] . '</a></li>';
								}
							} else {
								echo '<li>No results</li>';
							}
							
						?>
				
					</ul>
				</div>
				<div class="col-md-4">
					<h2>Related Terms</h2>
						
					<!--<div class="form-group">
						<input aria-label="Assign a new child term" class="form-control" type="text" data-suggest="true" data-suggest-type="blank-parent" data-auto-submit="false" data-follow-link="false" placeholder="Assign a new child term">
					</div>-->
					
					<ul class="list-unstyled block-list delete-list" data-mapped-id="<?php echo $termId; ?>" data-type="term_relationship">
					
						<?php
						
							if (count($relatedTerms) > 0) {
								foreach($relatedTerms as $rt) {
									echo '<li data-id="' . $rt['id'] . '"><a class="delete-item" href="#"><i class="glyphicon glyphicon-remove"></i></a><a href="/term/' . strtolower($rt['id']) . '">' . $rt['name'] . '</a></li>';
								}
							} else {
								echo '<li>No results</li>';
							}
							
						?>
				
					</ul>
				</div>
				<div class="col-md-4">
					<h2>Locations Offered</h2>
					
					<div class="form-group">
						<input aria-label="Relate an Access Point" data-mapped-id="<?php echo $termId; ?>" class="form-control" type="text" data-suggest="true" data-suggest-type="access-points" data-auto-submit="false" data-follow-link="false" placeholder="Relate an access point">
					</div>
					
					<ul class="list-unstyled block-list delete-list" data-mapped-id="<?php echo $termId; ?>" data-type="access_point_opt_in">
					
						<?php
						
							if (count($accessPoints) > 0) {
								foreach($accessPoints as $ap) {
									echo '<li data-id="' . $ap['access_point_id'] . '"><a class="delete-item"  href="#"><i class="glyphicon glyphicon-remove"></i></a><a href="/access-point/' . strtolower($ap['access_point_id']) . '">' . $ap['facility_name'] . '</a></li>';
								}
							} else {
								echo '<li>No results</li>';
							}
						
						?>
					
					</ul>
				</div>
			</div>
			
		</div>
		<div class="col-sm-4">
			<div class="card">
				<div class="sidebar-card">
					<h3>Service Line</h3><p><?php echo $serviceLineText; ?></p>
				</div>
				<div class="sidebar-card">
					<h3>Parent</h3><p><?php echo $parentText; ?></p>
				</div>
				<div class="sidebar-card">
					<h3>Term Type</h3><p><a href="/term-type/<?php echo strtolower($term['term_type_id']); ?>"><?php echo $term['term_type']; ?></a></p>
				</div>
			</div>
		</div>
		
	<?php } ?>
</div>

<div id="modal-edit-term" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Term</h4>
			</div>
			<div class="modal-body">
				<form class="edit-term-form row" autocomplete="off">
					<input type="hidden" class="term-id" value="<?php echo $termId; ?>">
					<input type="hidden" class="term-parent-id" value="<?php echo $term['parent_id']; ?>">
					<input type="hidden" class="term-service-line-id" value="<?php echo $term['root_id']; ?>">
					<div class="form-group col-sm-6">
						<label>Term Name</label>
						<input class="form-control term-name" type="text" value="<?php echo $termName; ?>" autocomplete="off">
					</div>
					<div class="form-group col-sm-6">
						<label>Term Type</label>
						<select class="form-control term-type-id">
							<option value="">Please select</option>
							<?php
								foreach($_TERM_TYPES as $tt) {
									$selected = '';
									
									if ($tt['name'] == $termType) {
										$selected = ' selected';
									}
									
									echo '<option value="' . $tt['id'] . '"' . $selected . '>' . $tt['name'] . '</option>';
								}
							?>
						</select>
					</div>
					<div class="form-group col-sm-12">
						<label>Definition</label>
						<textarea class="form-control term-description" rows="5"><?php echo $termDefinition; ?></textarea>
					</div>
					<div class="form-group col-sm-6">
						<label>Service Line</label>
						<input aria-label="Change service line" 
								class="form-control term-parent" 
								type="text" 
								data-suggest="true" 
								data-suggest-type="service-lines" 
								data-auto-submit="false" 
								data-follow-link="false" 
								data-mapped-id="<?php echo $termId; ?>" 
								value="<?php echo $serviceLineName; ?>" 
								data-term-type="1" 
								placeholder="Change service line">
					</div>
					<div class="form-group col-sm-6">
						<label>Parent</label>
						<input aria-label="Change parent" 
								class="form-control term-service-line" 
								type="text" 
								data-suggest="true" 
								data-auto-submit="false" 
								data-follow-link="false" 
								data-mapped-id="<?php echo $termId; ?>" 
								value="<?php echo $parentName; ?>" 
								placeholder="Change parent">
					</div>
					<div class="form-group text-right col-sm-12">
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>