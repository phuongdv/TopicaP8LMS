<?php /* Smarty version 2.6.18, created on 2013-10-11 09:19:28
         compiled from settinglipe/act_default.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'settinglipe/act_default.html', 7, false),)), $this); ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&amp;mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/folders.png" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:24px;"><b><?php if ($this->_tpl_vars['_LANG_ID'] != 'vn'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['clsDataGrid']->getTitle())) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php else: ?><?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
<?php endif; ?></b></font><br />
<font style="font-size:9px"><i><?php if ($this->_tpl_vars['_LANG_ID'] != 'vn'): ?><?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
 <?php echo $this->_tpl_vars['core']->getLang('Management'); ?>
<?php else: ?><?php echo $this->_tpl_vars['core']->getLang('Management'); ?>
 <?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
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
<?php echo '
<script type="text/javascript">
  $(document).ready(function(){
		$("#dosearch").click(function(){			
			$("#theForm")[0].submit();
		});	
  });  
</script>
'; ?>

 <form name="theForm" id="theForm" action="" method="post">
<table width="100%" border="0">
<tr>
<td style="padding-left:10px;padding-right:10px">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td align="left">
			<div style="padding-bottom:5px;font-size:14px">
				<strong><?php echo $this->_tpl_vars['core']->getLang('ListOf'); ?>
 <?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
</strong>&nbsp;&nbsp;&nbsp;&nbsp;<strong><a href="?topica&mod=lipe&act=report&c_id=<?php echo $this->_tpl_vars['c_id']; ?>
" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px; text-decoration:underline; color:#00F;" >View Report</a></strong>
			 </div>
			</td>
			
		</tr>
	</table>	
</td>
</tr>
<tr>
	<td align="center">
   
    	
        
    </td>
</tr>
<tr>
<td style="padding-left:10px;padding-right:10px" width="100%" valign="top">
	<?php echo $this->_tpl_vars['clsDataGrid']->showDataGrid('theForm'); ?>

	
</td>
</tr>
<tr>
<td  style="padding-left:10px;padding-right:10px">
	<?php echo $this->_tpl_vars['clsDataGrid']->showPaging('theForm'); ?>

</td>
</tr>
</table>
</form>