<div class="content_box">
<?php
if(!empty($courses)){
	foreach($courses as $course){
?>
	<table class="table_list tbl_report" cellpadding="0" cellspacing="0"  >
		<tr>
			<th colspan="38" class="course_title"><?php echo $course->shortname;?></th>
		</tr>
		<tr>
			<?php
			$total_week=count($calendar_rows[$course->id]);
			if(!empty($calendar_rows[$course->id])&&$total_week)
				$tuan_tong=$calendar_rows[$course->id][$total_week-1];
			else
				$tuan_tong=null;

			unset($calendar_rows[$course->id][$total_week-1]);

			if(!empty($calendar_rows[$course->id])){
				foreach($calendar_rows[$course->id] as $calendar){
					?>
					<th colspan="4">
						<?php
						echo $calendar->week_name;
						//echo '<br/>'.$calendar->id;
						echo '<br/>('.formatDate($calendar->start_date).' -> '.formatDate($calendar->end_date).')';
						?>
					</th>
				<?php }
			}

			if(isset($tuan_tong)&&$tuan_tong){
				echo '<th colspan="7">';
				echo $tuan_tong->week_name;
				//echo '<br/>'.$tuan_tong->id;
				echo '<br/>('.formatDate($tuan_tong->start_date).' -> '.formatDate($tuan_tong->end_date).')';
				echo '</th>';
			}

			?>
		</tr>

		<tr>
			<?php
			if(!empty($calendar_rows[$course->id])){
				foreach($calendar_rows[$course->id] as $calendar){
					?>
					<th rowspan="2">I</th>
					<th rowspan="2">P(<?php echo count(getSettingLipe($setting_lipes_P[$course->id],'P',$calendar->id));?>)</th>
					<th rowspan="2">E(<?php echo count(getSettingLipe($setting_lipes_E[$course->id],'E',$calendar->id));?>)</th>
					<th rowspan="2">H</th>
				<?php }
			}
			?>
			<th rowspan="2">Forum Post </th>
			<th rowspan="2">H2472</th>
			<?php if($course->course_mode==1){?>
				<th rowspan="2">Offline</th>
			<?php }?>
				
			<th colspan="2">Số bài đã làm </th>
			<th colspan="2">Điểm</th>
		</tr>
		<tr>
			<th>P</th>
			<th>E</th>
			<th>CC</th>
			<!--<th>BT</th>-->
		</tr>
		<?php
		$sum_i=0;
		$sum_h=0;
		$quiz_p=array();
		$quiz_e=array();
		$vb_post_ids=null;
		$h2472_ids=null;
		?>
		<tr>
			<?php
			if(!empty($calendar_rows[$course->id])){
				foreach($calendar_rows[$course->id] as $calendar){
					?>
					<td class="center">
						<?php
						$setting_lipe_v=getSettingLipe($setting_lipes[$course->id],'V',$calendar->id);
						$v_active_ids=array();
						if(!empty($setting_lipe_v)){
							foreach($setting_lipe_v as $slv){
								$v_active_ids[]=$slv->active_id;
							}
						}
						if(!empty($v_active_ids)){
							$vbb=getVbbPost($vbb_posts[$course->id],$student->username,$v_active_ids,$calendar->start_date,$calendar->end_date);
							if(!empty($vbb)){
								$vb_ids=array();
								foreach($vbb as $v){
									$vb_ids[]=$v->postid;
									$vb_post_ids[]=$v->postid;
								}
								$data=base64_encode(json_encode($vb_ids));
								$sum_i+=count($vbb);
								echo anchor('/lipe/report/display_vbb_post/0?data='.$data,'<span>'.count($vbb).'</span>','onclick="showVbbPopUp(\''.$data.'\');return false;" title="Xem"');
								$c_vbb=count($vbb);
							}
						}else{
							$vbb=null;
						}
						?>
					</td>
					<td class="center">
						<?php
						if(!empty($p_active_ids[$course->id])){
							$p=getPractices($q169_attempts_p[$course->id],$p_active_ids[$course->id],$student->id,$calendar->start_date,$calendar->end_date);
							if(!empty($p)){
								$quiz_p=array_unique(array_merge($quiz_p,$p));
								$count_p=count($p);
								$data_p=array(
									'quiz'=>$p,
									'user_id'=>$student->id,
									'start_date'=>$calendar->start_date,
									'end_date'=>$calendar->end_date
								);
								$data_p=base64_encode(json_encode($data_p));
								echo anchor('/lipe/report/display_practice/0?data='.$data_p,'<span>'.$count_p.'</span>','onclick="showPopup(\'/lipe/report/display_practice\',\''.$data_p.'\');return false;" title="Xem"');
							}
						}else{
							$p=null;
						}
						?>
					</td>
					<td class="red center">
						<?php
						$setting_lipe_e=getSettingLipe($setting_lipes[$course->id],'E',$calendar->id);
						$e_active_ids=array();
						if(!empty($setting_lipe_e)){
							foreach($setting_lipe_e as $e_slp){
								$e_active_ids[]=$e_slp->active_id;
							}
						}
						if(!empty($e_active_ids)){
							$exam_e=getExamE($q169_attempts_e[$course->id],$e_active_ids,$student->id);
							if(!empty($exam_e)){
								$number_test=count($exam_e);
								$mark=0;
								$quiz_e_ids=array();
								foreach($exam_e as $e){
									$mark+=$e->sumgrade;
									$quiz_e[]=$e->quiz;
									$quiz_e_ids[]=$e->quiz;

								}
								$quiz_e=array_unique($quiz_e);

								if($number_test){
									$data_e=array(
										'quiz'=>$quiz_e_ids,
										'user_id'=>$student->id,
										'is_last_week'=>0
									);
									$data_e=base64_encode(json_encode($data_e));
									echo anchor('/lipe/report/display_exam/0?data='.$data_e,'<span>'.round($mark/$number_test,2).'</span>','onclick="showPopup(\'/lipe/report/display_exam\',\''.$data_e.'\');return false;" title="Xem"');
								}
							}
						}
						?>
					</td>
					<td class="right_border center">
						<?php
						$ans=getAnswers($answers[$course->id],$student->id,$calendar->start_date,$calendar->end_date);
						if(!empty($ans)){
							$a_ids=array();
							foreach($ans as $a){
								$a_ids[]=$a->id;
								$h2472_ids[]=$a->id;
							}
							$sum_h+=count($ans);
							$data_ans=base64_encode(json_encode($a_ids));
							echo anchor('/lipe/report/display_answer_post/0?data='.$data_ans,'<span>'.count($ans).'</span>','onclick="showAnwerPopUp(\''.$data_ans.'\');return false;" title="Xem"');
						}
						?>
					</td>
				<?php
				}
			}?>

			<?php if(isset($tuan_tong)&&$tuan_tong){?>
				<td class="xanh2 center" >
					<?php
					if($sum_i){
						$data_vb=base64_encode(json_encode($vb_post_ids));
						echo anchor('/lipe/report/display_vbb_post/0?data='.$data_vb,'<span>'.$sum_i.'</span>','onclick="showVbbPopUp(\''.$data_vb.'\');return false;" title="Xem"');
					}else{
						echo '0';
					}
					?>
				</td>
				<td class="center">
					<?php
					if($sum_h){
						$data_h2472=base64_encode(json_encode($h2472_ids));
						echo anchor('/lipe/report/display_answer_post/0?data='.$data_h2472,'<span>'.$sum_h.'</span>','onclick="showAnwerPopUp(\''.$data_h2472.'\');return false;" title="Xem"');
					}else{
						echo $sum_h;
					}
					?>
				</td>
				<?php if($course->course_mode==1){?>
				<td class="center"><?php echo $course->number_offline;?></td>
				<?php }?>
				<td class="red" align="center">
					<?php
						if(count($quiz_p)){
							$data_sum_p=array(
								'quiz'=>$quiz_p,
								'user_id'=>$student->id,
								'start_date'=>$tuan_tong->start_date,
								'end_date'=>$tuan_tong->end_date
							);
							$data_sum_p_encode=base64_encode(json_encode($data_sum_p));
							echo anchor('/lipe/report/display_practice/0?data='.$data_sum_p_encode,count($quiz_p),'onclick="showPopup(\'/lipe/report/display_practice\',\''.$data_sum_p_encode.'\');return false;" title="Xem"');
						}else{
							echo '0';
						}

					?>
				</td>
				<td class="red" align="center">
					<?php
					if(count($quiz_e)){
						$data_sum_e=array(
							'quiz'=>$quiz_e,
							'user_id'=>$student->id,
							'is_last_week'=>1
						);
						$data_sum_e=base64_encode(json_encode($data_sum_e));
						echo anchor('/lipe/report/display_exam/0?data='.$data_sum_e,count($quiz_e),'onclick="showPopup(\'/lipe/report/display_exam\',\''.$data_sum_e.'\');return false;" title="Xem"');
					}else{
						echo '0';
					}
					?>
				</td>
				<td align="center"><?php echo diemChuyenCan($course->number_offline,$sum_i,$sum_h,count($quiz_p),$course->course_mode);?></td>
				<!--<td align="center"><?php //echo $course->btvn_offline;?></td> -->
			<?php }?>
		</tr>
	</table>
<?php
	}
}
?>
</div>