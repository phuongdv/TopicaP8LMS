<script type="text/javascript">
var lipe_type = jQuery.parseJSON('<?php echo $lipe_type; ?>');
var $ = jQuery.noConflict();
$(document).ready(function() {
	$('#style').change(updateLipeType);
});
function updateLipeType()
{
	style = jQuery('#style').val();
	if(style=='forum'){
		jQuery('#active_id_on_page').hide();
		jQuery('#active_id_off_page').show();
	}else{
		jQuery('#active_id_off_page').hide();
		jQuery('#active_id_on_page').show();
	}
	lipe_type_in_style = lipe_type[style];
	jQuery('#lipe_type option').remove()
	if(typeof lipe_type_in_style !== 'undefined'){
		for(var i=0;i<lipe_type_in_style.length;i++) {
			var type = lipe_type_in_style[i];
			jQuery("#lipe_type").append('<option value='+type.id+'>'+type.name+'</option>');
		}
	}
}
</script>

<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><span class="title">'.$title.'</span>','class="logo_icon"');?>
</div>
<?php echo form_open(uri_string(),array('name'=>'my_form','id'=>'my_form'));?>
<div class="table_content">
	<div class="content_box">
		<table class="table_form">
			<tr>
				<th colspan="2" class="title">
					<?php echo $title;?>
				</th>
			</tr>
			<?php if($data->id){ ?>
			<tr>
				<th>ID :</th>
				<td><?php echo number_format($data->id);?></td>
			</tr>
			<?php } ?>
			<tr>
				<th>Style :</th>
				<td><?php echo form_dropdown('style',$style,$data->style,'class="small_select_option" id="style"');?> <span class="red">*</span></td>
			</tr>
			<tr>
				<th>Lipe Type :</th>
				<td><?php echo form_dropdown('lipe_type',$lipe_type_options,$data->lipe_type,'class="small_select_option" id="lipe_type"');?> <span class="red">*</span></td>
			</tr>
			<tr>
				<th>Active ID :</th>
				<td>
					<div id="active_id_on_page" <?php if($data->style=='forum'){ echo 'class="none"';} ?> >
						<?php echo form_dropdown('active_id',$active_options,$data->active_id,'class="small_select_option"');?><span class="red">*</span>
					</div>
					<div id="active_id_off_page" <?php if($data->style=='exam'){ echo 'class="none"';} ?> >
						<?php echo form_input('active_id_vbb',$data->active_id,'class="active_id"');?><span class="red">*</span>
					</div>
				</td>
			</tr>
			<tr>
				<th>Tuần :</th>
				<td><?php echo form_dropdown('calendar_id',$calendar_options,$data->calendar_id,'class="small_select_option"'); ?> <span class="red">*</span></td>
			</tr>
			<tr>
				<th>Ghi chú :</th>
				<td><textarea name="comment"><?php echo $data->comment;?></textarea></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<?php echo form_submit('save',$btn_title);?>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="table_content">
	<?php $this->load->view('setting_lipe_table');?>
</div>
<?php echo form_close();?>