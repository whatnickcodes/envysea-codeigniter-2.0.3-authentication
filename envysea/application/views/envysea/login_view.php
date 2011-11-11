<?php echo heading('Login View', 1, 'class="page_header"'); ?>

<?php $login_form = array('class' => 'form'); ?>
<?php echo form_open('members/login', $login_form); ?>
<?php echo form_label('Username:', 'username'); ?>
<br>
<?php $username_input = array('name' => 'username', 'id' => 'username', 'value' => set_value('username')); ?>
<?php echo form_input($username_input); ?>
<br>
<?php echo form_label('Password:', 'password'); ?>
<br>
<?php $password_input = array('name' => 'password', 'id' => 'password', 'value' => set_value('password')); ?>
<?php echo form_password($password_input); ?>
<br>
<div class="form_button">
<?php echo form_submit('submit', 'Login!'); ?>
</div>
<?php echo form_close(); ?>