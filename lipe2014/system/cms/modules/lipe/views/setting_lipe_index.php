<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><span class="title">'.$title.'</span>','class="logo_icon"');?>
</div>
<?php require_once 'link_back_view.php'; ?>
<?php echo form_open(uri_string());?>
<div class="search_box">
	<div class="content_box">
		<?php echo form_dropdown('calendar_id',$calendar_options,$base_where['calendar_id'],'class="search"');?>
		<?php echo form_dropdown('lipe_type',$lipe_type,$base_where['lipe_type'],'class="search"');?>
		<?php echo form_dropdown('style',$style,$base_where['style'],'class="search"');?>
		<?php echo form_dropdown('active_id',$active_options,$base_where['active_id'],'class="search"');?>
		<?php echo form_input('active_id_forum',$base_where['active_id_forum'],'class="text_field_search_small" placeholder="Active Id Forum"');?>
		<?php echo form_submit('search','search');?>
	</div>
</div>
<div class="table_content">
	<?php $this->load->view('setting_lipe_table');?>
</div>
<?php echo form_close();?>