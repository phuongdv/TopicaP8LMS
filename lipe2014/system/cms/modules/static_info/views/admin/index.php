<section class="title">
	<h4><?php echo $title;?></h4>
</section>
<section class="item">
<?php //template_partial('filters'); ?>
<?php echo form_open(uri_string()); ?>
	<div class="fill_all_width">
	   <div class="right"><input type="submit" value="Cập nhật" class="pointer" name="btn_update" /></div>
	</div>
	<div id="filter-stage">
		<?php //template_partial('tables/tables'); ?>
		<?php $this->load->view('admin/tables/tables'); ?>
	</div>
<?php echo form_close(); ?>
</section>
