<script type="text/javascript">
	var $ = jQuery.noConflict();
	$(document).ready(function() {
		$("#my_form").validate({
			rules: {
				week_number:{
					required: true,
					number: true
				},
				start_date: {
					required: true
				}
				//number: true
				//email:true
				//url:true
				//min-max
				//maxlength:200
			},
			messages: {
				week_number:{
					required: 'Không được để trống',
					number: 'Bạn phải nhập số'
				},
				start_date: {
					required: 'Không được để trống'
				}
			}
		});
		$("#start_date" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths:1,
			onClose: function( selectedDate ) {
				$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end_date" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths:1,
			onClose: function( selectedDate ) {
				$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
</script>

<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><span class="title">'.$title.'</span>','class="logo_icon"');?>
</div>
<?php echo form_open(uri_string(),array('name'=>'my_form','id'=>'my_form'));?>
<div class="table_content">
	<div class="content_box">
		<table class="table_form">
			<tr>
				<th colspan="2" class="title">
					<?php echo $title;?>
				</th>
			</tr>

			<tr>
				<th>Ngày bắt đầu:</th>
				<td><?php echo form_input('start_date',$data->start_date,'id="start_date" readonly=""');?> <span class="red">*</span></td>
			</tr>
			<tr>
				<th>Chọn số tuần học:</th>
				<td><?php echo form_input('week_number',$data->week_number,'id="week_number"');?> <span class="red">*</span></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<?php echo form_submit('save',$btn_title);?>
					<?php echo form_reset('reset','Reset');?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<span class="comment">( * Chú ý: Các tuần không được có ngày trùng nhau, không được gối lên nhau )</span>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="table_content">
	<?php $this->load->view('setting_calendar_table');?>
</div>
<?php echo form_close();?>