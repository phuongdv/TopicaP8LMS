<?php /* Smarty version 2.6.18, created on 2013-10-11 09:44:42
         compiled from settingcalendar/act_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'settingcalendar/act_add.html', 7, false),)), $this); ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&amp;mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/folders.png" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:24px;"><b><?php if ($this->_tpl_vars['_LANG_ID'] != 'vn'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['clsForm']->getTitle())) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php else: ?><?php echo $this->_tpl_vars['clsForm']->getTitle(); ?>
<?php endif; ?></b></font><br />
<font style="font-size:9px"><i><?php if ($this->_tpl_vars['_LANG_ID'] != 'vn'): ?><?php echo $this->_tpl_vars['clsForm']->getTitle(); ?>
 <?php echo $this->_tpl_vars['core']->getLang('Management'); ?>
<?php else: ?><?php echo $this->_tpl_vars['core']->getLang('Management'); ?>
 <?php echo $this->_tpl_vars['clsForm']->getTitle(); ?>
<?php endif; ?></i></font>
</td>
<td style="padding-right:10px; border-bottom:1px #CCCCCC solid;" align="right">
<div>
	<table cellpadding="2px" border="0">
	<tr>
		<?php echo $this->_tpl_vars['clsButtonNav']->render(); ?>
		
	</tr>
	</table>
</div>
</td>
</tr>
</table>
<form name="theForm" action="" method="post">
<table width="100%" border="0">
<tr>
<td style="padding-left:10px;padding-right:10px" colspan="4">
	<div style="padding-bottom:5px;font-size:14px">
	<strong><?php if ($this->_tpl_vars['clsForm']->pval != ""): ?><?php echo $this->_tpl_vars['core']->getLang('Edit'); ?>
 <?php echo $this->_tpl_vars['clsForm']->getTitle(); ?>
: #<?php echo $this->_tpl_vars['clsForm']->pval; ?>

			<?php else: ?><?php echo $this->_tpl_vars['core']->getLang('Add'); ?>
 <?php echo $this->_tpl_vars['clsForm']->getTitle(); ?>

			<?php endif; ?></strong>
	</div>
</td>
</tr>
<tr>
<td style="padding-left:10px;padding-right:10px">
	<div style="padding-bottom:5px;font-size:14px">
	<strong>Khóa học : <a href="http://www.topica.vn/elearning/course/view.php?id=<?php echo $this->_tpl_vars['c_id']; ?>
" target="_blank" style="text-decoration:none;color:#00F;"><?php echo $this->_tpl_vars['arrOneCourse']['fullname']; ?>
</a></strong>
	</div>
</td>
</tr>
<tr>

<td style="padding-left:10px;padding-right:10px" width="100%" valign="top">
	<?php echo $this->_tpl_vars['clsForm']->showJS(); ?>

	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable">
	<tr>
		<td colspan="2" class="gridheader1"><?php echo $this->_tpl_vars['core']->getLang('InputCorrectlyAllBelowFields'); ?>
</td>
	</tr>
	<?php if ($this->_tpl_vars['clsForm']->isValid != 1): ?>
	<tr>
		<td class="gridrow1" style="color:red; padding:5px" colspan="2">
		<?php echo $this->_tpl_vars['clsForm']->showAllError(); ?>

		</td>
	</tr>
	<?php endif; ?>
	<?php echo $this->_tpl_vars['clsForm']->showForm(); ?>

	</table>
	<em><font style="font-size:10px"><?php echo $this->_tpl_vars['core']->getLang("Note: * isrequired"); ?>
</font></em>
</td>
</tr>
<tr>
	<td></td>
</tr>
</table>
</form>