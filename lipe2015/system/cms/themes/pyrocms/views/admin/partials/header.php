<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>
<div class="header">
	<div class="top_nav">
		<?php echo anchor('/admin','<img src="'.IMAGE_ADMIN_PATH.'home.png" height="34" alt="logo" />');?>
		<div class="box_user">
			<div class="tenTK">
				<span class="boder_left"> </span>
				<?php echo anchor('/edit-profile','<img src="'.IMAGE_ADMIN_PATH.'user.png" />'.$this->current_user->display_name.'&nbsp;<i style="color:#94DBFF">('.$this->current_user->group.')</i>');?>
				<?php echo anchor('/admin/logout','<img src="'.IMAGE_ADMIN_PATH.'logout.png" />Thoát');?>
			</div>
		</div>
		<div class="form_search">
			<form class="search">
				<input type="text" class="search-query" id="nav-search" placeholder="<?php echo lang("cp:search"); ?>" ontouchstart="">
			</form>
		</div>
	</div>
	<div style="height:34px;"></div>

	<span class="messagerLS">
		<a href="<?php echo current_url(); ?>?lang=vi" title="Việt nam"> <img src="<?php echo IMAGE_ADMIN_PATH;?>Vietnam-Flag.png" /> </a>
		<a href="<?php echo current_url(); ?>?lang=en" title="English"> <img src="<?php echo IMAGE_ADMIN_PATH;?>England-Flag.png" /> </a>
	 </span>

	<a href="javascript:void(0)" class="messager">Date : <span><?php echo date('d-m-Y',time());?></span></a>

	<div class="thong_bao">
		<img src="<?php echo IMAGE_ADMIN_PATH;?>speak.png" />
		<p>
		<?php echo $module_details['name'] ? anchor('admin/'.$module_details['slug'], $module_details['name']) : lang('global:dashboard') ?>

			<?php if ( $this->uri->segment(2) ) { echo '<span class="divider">&nbsp; | &nbsp;</span>'; } ?>
			<?php echo $module_details['description'] ? $module_details['description'] : '' ?>
			<?php if ( $this->uri->segment(2) ) { echo '<span class="divider">&nbsp; | &nbsp;</span>'; } ?>
			<?php if($module_details['slug']): ?>
				<?php echo anchor('admin/help/'.$module_details['slug'], lang('help_label'), array('title' => $module_details['name'].'&nbsp;'.lang('help_label'), 'class' => 'modal')); ?>
			<?php endif; ?>

			<?php file_partial('shortcuts'); ?>
			<?php /*if ( ! empty($module_details['sections'])) file_partial('sections')*/ ?>
			<?php /*echo $module_details['name'] ? anchor('admin/'.$module_details['slug'], $module_details['name']) : lang('global:dashboard'); */?><!--</h2>
			<i>
				<?php /*if ( $this->uri->segment(2) ) { echo '&nbsp; | &nbsp;'; } */?>
				<?php /*echo $module_details['description'] ? $module_details['description'] : ''; */?>
			</i>-->
		</p>
	</div>

		<?php
		if ( ! empty($module_details['sections'])){
			echo '<div class="fill_all">';
			file_partial('sections');
			echo '</div>';
		} ?>
</div>
