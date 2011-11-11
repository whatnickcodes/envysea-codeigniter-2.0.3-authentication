<?php echo heading('Forgot Username', 1, 'class="page_header"'); ?>

<?php $forgot_username_form = array('class' => 'form'); ?>
<?php echo form_open('members/forgot/username', $forgot_username_form); ?>

<?php echo form_label('Email', 'email'); ?><br>
<?php $email_input = array('name' => 'email', 'id' => 'email', 'value' => set_value('email')); ?>
<?php echo form_input($email_input); ?><br>

<div class="form_button"><?php echo form_submit('submit', 'Send Now!'); ?></div>

<?php echo form_close(); ?>