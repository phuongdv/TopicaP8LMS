<?php echo form_open(uri_string(),array('name'=>'my_form','id'=>'my_form'));?>
	<table class="table_form">
		<tr>
			<th colspan="2" class="title">
				<?php echo $title;?>
			</th>
		</tr>
		<tr>
			<th>Tên khóa học :</th>
			<td><?php echo $course->shortname;?></td>
		</tr>
		<tr>
			<th>Mode :</th>
			<td><?php echo form_dropdown('mode',$modes,$row->mode);?> <span class="red">*</span></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<?php echo form_submit('save',$btn_title);?>
				<?php echo form_reset('reset','Reset');?>
			</td>
		</tr>
	</table>
<?php echo form_close();?>