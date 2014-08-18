<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><span class="title">'.$title.'</span>','class="logo_icon"');?>
</div>
<?php require_once 'link_back_view.php'; ?>
<?php echo form_open(uri_string());?>
<div class="table_content">
	<?php $this->load->view('setting_calendar_table');?>
</div>
<?php echo form_close();?>