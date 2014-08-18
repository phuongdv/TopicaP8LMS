<?php $limits = array(
	0 => 3,
	1 => 5,
	2 => 10,
	3 => 15,
	4 => 20,
	5 => 25,
	6 => 30,
	7 => 50,
	8 => 100
);?>

<div id="paging_box">
	<div class="paginate">
		<!--
        <div id="limit_box">
			Hiển thị
			<select size="1" class="inputbox" id="<?php echo $pagination['limit_id']?>" name="<?php echo $pagination['limit_id']?>">
				<?php for($i = 0; $i < count($limits); $i++ ) {
					$selected = '';
					if($pagination['per_page'] == $limits[$i]) $selected = 'selected="selected"';
					echo '<option '.$selected.' value="'.$limits[$i].'">'.$limits[$i].'</option>';
				}?>					
			</select>
		</div>	
        -->
		<?php if(!empty($pagination['links'])): ?>	
		<?php echo $pagination['links'];?>		
		<?php endif; ?>
	</div>
</div>