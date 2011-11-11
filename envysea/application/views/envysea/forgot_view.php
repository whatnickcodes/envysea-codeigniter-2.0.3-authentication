<?php echo heading('Recover Forgotten Credentials', 1, 'class="page_header"'); ?>

<div id="forgot_view">
	<ul class="nvc_selection">
		<li>
			<?php echo anchor('members/forgot/username',
				'<div class="nvc_item">
					<h2 class="nvc_link">Forget your username?</h2>
					<h3 class="nvc_tagline">Recover forgotten username</h3>
				</div>'); ?>
		</li>
		<li>
			<?php echo anchor('members/forgot/password',
				'<div class="nvc_item">
					<h2 class="nvc_link">Forget your password?</h2>
					<h3 class="nvc_tagline">Recover forgotten password</h3>
				</div>'); ?>
		</li>
	</ul>
</div>