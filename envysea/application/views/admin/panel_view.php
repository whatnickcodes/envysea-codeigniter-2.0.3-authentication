<?php echo heading('Admin Panel', 1, 'class="page_header"'); ?>

<ul class="nvc_selection">
	<li>
		<?php echo anchor('admin/panel/create',
			'<div class="nvc_item">
				<h2 class="nvc_link">Register a new user account</h2>
				<h3 class="nvc_tagline">Register | Join | Sign Up</h3>
			</div>'); ?>
	</li>	
	<li>
		<?php echo anchor('admin/panel/update',
			'<div class="nvc_item">
				<h2 class="nvc_link">Update a user account</h2>
				<h3 class="nvc_tagline">Update a user\'s information</h3>
			</div>'); ?>
	</li>
	<li>
		<?php echo anchor('admin/panel/delete',
			'<div class="nvc_item">
				<h2 class="nvc_link">Delete a user account</h2>
				<h3 class="nvc_tagline">Delete someone\'s account</h3>
			</div>'); ?>
	</li>
	<li>
		<?php echo anchor('admin/panel/roles',
			'<div class="nvc_item">
				<h2 class="nvc_link">Change a user\'s role</h2>
				<h3 class="nvc_tagline">Make or remove an admin</h3>
			</div>'); ?>
	</li>
</ul>
