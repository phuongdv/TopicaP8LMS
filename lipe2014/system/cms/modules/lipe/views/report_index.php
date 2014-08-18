<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><h2>'.$title.'</h2>');?>
</div>
<?php require_once 'link_back_view.php'; ?>
<?php echo form_open(uri_string());?>
<div class="search_box">
	<div class="content_box">
		<div>
			<b>Danh sách khóa học:</b><br/>
			<span class="xanh2 bold">I</span>: Number of post(s) in forum | <span class="xanh2 bold">P(x)</span>: Number of practical assignments done by learner: >=5, x: Number of practical assignments of the week | <span class="red bold">E(x)</span>: Score of home assignment, x: Number of home assignments | <span class="xanh2 bold">CC</span>: Attendance score | BT: Offline assignments score
			<br/><span class="red">Please choose a class to view the results</span>
			<p></p>
		</div>
		<div>
			<?php echo form_input('username',$base_where['username'],'class="text_field_search_small" placeholder="User Name"');?>
			<?php echo form_input('email',$base_where['email'],'class="text_field_search_small" placeholder="Email"');?>
			<?php echo form_dropdown('topica_lop',$arr_lop,$base_where['topica_lop'],'class="search"');?>
			<?php echo form_dropdown('topica_nhom',$arr_nhom,$base_where['topica_nhom'],'class="search"');?>
			<?php echo form_submit('search','Create Report');?>
			<?php echo form_submit('export','Export to excel');?>
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
			<div class="left">Total amount of records: <span><?php echo number_format($total_student_rows);?></span></div>
		</div>
	</div>
	<div id="filter_stage">
		<?php $this->load->view('report_table');?>
	</div>
</div>
<?php echo form_close();?>