<?php $this->load->view($module.'/includes/header_view'); ?>

<div id="content">
<?php echo validation_errors('<div class="error_message">', '</div>'); ?>
<?php echo $this->session->flashdata('message'); ?>
<?php if (!empty($message)) { echo $message; } ?>

<?php $this->load->view($module.'/'.$template); ?>
</div>

<?php $this->load->view($module.'/includes/footer_view'); ?>