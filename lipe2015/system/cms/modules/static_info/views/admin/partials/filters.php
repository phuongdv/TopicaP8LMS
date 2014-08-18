<fieldset id="filters">
	<legend><?php echo lang('global:filters'); ?></legend>
	<?php echo form_open(uri_string()); ?>
		<ul>
			<li>
				Trạng thái :
				<?php echo form_dropdown('f_active',selectActive()); ?>
			</li>
			<li><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>