<div class="header_popup"><?php echo $title;?></div>
<div class="content_box content_popup">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>STT</th>
			<th>Thời gian</th>
			<th>Tiêu đề</th>
			<th>Thread</th>
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
					<td align="center"><?php echo date('d-m-Y H:i:s',$row->time);?></td>
					<td><?php echo $row->answername;?></td>
					<td><?php echo $row->thread;?></td>
					<td align="center"><a href="http://elearning.tvu.topica.vn/h2472/?act=answers&do=detail&id=<?php echo $row->thread;?>" target="_blank">Xem</a></td>
				</tr>
			<?php
			}
		}
		?>
	</table>
</div>