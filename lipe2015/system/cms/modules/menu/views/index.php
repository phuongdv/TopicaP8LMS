<section class="title">
	<h4>Top Menu</h4>
</section>
<section class="item">
<?php echo form_open_multipart(uri_string());?>
<div class="fill_all_width">
   <div class="right"><a href="/admin/menu/add"><input type="button" value="Thêm mới" name="addnew" class="pointer" /></a> <input type="submit" value="Cập nhật" name="btn_update" class="pointer" /></div>
</div>
<div class="fill_all_width">
	<table>
	<tr>
		<th>ID</th>
		<th>Tiêu đề menu</th>
		<th>Thứ tự</th>
		<th>Đường link</th>
		<th>Trạng thái</th>
		<th><center>Sửa / Xóa</center></th>
	</tr>
	<?php
		if(isset($rows)&&$rows){
			$i=0; foreach($rows as $row){$i=1-$i;
	?>
	 <tr class="row_<?php echo $i;?>">
		<td><?php echo $row->id; ?>
			<?php echo form_hidden('arr_id[]',$row->id);?>
		</td>
		<td><?php echo form_input('arr_name[]',$row->name,'style="width:220px"'); ?></td>
		<td><?php echo form_input('arr_order_number[]',$row->order_number,'style="width:30px"'); ?></td>
		<td><?php echo form_input('arr_link[]',$row->link,'style="width:150px"'); ?></td>
		<td><?php echo form_dropdown('arr_active[]',selectActive(),$row->active); ?></td>
		<td><center>
			<?php echo anchor($index_uri.'/edit/' . $row->id,'<img src="'.IMAGE_ADMIN_PATH.'edit.png">', array('title'=>'Sửa')); ?>
			<?php echo anchor($index_uri.'/delete/' . $row->id,'<img src="'.IMAGE_ADMIN_PATH.'btn_trash.gif">', array('class'=>'confirm')); ?>
			</center>
		</td>
	</tr>
	<?php
			}
		}
	?>
	</table>
</div>    
<?php  echo form_close(); ?>
</section>