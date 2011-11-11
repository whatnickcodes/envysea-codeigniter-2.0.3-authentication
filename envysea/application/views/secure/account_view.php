<?php echo heading('Account Settings', 1, 'class="page_header"'); ?>

<div id="account_view">
	<ul class="nvc_selection">
		<li>
			<?php echo anchor('account/update',
				'<div class="nvc_item">
					<h2 class="nvc_link">Update your account</h2>
					<h3 class="nvc_tagline">Update info and profile</h3>
				</div>'); ?>
		</li>
		<li>
			<?php echo anchor('account/delete',
				'<div class="nvc_item">
					<h2 class="nvc_link">Delete your account</h2>
					<h3 class="nvc_tagline">This cannot be undone</h3>
				</div>'); ?>
		</li>
		<li>
			<?php echo anchor('secure/logout',
				'<div class="nvc_item">
					<h2 class="nvc_link">Log out of your account</h2>
					<h3 class="nvc_tagline">Unset and destroy session</h3>
				</div>'); ?>
		</li>
	</ul>
</div>