<?php echo heading('Delete Account', 1, 'class="page_header"'); ?>

<?php $delete_form = array('class' => 'form'); ?>
<?php echo form_open('account/delete', $delete_form); ?>

<?php echo form_label('Password', 'password'); ?><br>
<?php $password_input = array('name' => 'password', 'id' => 'password', 'value' => set_value('password')); ?>
<?php echo form_password($password_input); ?><br>

<div class="form_button"><?php echo form_submit('submit', 'Delete Account'); ?></div>
<?php echo form_close(); ?>