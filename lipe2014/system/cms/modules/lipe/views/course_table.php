<script type="text/javascript">
	var $ = jQuery.noConflict();
	$(document).ready(function() {
		$('.popup_setting_mode').bind('click', function() {
			$(".popup_setting_mode").colorbox({
				width: "700px",
				height: "auto",
				href:'<?php echo site_url("/lipe/setting_mode/course");?>/'+$(this).attr('id')+'/1'
			});
		});
	});
</script>
<div class="content_box">
	<table class="table_list" cellpadding="0" cellspacing="0" >
	
		
		<tr>
			<th>ID</th>
			<th><?php echo $TKH ?></th>
			<th><?php echo $CDX ?></th>
			<th style='width:50px'><?php echo $LH ?></th>
			<th >Lipe</th>
			<th><?php echo $XBC ?></th>
			<th><?php echo $SBO ?></th>
			<th><?php echo $DVS ?></th>
		</tr>
		<?php
		if(!empty($rows)){
			foreach($rows as $row){
		?>
			<tr>
				<td align="center"><?php echo $row->id;?></td>
				<td><?php echo $row->shortname;?></td>
				<td align="left"><?php echo anchor('/lipe/setting_mode/course/'.$row->id,$row->course_mode_id?getModeName($row->mode_id):'<span class="red">Unconfigured</span>','class="popup_setting_mode" id="'.$row->id.'" ');?></td>
				<td align="center"><?php echo anchor('/lipe/setting_calendar/course/'.$row->id,'<img src="'.IMAGE_PATH.'calendar.gif" title="Learning Schedule Configuration" alt="Learning Schedule Configuration" />');?></td>
				<td align="center"><?php echo anchor('/lipe/setting_lipe/course/'.$row->id,'<img src="'.IMAGE_PATH.'setting_wheel.png" title="LIPE configuration" alt="LIPE configuration" />');?></td>
				<td align="center">
					<?php
					if($row->course_mode_id)
						echo anchor('/lipe/report/course/'.$row->id,'<img src="'.IMAGE_PATH.'report.png" title="View Report" alt="View Report" />');
					else{ ?>
						<a href="javascript:void(0)" onclick="alert('The Mode of the Course has not been set')"><img src="<?php echo IMAGE_PATH;?>report.png" /></a>
					<?php } ?>
				</td>
				<td align="center"><?php echo anchor('/lipe/offline/course/'.$row->id,'<img src="'.IMAGE_PATH.'offline.png" title="Number of Offline sessions" alt="Number of Offline sessions" />');?></td>
				<td align="center"><?php echo anchor('/lipe/sms/course/'.$row->id,'<img src="'.IMAGE_PATH.'sms.png" title="Send an SMS message" alt="Send an SMS message" />');?></td>
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