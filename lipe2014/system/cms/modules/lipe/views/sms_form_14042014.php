<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function(){
	$('textarea[name="sms_content"]').keyup(function(){
		$('#number_character').text($('textarea[name="sms_content"]').val().length);
	});
});

function checkAll(chk) {
	$('.table_list').find("input:checkbox").attr('checked', chk.checked);
}

function checkForm(){
	$("#my_form").validate({
		rules: {
			sms_content:{
				required: true,
				maxlength:160
			}
			//number: true
			//email:true
			//url:true
			//min-max
		},
		messages: {
			sms_content:{
				required: 'Bạn phải nhập nội dung tin nhắn',
				maxlength: 'Độ dài không được vượt quá 160 ký tự'
			}
		}
	});
}
</script>

<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><span class="title">Gửi tin nhắn SMS: '.$course->shortname.'</span>','class="logo_icon"');?>
</div>
<?php require_once 'link_back_view.php'; ?>
<?php echo form_open(uri_string(),array('name'=>'my_form','id'=>'my_form'));?>

<div class="content_box pdtop">
	<div class="left_sms">
		<?php echo form_input('username',$base_where['username'],'class="text_field_search_small" placeholder="Tên đăng nhập"');?>
		<?php //echo form_input('email',$base_where['email'],'class="text_field_search_small" placeholder="Email"');?>
		<?php echo form_dropdown('topica_lop',$arr_lop,$base_where['topica_lop'],'class="search"');?>
		<?php echo form_dropdown('topica_nhom',$arr_nhom,$base_where['topica_nhom'],'class="search"');?>
		<?php echo form_dropdown('quiz_id',$quiz_options,$base_where['quiz_id'],'class="search"');?>
		<?php echo form_submit('search','Lọc dữ liệu');?>
		<?php echo form_hidden('arr_lop',$lop);?>
		<?php echo form_hidden('arr_nhom',$nhom);?>

		<div class="total_rows">
			<div class="left">Tổng số bản ghi là: <span><?php echo number_format($total_student_rows);?></span></div>
		</div>
		<table class="table_list sms_table" cellpadding="0" cellspacing="0">
			<tr>
				<th><input type="checkbox" onclick="checkAll(this)" name="check_all" /></th>
				<th>STT</th>
				<th>Họ</th>
				<th>Tên</th>
				<th>Nhóm/Lớp</th>
				<th>Ngày sinh</th>
				<th>Mã sinh viên</th>
				<th>Số điện thoại</th>
				<th>Trạng thái SMS</th>
			</tr>
			<?php
			if(!empty($student_rows)){
				$stt=0;
				foreach($student_rows as $row){
					$stt++;
			?>
			<tr>
				<td align="center" class="first"><input type="checkbox" name="student_ids[]" value="<?php echo $row->id; ?>"></td>
				<td><?php echo $stt;?></td>
				<td><?php echo $row->lastname;?></td>
				<td><?php echo $row->firstname;?></td>
				<td><?php	echo $row->topica_nhom.'/'.$row->topica_lop;?></td>
				<td><?php echo $row->topica_namsinh;?></td>
				<td><span title="<?php echo $row->id; ?>"><?php echo $row->topica_msv;?></td>
				<td><?php echo $row->topica_dienthoai?$row->topica_dienthoai:'<span class="red">(Chưa cập nhật)</span>';?></td>
				<td><?php getHistorySms($row->id);?></td>
			</tr>
			<?php
				}
			}
			?>
			<tr>
				<td align="center" class="first"><input type="checkbox" name="student_ids[]" value="<?php echo $user_data['user_id'];?>"></td>
				<td colspan="8" class="red">Thêm số điện thoại của bạn để kiểm tra ( <?php echo $user_data['user_phone']; ?> )</td>
			</tr>
		</table>
	</div>
	<div class="right_sms">
		<table class="table_form_mini">
			<tr>
				<td>
					<b class="mau_dac_trung">Nội dung tin nhắn :</b>
					<br/><br/><textarea name="sms_content" class="sms_content" id="sms_content"><?php echo $this->input->post('sms_content')?$this->input->post('sms_content'):null;?></textarea>
					<br/><span id="number_character">0</span> ký tự
				</td>
			</tr>
			<tr>
				<td>
					<?php echo form_submit('send','Gửi tin nhắn','onclick="checkForm()"');?>
					<?php echo form_reset('reset','Reset');?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<span class="comment">( * Chú ý : Nội dung tin nhắn là tiếng Việt không dấu và không được vượt quá 160 ký tự )</span>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php echo form_close();?>