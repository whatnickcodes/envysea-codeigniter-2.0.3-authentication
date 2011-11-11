<?php echo heading('Make or remove an admin', 1, 'class="page_header"'); ?>

<?php $roles_form = array('class' => 'form'); ?>
<?php echo form_open('admin/panel/roles', $roles_form); ?>

<?php foreach($users as $r) : $users_array[$r->user_id] = $r->username; endforeach; ?>
<?php echo form_dropdown('user_id', $users_array, set_value('user_id')); ?><br>

<?php echo form_label('Make Admin?', 'is_admin'); ?><br>
<?php $is_admin_options = array('' => '', 'no' => 'No', 'yes' => 'Yes'); ?>
<?php echo form_dropdown('is_admin', $is_admin_options, set_value('is_admin', '')); ?><br>

<div class="form_button"><?php echo form_submit('submit', 'Change Role'); ?></div>
<?php echo form_close(); ?>