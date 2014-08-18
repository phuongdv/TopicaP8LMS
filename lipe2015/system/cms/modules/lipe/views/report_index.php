<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><h2>'.$title.'</h2>');?>
</div>
<?php require_once 'link_back_view.php'; ?>
<?php echo form_open(uri_string());?>
<div class="search_box">
	<div class="content_box">
		<div>
			<b>Danh sách khóa học:</b><br/>
			<span class="xanh2 bold">I</span>: Số bài post trong forum | <span class="xanh2 bold">P(x)</span>: Số bài luyện tập Học viên đã làm >=5, x: số bài luyện tập của tuần | <span class="red bold">E(x)</span>: Điểm BTVN, x: số bài tập của tuần | <span class="xanh2 bold">CC</span>: Điểm chuyên cần | BT: Điểm bài tập offline
			<br/><span class="red">VUI LÒNG CHỌN LỚP ĐỂ XEM KẾT QUẢ</span>
			<p></p>
		</div>
		<div>
			<?php echo form_input('username',$base_where['username'],'class="text_field_search_small" placeholder="Tên đăng nhập"');?>
			<?php echo form_input('email',$base_where['email'],'class="text_field_search_small" placeholder="Email"');?>
			<?php echo form_dropdown('topica_lop',$arr_lop,$base_where['topica_lop'],'class="search"');?>
			<?php echo form_dropdown('topica_nhom',$arr_nhom,$base_where['topica_nhom'],'class="search"');?>
			<?php echo form_submit('search','Tổng hợp báo cáo');?>
			<?php echo form_submit('export','Xuất ra file Excel');?>
			&nbsp;&nbsp;
			<?php echo anchor('/lipe/setting_calendar/course/'.$course->id,'Edit Calendar','target="_blank"');?> |
			<?php echo anchor('/lipe/setting_lipe/course/'.$course->id,'Edit Lipe','target="_blank"');?> |
			<?php echo anchor('/lipe/offline/course/'.$course->id,'Edit Offline','target="_blank"');?>
			<?php echo form_hidden('arr_lop',$lop);?>
			<?php echo form_hidden('arr_nhom',$nhom);?>
		</div>
	</div>
</div>
<div class="table_content">
	<div class="content_box">
		<div class="total_rows">
			<div class="left">Tổng số bản ghi là: <span><?php echo number_format($total_student_rows);?></span></div>
		</div>
	</div>
	<div id="filter_stage">
		<?php $this->load->view('report_table');?>
	</div>
</div>
<?php echo form_close();?>