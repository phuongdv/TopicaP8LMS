<table class="table_list tbl_report" cellpadding="0" cellspacing="0" style="font-family: Tahoma; font-size: 9pt" >
	<tr>
		<td style="border: 1px dashed #cccccc;" colspan="6" align="center">
			Khóa học: <b><?php echo $course_name.'</b> Time: <b>'.date('d/m/Y',time());?></b>
			<br/>Tên lớp: <b><?php echo $base_where['topica_lop']?$base_where['topica_lop']:'';?></b>
			<br/>Chế độ xem: <b><?php echo getModeName($course_mode->mode);?></b>
			<br/><b>Thông tin sinh viên</b>
		</td>
		<?php
		if(!empty($calendar_rows))
			$tuan_tong=$calendar_rows[$calendar_number-1];
		else
			$tuan_tong=null;

		unset($calendar_rows[$calendar_number-1]);

		if(!empty($calendar_rows)){
			foreach($calendar_rows as $calendar){
				?>
				<th style="border: 1px dashed #cccccc;" colspan="4">
					<?php
					echo $calendar->week_name;
					echo '<br/>('.formatDate($calendar->start_date).' -> '.formatDate($calendar->end_date).')';
					?>
				</th>
			<?php }
		}
		if(isset($tuan_tong)&&$tuan_tong){
			echo '<th style="border: 1px dashed #cccccc;" colspan="7">';
			echo $tuan_tong->week_name;
			echo '<br/>('.formatDate($tuan_tong->start_date).' -> '.formatDate($tuan_tong->end_date).')';
			echo '</th>';
		}
		?>
	</tr>

	<tr>
		<th style="border: 1px dashed #cccccc;" rowspan="2">STT</th>
		<th style="border: 1px dashed #cccccc;" rowspan="2">Họ</th>
		<th style="border: 1px dashed #cccccc;" rowspan="2">Tên</th>
		<th style="border: 1px dashed #cccccc;" rowspan="2">Nhóm</th>
		<th style="border: 1px dashed #cccccc;" rowspan="2">Ngày sinh</th>
		<th style="border: 1px dashed #cccccc;" rowspan="2">Mã sinh viên</th>
		<?php
		if(!empty($calendar_rows)){
			foreach($calendar_rows as $calendar){
				?>
				<th style="border: 1px dashed #cccccc;" rowspan="2">I</th>
				<th style="border: 1px dashed #cccccc;" rowspan="2">P(<?php echo count(getSettingLipe($setting_lipes_P,'P',$calendar->id));?>)</th>
				<th style="border: 1px dashed #cccccc;" rowspan="2">E(<?php echo count(getSettingLipe($setting_lipes_E,'E',$calendar->id));?>)</th>
				<th style="border: 1px dashed #cccccc;" rowspan="2">H</th>
			<?php }
		}
		?>
		<th style="border: 1px dashed #cccccc;" rowspan="2">Forum Post </th>
		<th style="border: 1px dashed #cccccc;" rowspan="2">H2472</th>
		<?php if($course_mode->mode==1){?>
			<th style="border: 1px dashed #cccccc;" rowspan="2">Offline</th>
		<?php }?>
		<th style="border: 1px dashed #cccccc;" colspan="2">Số bài đã làm </th>
		<th style="border: 1px dashed #cccccc;" colspan="2">Điểm</th>
	</tr>
	<tr>
		<th style="border: 1px dashed #cccccc;">P</th>
		<th style="border: 1px dashed #cccccc;">E</th>
		<th style="border: 1px dashed #cccccc;">CC</th>
		<th style="border: 1px dashed #cccccc;">BT</th>
	</tr>
	<?php
	if(!empty($student_rows)){
		$so_thu_tu=0;
		foreach($student_rows as $row){
			$sum_i=0;
			$sum_h=0;
			$quiz_p=array();
			$quiz_e=array();
			$so_thu_tu++;
			$vb_post_ids=null;
			$h2472_ids=null;
			?>
			<tr>
				<td style="border: 1px dashed #cccccc;" height="30"><?php echo number_format($so_thu_tu);?></td>
				<td style="border: 1px dashed #cccccc;"><?php echo $row->lastname;?></td>
				<td style="border: 1px dashed #cccccc;"><?php echo $row->firstname;?></td>
				<td style="border: 1px dashed #cccccc;" ><?php	echo $row->topica_nhom;?></td>
				<td style="border: 1px dashed #cccccc;"><?php echo $row->topica_namsinh;?></td>
				<td style="border: 1px dashed #cccccc;"><span title="<?php echo $row->id; ?>"><?php echo $row->topica_msv;?></td>
				<?php
				if(!empty($calendar_rows)){
					foreach($calendar_rows as $calendar){
						?>
						<td style="border: 1px dashed #cccccc;color:#0000FF;" align="center">
							<?php
							$setting_lipe_v=getSettingLipe($setting_lipes,'V',$calendar->id);
							$v_active_ids=array();
							if(!empty($setting_lipe_v)){
								foreach($setting_lipe_v as $slv){
									$v_active_ids[]=$slv->active_id;
								}
							}
							if(!empty($v_active_ids)){
								$vbb=getVbbPost($vbb_posts,$row->username,$v_active_ids,$calendar->start_date,$calendar->end_date);
								if(!empty($vbb)){
									$vb_ids=array();
									foreach($vbb as $v){
										$vb_ids[]=$v->postid;
										$vb_post_ids[]=$v->postid;
									}
									//$data=base64_encode(json_encode($vb_ids));
									$sum_i+=count($vbb);
									//echo anchor('/lipe/report/display_vbb_post/0?data='.$data,'<span><b>'.count($vbb).'</b></span>','onclick="showVbbPopUp(\''.$data.'\');return false;" title="Kích chuột vào để xem chi tiết các bài đã đăng"');
									echo '<b>'.count($vbb).'</b>';
									$c_vbb=count($vbb);
								}
							}else{
								$vbb=null;
							}
							?>
						</td>
						<td style="border: 1px dashed #cccccc;" align="center">
							<?php
							if(!empty($p_active_ids)){
								$p=getPractices($q169_attempts_p,$p_active_ids,$row->id,$calendar->start_date,$calendar->end_date);
								if(!empty($p)){
									$quiz_p=array_unique(array_merge($quiz_p,$p));
									echo '<b>'.count($p).'</b>';
								}
							}else{
								$p=null;
							}
							?>
						</td>
						<td style="border: 1px dashed #cccccc;color: #ff0000;" align="center">
							<?php
							$setting_lipe_e=getSettingLipe($setting_lipes,'E',$calendar->id);
							$e_active_ids=array();
							if(!empty($setting_lipe_e)){
								foreach($setting_lipe_e as $e_slp){
									$e_active_ids[]=$e_slp->active_id;
								}
							}
							if(!empty($e_active_ids)){
								$exam_e=getExamE($q169_attempts_e,$e_active_ids,$row->id);
								if(!empty($exam_e)){
									$number_test=count($exam_e);
									$mark=0;
									foreach($exam_e as $e){
										$mark+=$e->sumgrade;
										$quiz_e[]=$e->quiz;

									}
									$quiz_e=array_unique($quiz_e);
									if($number_test){
										echo '<b>'.round($mark/$number_test,2).'</b>';
									}
								}
							}
							?>
						</td>
						<td style="border: 1px dashed #cccccc;" align="center">
							<?php
							$ans=getAnswers($answers,$row->id,$calendar->start_date,$calendar->end_date);
							if(!empty($ans)){
								$a_ids=array();
								foreach($ans as $a){
									$a_ids[]=$a->id;
									$h2472_ids[]=$a->id;
								}
								$sum_h+=count($ans);
								//$data_ans=base64_encode(json_encode($a_ids));
								//echo anchor('/lipe/report/display_answer_post/0?data='.$data_ans,'<span><b>'.count($ans).'</b></span>','onclick="showAnwerPopUp(\''.$data_ans.'\');return false;" title="Kích chuột vào để xem chi tiết danh sách các câu trả lời"');
								echo '<b>'.count($ans).'</b>';
							}
							?>
						</td>
					<?php
					}
				}
				if(isset($tuan_tong)&&$tuan_tong){
				?>
					<td style="border: 1px dashed #cccccc;color:#0000FF;" align="center">
						<?php
						if($sum_i){
							//$data_vb=base64_encode(json_encode($vb_post_ids));
							//echo anchor('/lipe/report/display_vbb_post/0?data='.$data_vb,'<span><b>'.$sum_i.'</b></span>','onclick="showVbbPopUp(\''.$data_vb.'\');return false;" title="Kích chuột vào để xem chi tiết các bài đã đăng"');
							echo '<b>'.$sum_i.'</b>';
						}else{
							echo '';
						}
						?>
					</td>
					<td style="border: 1px dashed #cccccc;" align="center">
						<?php
						if($sum_h){
							//$data_h2472=base64_encode(json_encode($h2472_ids));
							//echo anchor('/lipe/report/display_answer_post/0?data='.$data_h2472,'<span><b>'.$sum_h.'</b></span>','onclick="showAnwerPopUp(\''.$data_h2472.'\');return false;" title="Kích chuột vào để xem chi tiết"');
							echo '<b>'.$sum_h.'</b>';
						}else{
							echo $sum_h;
						}
						?>
					</td>
					<?php if($course_mode->mode==1){?>
						<td style="border: 1px dashed #cccccc;" align="center"><?php echo $row->number_offline;?></td>
					<?php }?>
					<td style="border: 1px dashed #cccccc;color: #ff0000;" align="center"><b><?php echo count($quiz_p);?></b></td>
					<td style="border: 1px dashed #cccccc;color: #ff0000;" align="center"><b><?php echo count($quiz_e);?></b></td>
					<td style="border: 1px dashed #cccccc;" align="center"><?php echo diemChuyenCan($row->number_offline,$sum_i,$sum_h,count($quiz_p),$row->course_mode);?></td>
					<td style="border: 1px dashed #cccccc;" align="center"><?php echo $row->btvn_offline;?></td>
				<?php }?>
			</tr>
		<?php
		}
	}
	?>
</table>