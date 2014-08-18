<div class="content_box">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>STT</th>
			<th>Họ và tên đệm</th>
			<th>Tên học viên</th>
			<th>Lớp/ (Nhóm)</th>
			<th>Ngày sinh</th>
			<th>Mã sinh viên</th>
			<?php
			if(!empty($calendar_rows)){
				$stt_calendar=0;
				foreach($calendar_rows as $calendar){
					$stt_calendar++;
					if($stt_calendar==$calendar_number){
			?>
						<th class="padding_0">
							<?php
								echo $calendar->week_name;
								echo '<br/>('.formatDate($calendar->start_date).' đến '.formatDate($calendar->end_date).')';
							?>
							<div class="wrapper_box_diem last_header_box_diem">
								<table class="tbl_header" cellpadding="0" cellspacing="0">
									<tr>
										<th rowspan="2" class="w50">Forum Post</th>
										<th rowspan="2" class="w50">H2472</th>
										<th colspan="2">Số bài đã làm</th>
										<th colspan="2" class="last_th">Điểm</th>
									</tr>
									<tr>
										<td class="w30" style="padding:0">P</td>
										<td class="w30" style="padding:0">E</td>
										<td class="w30" style="padding:0">CC</td>
										<td class="w30 last_th">BT</td>
									</tr>
								</table>
							</div>
						</th>
			<?php
					}else{
			?>
					<th class="padding_0">
						<?php
							echo $calendar->week_name;
							echo '<br/>('.formatDate($calendar->start_date).' đến '.formatDate($calendar->end_date).')';
							//echo '<br/>'.$calendar->id;
						?>
						<div class="wrapper_box_diem">
							<div class="box_diem_header">I</div>
							<div class="box_diem_header">P(<?php echo count(getSettingLipe($setting_lipes_P,'P',$calendar->id));?>)</div>
							<div class="box_diem_header">E(<?php echo count(getSettingLipe($setting_lipes_E,'E',$calendar->id));?>)</div>
							<div class="box_diem_header last_box">H</div>
						</div>
					</th>
			<?php }
				}
			}?>
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
				?>
				<tr>
					<td class="spd"><?php echo number_format($so_thu_tu);?></td>
					<td class="spd"><?php echo $row->lastname;?></td>
					<td class="spd"><?php echo $row->firstname;?></td>
					<td class="spd" align="center" >
						<?php
							echo $row->topica_lop;
							echo '<br/>('.$row->topica_nhom.')';
						?>
					</td>
					<td class="spd" align="right"><?php echo $row->topica_namsinh;?></td>
					<td align="center" class="right_border spd"><span title="<?php echo $row->id; ?>"><?php echo $row->topica_msv;?></span></td>
					<?php
					if(!empty($calendar_rows)){
						$stt_calendar_in_tr=0;
						foreach($calendar_rows as $calendar){
							$stt_calendar_in_tr++;
							if($stt_calendar_in_tr==$calendar_number){
					?>
								<td class="padding_0 right_border">
									<div class="box_diem_td_cell w51 xanh2"><span><?php echo $sum_i;?></span></div>
									<div class="box_diem_td_cell w52"><span><?php echo $sum_h;?></span></div>
									<div class="box_diem_td_cell w30d red"><span><?php echo count($quiz_p);?></span></div>
									<div class="box_diem_td_cell w31d red"><span><?php echo count($quiz_e);?></span></div>
									<div class="box_diem_td_cell w31d"><span><?php echo diemChuyenCan($row->number_offline,$sum_i,$sum_h,count($quiz_p),$row->course_mode);?></span></div>
									<div class="box_diem_td_cell w30d br0"><span><?php echo $row->btvn_offline;?></span></div>
								</td>
					<?php
							}else{
					?>
								<td class="padding_0 right_border">
									<div class="box_diem_td">
										<div class="box_diem_td_cell">
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
													foreach($vbb as $v)
														$vb_ids[]=$v->postid;
													$data=base64_encode(json_encode($vb_ids));
													$sum_i+=count($vbb);
													echo anchor('/lipe/report/display_vbb_post/0?data='.$data,'<span>'.count($vbb).'</span>','onclick="showVbbPopUp(\''.$data.'\');return false;" title="Kích chuột vào để xem chi tiết các bài đã đăng"');
													$c_vbb=count($vbb);
												}
											}else{
												$vbb=null;
											}
											?>
										</div>
										<div class="box_diem_td_cell">
											<span>
											<?php
												$active_ids=array();
												if(!empty($setting_lipes_P2)){
													foreach($setting_lipes_P2 as $slp){
														$active_ids[]=$slp->active_id;
													}
												}
												if(!empty($active_ids)){
													$p=getPractices($q169_attempts_p,$active_ids,$row->id,$calendar->start_date,$calendar->end_date);
													if(!empty($p)){
														$quiz_p=array_unique(array_merge($quiz_p,$p));
														echo count($p);
													}
												}else{
													$p=null;
												}
											?>
											</span>
										</div>
										<div class="box_diem_td_cell red">
											<span>
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
															echo round($mark/$number_test,2);
														}
													}
												}
											?>
										</span>
										</div>
										<div class="box_diem_td_cell last_box">
											<?php
												$ans=getAnswers($answers,$row->id,$calendar->start_date,$calendar->end_date);
												if(!empty($ans)){
													$a_ids=array();
													foreach($ans as $a){
														$a_ids[]=$a->id;
													}
													$sum_h+=count($ans);
													$data_ans=base64_encode(json_encode($a_ids));
													echo anchor('/lipe/report/display_answer_post/0?data='.$data_ans,'<span>'.count($ans).'</span>','onclick="showAnwerPopUp(\''.$data_ans.'\');return false;" title="Kích chuột vào để xem chi tiết danh sách các câu trả lời"');
												}
											?>
										</div>
									</div>
								</td>
					<?php
							}
						}
					}?>
				</tr>
			<?php
			}
		}
		?>
	</table>
</div>