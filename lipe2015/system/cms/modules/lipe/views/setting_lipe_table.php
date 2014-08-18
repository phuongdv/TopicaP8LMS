<div class="content_box">
	<div class="total_rows">
		<div class="left">Tổng số bản ghi là: <span><?php echo number_format($total_rows);?></span></div>
		<div class="right">
			<?php echo anchor('/lipe/setting_lipe/add/'.$course->id,'<img src="'.IMAGE_PATH.'add_24_24.png" alt="Thêm mới" title="Thêm mới" /><span>Thêm mới</span>','class="icon"');?>
		</div>
	</div>
</div>
<div class="content_box">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>ID</th>
			<th>Calendar</th>
			<th>Style</th>
			<th>ActiveID</th>
			<th>Lipe Type</th>
			<th>Ghi chú</th>
			<th>Sửa</th>
			<th>Xóa</th>
		</tr>
		<?php
		if(!empty($rows)){
			foreach($rows as $row){
				?>
				<tr>
					<td align="center"><?php echo $row->id;?></td>
					<td align="center"><?php echo $row->week_name;?></td>
					<td align="center"><?php echo $row->style;?></td>
					<td align="center"><?php echo $row->active_id;?></td>
					<td align="center"><?php echo $row->lipe_type;?></td>
					<td><?php echo cutString(trim($row->comment),25);?></td>
					<td align="center"><?php echo anchor('/lipe/setting_lipe/edit/'.$row->id,'<img src="'.IMAGE_PATH.'edit.png" title="Sửa" alt="Sửa" />');?></td>
					<td align="center"><?php echo anchor('/lipe/setting_lipe/delete/'.$row->id.'/'.$row->c_id,'<img src="'.IMAGE_PATH.'btn_trash.gif" title="Xóa" alt="Xóa" />','class="confirm"');?></td>
				</tr>
			<?php
			}
		}
		?>
	</table>
</div>