<?php echo heading('Admin Landing Page', 1, 'class="page_header"'); ?>

<div id="home_view">
	<ul class="nvc_selection">
		<li>
			<?php echo anchor('secure',
				'<div class="nvc_item">
					<h2 class="nvc_link">View the secure pages</h2>
					<h3 class="nvc_tagline">Admin\'s are superusers</h3>
				</div>'); ?>
		</li>	
		<li>
			<?php echo anchor('admin/panel',
				'<div class="nvc_item">
					<h2 class="nvc_link">Go to the admin panel</h2>
					<h3 class="nvc_tagline">Update, delete, or create users</h3>
				</div>'); ?>
		</li>
	</ul>
</div>