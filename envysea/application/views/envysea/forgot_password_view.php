<?php echo heading('Forgot Password View', 1, 'class="page_header"'); ?>

<?php $forgot_password_form = array('class' => 'form'); ?>
<?php echo form_open('members/forgot/password', $forgot_password_form); ?>

<?php echo form_label('Username', 'username'); ?><br>
<?php $username_input = array('name' => 'username', 'id' => 'username', 'value' => set_value('username')); ?>
<?php echo form_input($username_input); ?><br>

<?php echo form_label('Email', 'email'); ?><br>
<?php $email_input = array('name' => 'email', 'id' => 'email', 'value' => set_value('email')); ?>
<?php echo form_input($email_input); ?><br>

<div class="form_button"><?php echo form_submit('submit', 'Submit!'); ?></div>

<?php echo form_close(); ?>