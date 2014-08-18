<div class="header_popup"><?php echo $title;?></div>
<div class="content_box content_popup">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>STT</th>
			<th>Tên bài luyện tập trắc nghiệp</th>
			<th>Mã đề</th>
			<th>Active ID</th>
			<th>Thời gian bắt đầu làm</th>
			<th>Thời gian hoàn thành</th>
			<th>Điểm</th>
			<th>Xem chi tiết</th>
		</tr>
		<?php
		if(!empty($rows)){
			$cnt=0;
			foreach($rows as $row){
				$cnt++;
				?>
				<tr>
					<td style="text-align:right;padding-right:2px;"><?php echo $cnt;?></td>
					<td><?php echo $row->quiz_name;?></td>
					<td><?php echo $row->ma_de;?></td>
					<td><?php echo $row->quiz_id;?></td>
					<td align="center"><?php echo date('d-m-Y H:i:s',strtotime($row->starttime));?></td>
					<td align="center"><?php echo date('d-m-Y H:i:s',strtotime($row->finishtime));?></td>
					<td><?php echo $row->sumgrade;?></td>
					<td align="center">
						<!--<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/mod/bt72/bt72.php?qid='.$row->quiz_id;?>" target="_blank">Xem</a>-->
						<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/mod/bt72/quiz_attempt_review.php?attemptid='.$row->attempt;?>" target="_blank">Xem</a>
					</td>
				</tr>
			<?php
			}
		}
		?>
	</table>
</div>