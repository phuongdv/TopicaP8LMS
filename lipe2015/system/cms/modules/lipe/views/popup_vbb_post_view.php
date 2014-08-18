<div class="header_popup"><?php echo $title;?></div>
<div class="content_box content_popup">
	<table class="table_list" cellpadding="0" cellspacing="0" >
		<tr>
			<th>STT</th>
			<th>Thời gian</th>
			<th>ID bài Post</th>
			<th>ID Forum</th>
			<th>Tiêu đề bài post</th>
			<th>Xem chi tiết bài post</th>
		</tr>
		<?php
		if(!empty($rows)){
			$cnt=0;
			foreach($rows as $row){
				$cnt++;
				?>
				<tr>
					<td style="text-align:right;padding-right:2px;"><?php echo $cnt;?></td>
					<td align="center"><?php echo date('d-m-Y H:i:s',$row->dateline);?></td>
					<td><?php echo $row->postid;?></td>
					<td><?php echo $row->forumid;?></td>
					<td><?php echo $row->title?$row->title:'(Người post không nhập tiêu đề)';?></td>
					<td align="center"><a href="http://forum.tvu.topica.vn/showthread.php?t=<?php echo $row->threadid;?>&p=<?php echo $row->postid;?>#post<?php echo $row->postid;?>" target="_blank">Xem</a></td>
				</tr>
			<?php
			}
		}
		?>
	</table>
</div>