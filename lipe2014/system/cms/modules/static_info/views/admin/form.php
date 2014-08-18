<section class="title">
	<h4><?php echo $title;?></h4>
</section>
<section class="item">
<?php echo form_open_multipart(uri_string()); ?>
<table class="tbl_form_wide">
	<tr>
		 <th>Tên:</th>
		 <td><?php echo form_input('name',$data->name);?></td>
	</tr>
	<tr>
		<th>Nội dung:</th>
		<td>
		<?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' =>$data->content, 'rows' =>5, 'class' =>"wysiwyg-advanced")); ?>
		</td>
	</tr>
	<tr>
		 <th>Trạng thái:</th>
		 <td><?php echo form_dropdown('active',selectActive(),$data->active);?></td>
	</tr>
	<tr>
		<th></th>
		<td>
			<?php echo form_submit('btn',$btn_title); ?>
			<?php echo form_reset('cancel','Reset'); ?>
		</td>
	</tr>
</table>
<?php echo form_close();?>
</section>
