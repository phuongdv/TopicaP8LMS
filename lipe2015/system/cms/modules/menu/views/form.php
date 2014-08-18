<section class="title">
	<h4><?php echo $title;?></h4>
</section>
<section class="item">
<?php echo form_open_multipart(uri_string());?>
<table class="tbl_form_normal">
	<tr>
		 <th>Tiêu đề menu:</th>
		 <td><?php echo form_input('name',$data->name);?></td>
	</tr>
	<tr>
		 <th>Link:</th>
		 <td><?php echo form_input('link',$data->link);?></td>
	</tr>
	 <tr>
		 <th>Thứ tự hiển thị:</th>
		 <td><?php echo form_input('order_number',$data->order_number,'class="small_textfield"');?> <span class="note">(Mặc định sẽ tự tăng)</span></td>
	</tr>
	<tr>
	<tr>
		 <th>Trạng thái:</th>
		 <td><?php echo form_dropdown('active',selectActive(),1);?></td>
	</tr>
	<tr>
		<th></th>
		<td>
			<?php echo form_submit('btn',$btn_title); ?>
			<?php echo form_reset('cancel','Reset'); ?>
		</td>
	</tr>
</table>
<?php echo form_close(); ?>
</section>