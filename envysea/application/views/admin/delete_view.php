<?php echo heading('Delete a User', 1, 'class="page_header"'); ?>

<?php $delete_form = array('class' => 'form'); ?>
<?php echo form_open('admin/panel/delete', $delete_form); ?>

<?php foreach($users as $r) : $users_array[$r->user_id] = $r->username; endforeach; ?>
<?php echo form_dropdown('user_id', $users_array, set_value('user_id')); ?><br>

<?php echo form_label('Password', 'password'); ?><br>
<?php $password_input = array('name' => 'password', 'id' => 'password', 'value' => set_value('password')); ?>
<?php echo form_password($password_input); ?><br>

<div class="form_button"><?php echo form_submit('submit', 'Delete User'); ?></div>

<?php echo form_close(); ?>