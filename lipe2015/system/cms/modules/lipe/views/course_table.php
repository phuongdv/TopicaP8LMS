<script type="text/javascript">
	var $ = jQuery.noConflict();
	$(document).ready(function() {
		$('.popup_setting_mode').bind('click', function() {
			$(".popup_setting_mode").colorbox({
				width: "700px",
				height: "auto",
				href:'<?php echo site_url("/lipe/setting_mode/course");?>/'+$(this).attr('id')+'/1'
			});
		});
	});
</script>
<div class="content_box">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>ID</th>
			<th>Tên khóa học</th>
			<th>Chế độ xem</th>
			<th>Lịch học</th>
			<th>Lipe</th>
			<th>Xem báo cáo</th>
			<th>Số buổi offline</th>
			<th>Dịch vụ SMS</th>
		</tr>
		<?php
		if(!empty($rows)){
			foreach($rows as $row){
		?>
			<tr>
				<td align="center"><?php echo $row->id;?></td>
				<td><?php echo $row->shortname;?></td>
				<td align="left"><?php echo anchor('/lipe/setting_mode/course/'.$row->id,$row->course_mode_id?getModeName($row->mode_id):'<span class="red">Chưa thiết lập</span>','class="popup_setting_mode" id="'.$row->id.'" ');?></td>
				<td align="center"><?php echo anchor('/lipe/setting_calendar/course/'.$row->id,'<img src="'.IMAGE_PATH.'calendar.gif" title="Thiết lập thời gian học" alt="Thiết lập thời gian học" />');?></td>
				<td align="center"><?php echo anchor('/lipe/setting_lipe/course/'.$row->id,'<img src="'.IMAGE_PATH.'setting_wheel.png" title="Thiết lập Lipe" alt="Thiết lập Lipe" />');?></td>
				<td align="center">
					<?php
					if($row->course_mode_id)
						echo anchor('/lipe/report/course/'.$row->id,'<img src="'.IMAGE_PATH.'report.png" title="Xem báo cáo" alt="Xem báo cáo" />');
					else{ ?>
						<a href="javascript:void(0)" onclick="alert('Course học chưa được Set Mode')"><img src="<?php echo IMAGE_PATH;?>report.png" /></a>
					<?php } ?>
				</td>
				<td align="center"><?php echo anchor('/lipe/offline/course/'.$row->id,'<img src="'.IMAGE_PATH.'offline.png" title="Số buổi offline" alt="Số buổi offline" />');?></td>
				<td align="center"><?php echo anchor('/lipe/sms/course/'.$row->id,'<img src="'.IMAGE_PATH.'sms.png" title="Gửi tin nhắn SMS" alt="Gửi tin nhắn SMS" />');?></td>
			</tr>
		<?php
			}
		}
		?>
	</table>
	<div class="paging_wrapper">
		<div class="pagination">
			<div>
				<?php $this->load->view('pagination'); ?>
			</div>
		</div>
	</div>
</div>