<?php echo heading('Update A User', 1, 'class="page_header"'); ?>

<?php $update_form = array('class' => 'form'); ?>
<?php echo form_open('admin/panel/update', $update_form); ?>

<?php foreach($users as $r) : $users_array[$r->user_id] = $r->username; endforeach; ?>
<?php echo form_dropdown('user_id', $users_array, set_value('user_id')); ?><br>

<?php echo form_label('Username', 'username'); ?><br>
<?php $username_input = array('name' => 'username', 'id' => 'username', 'value' => set_value('username')); ?>
<?php echo form_input($username_input); ?><br>

<?php echo form_label('Email', 'email'); ?><br>
<?php $email_input = array('name' => 'email', 'id' => 'email', 'value' => set_value('email')); ?>
<?php echo form_input($email_input); ?><br>

<?php echo form_label('Password', 'password'); ?><br>
<?php $password_input = array('name' => 'password', 'id' => 'password', 'value' => set_value('password')); ?>
<?php echo form_password($password_input); ?><br>

<?php echo form_label('Confirm Password', 'confirm_password'); ?><br>
<?php $confirm_password_input = array('name' => 'confirm_password', 'id' => 'confirm_password', 'value' => set_value('confirm_password')); ?>
<?php echo form_password($confirm_password_input); ?><br>

<?php echo form_label('First Name', 'first_name'); ?><br>
<?php $first_name_input = array('name' => 'first_name', 'id' => 'first_name', 'value' => set_value('first_name')); ?>
<?php echo form_input($first_name_input); ?><br>

<?php echo form_label('Last Name', 'last_name'); ?><br>
<?php $last_name_input = array('name' => 'last_name', 'id' => 'last_name', 'value' => set_value('last_name')); ?>
<?php echo form_input($last_name_input); ?><br>

<div class="form_button"><?php echo form_submit('submit', 'Update User'); ?></div>
<?php echo form_close(); ?>