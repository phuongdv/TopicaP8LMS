<div class="content_header">
	<?php echo '<img src="'.IMAGE_PATH.'user.gif"><h1>'.$title.'</h1>';?>
</div>
<?php echo form_open(uri_string());?>
<div class="search_box">
	<div class="content_box">
		<div>
			<b>* Chú ý:</b> Hệ thống Lipe cá nhân v2014 chỉ dành cho các course có ngày bắt đầu >= 27/04/2014.<br/>
			<b>Danh sách khóa học:</b><br/>
			<span class="xanh2 bold">I</span>: Số bài post trong forum | <span class="xanh2 bold">P(x)</span>: Số bài luyện tập Học viên đã làm >=5, x: số bài luyện tập của tuần | <span class="red bold">E(x)</span>: Điểm BTVN, x: số bài tập của tuần | <span class="xanh2 bold">CC</span>: Điểm chuyên cần | BT: Điểm bài tập offline
		</div>
	</div>
</div>
<div class="table_content">
	<div class="content_box">
		<div class="total_rows">
			<div class="left">Tổng số khóa học là : <span><?php echo count($courses);?></span></div>
		</div>
	</div>
	<div id="filter_stage">
		<?php $this->load->view('personal_report_table');?>
	</div>
</div>
<?php echo form_close();?>