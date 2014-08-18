<div class="content_box">
	<div class="total_rows">
		<div class="left">Tổng số bản ghi là: <span><?php echo number_format($total_rows);?></span></div>
		<div class="right">
			<?php echo anchor('/lipe/setting_calendar/add/'.$course->id,'<img src="'.IMAGE_PATH.'add_24_24.png" alt="Thêm mới" title="Thêm mới" /><span>Thêm mới&nbsp;&nbsp;</span>','class="icon"');?>
			<?php echo anchor('/lipe/setting_calendar/add_auto/'.$course->id,'<img src="'.IMAGE_PATH.'add_24_24.png" alt="Thêm mới" title="Thêm mới tự động" /><span>Thêm mới tự động</span>','class="icon"');?>
		</div>
	</div>
</div>
<div class="content_box">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>ID</th>
			<th>Tuần</th>
			<th>Ngày bắt đầu</th>
			<th>Ngày kết thúc</th>
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
					<td align="center"><?php echo formatDate($row->start_date);?></td>
					<td align="center"><?php echo formatDate($row->end_date);?></td>
					<td><?php echo cutString(trim($row->comment),25);?></td>
					<td align="center"><?php echo anchor('/lipe/setting_calendar/edit/'.$row->id,'<img src="'.IMAGE_PATH.'edit.png" title="Sửa" alt="Sửa" />');?></td>
					<td align="center"><?php echo anchor('/lipe/setting_calendar/delete/'.$row->id.'/'.$course->id,'<img src="'.IMAGE_PATH.'btn_trash.gif" title="Xóa" alt="Xóa" />','class="confirm"');?></td>
				</tr>
			<?php
			}
		}
		?>
	</table>
</div>