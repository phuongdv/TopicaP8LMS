
<script type="text/javascript">
	var j = jQuery.noConflict();
	/**
	 * Hàm post dữ liệu dùng cho phân trang
	 * @param start
	 * @author CaoPV vancao.vn@gmail.com
	 */
	function navigate(start) {
		j( 'html, body' ).animate( {
			scrollTop:120
		},500);
		<?php if(!empty($base_where)){
			$url='';
			foreach($base_where as $key=>$value){
				if($value)
				$url.='&'.$key.'='.urlencode($value);
			}
		 ?>
		history.pushState({},"",'<?php echo uri_string();?>?start='+start+'<?php echo $url;?>');
		<?php }else{?>
		history.pushState({},"",'<?php echo uri_string();?>?start='+start);
		<?php } ?>
		j("#filter_stage").html('<img src="<?php echo IMAGE_PATH;?>loader_big.gif">');
		j('#start').val(start);

		<?php if(!empty($base_where)){ ?>
		j.post('<?php echo uri_string();?>?start='+start+'<?php echo $url;?>','',function(data){
			j("#filter_stage").html(data).fadeIn("fast");
		});
		<?php
		 }else{?>
		j.post('<?php echo uri_string();?>?start='+start,'',function(data){
			j("#filter_stage").html(data).fadeIn("fast");
		});
		<?php } ?>
	}
</script>
<div class="content_header">
	<?php echo anchor('/lipe','<img src="'.IMAGE_PATH.'user.gif"></a><h1>'.$title.'</h1>');?>
</div>
<?php require_once 'link_back_view.php'; ?>
<?php echo form_open(uri_string());?>
<div class="search_box">
	<div class="content_box">
		<?php echo form_input('shortname',$base_where['shortname'],'class="text_field_search" placeholder="Input Module class name or class name"');?>
		<?php echo form_dropdown('mode',$modes,$base_where['mode'],'class="search"');?>
		<?php echo form_submit('search','search');?>
	</div>
</div>
<div class="table_content">
	<div class="content_box"><div class="total_rows">Total amount of records: <span><?php echo number_format($total_rows);?></span></div></div>
	<div id="filter_stage">
		<?php $this->load->view('course_table');?>
	</div>
</div>
<?php echo form_close();?>