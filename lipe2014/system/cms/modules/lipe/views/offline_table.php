<script type="text/javascript">
	var j = jQuery.noConflict();
	j(document).ready(function() {
		j('.update_one').click(function(){
			doUpdate(this.getAttribute('id'));
		});
	});

	/**
	 * Cập nhật dữ liệu
	 * @author CaoPV
	 * @param offlineId
	 * @returns {boolean}
	 */
	function doUpdate(user_id){
		var offlineCourseId = '<?php echo $course->id;?>';
		var offlineNumber = j("[id=offlineNumber_" + user_id+"]").val();
		var offlineBtvn = j("[id=offlineBtvn_" + user_id+"]").val();
		j.post('<?php echo site_url('/lipe/offline/updateInfo');?>/' + user_id + '/'+offlineCourseId,{offline_number:offlineNumber,offline_btvn:offlineBtvn}, function(data){
			if(!isNaN(data) && data > 0){
				if(data==1)
					alert('Cập nhật thành công \n\n - Mã học viên	: '+user_id+'\n - Số buổi offline 	: '+offlineNumber+'\n - Điểm			: '+offlineBtvn);
				else
					alert('Thêm mới thành công \n\n - Mã học viên	: '+user_id+'\n - Số buổi offline 	: '+offlineNumber+'\n - Điểm			: '+offlineBtvn);
			}else{
				alert('Có lỗi xảy ra trong quá trình cập nhật cho học viên mã : '+user_id);
			}
		});
		return false;
	}
</script>
<div class="content_box">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th><?php echo $MHV?></th>
			<th><?php echo $THV?></th>
			<th><?php echo $HTD?></th>
			<th>Username</th>
			<th>Email</th>
			<th><?php echo $LOP?></th>
			<th><?php echo $NHOM?></th>
			<th><?php echo $SBO?></th>
			<th><?php echo $DIEM?></th>
			<th><?php echo $CN?></th>
		</tr>
		<?php
		if(!empty($rows)){
			foreach($rows as $row){
				?>
				<tr>
					<td align="center">
						<?php echo number_format($row->id);?>
						<?php
							echo form_hidden('arr_offline_id[]',$row->offline_id);
							echo form_hidden('arr_user_id[]',$row->id);
						?>
					</td>
					<td><?php echo $row->lastname;?></td>
					<td><?php echo $row->firstname;?></td>
					<td><?php echo $row->username;?></td>
					<td><?php echo $row->email;?></td>
					<td><?php echo $row->topica_lop;?></td>
					<td><?php echo $row->topica_nhom;?></td>
					<td align="center"><?php echo form_dropdown('arr_number[]',$arr_offline_number,$row->number,'id="offlineNumber_'.$row->id.'"');?></td>
					<td align="center"><?php echo form_dropdown('arr_btvn[]',$arr_diem_btvn,$row->btvn,'id="offlineBtvn_'.$row->id.'"');?></td>
					<td align="center"><?php echo form_button('update_one','update','class="update_one" id="'.$row->id.'" title="Update Code '.number_format($row->id).'" ');?></td>
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