<?php /* Smarty version 2.6.18, created on 2013-10-10 22:29:39
         compiled from index.html */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>TOPICA System 1.0</title>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/admin.css" type="text/css">
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/style.css" type="text/css">
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/jquery-1.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/global.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/admin.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/png.js"></script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bottommargin="0" onLoad="onLoadFunc()">
<TABLE width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

<TR>
	<TD width="100%">
	<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/_header.html")): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/_header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php else: ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	</TD>
</TR>
<TR>
<TD width="100%">
	<TABLE id=AutoNumber11 borderColor=#111111 cellSpacing=0 cellPadding=0 width="100%" border=0>
	<TR>
	  <?php if ($this->_tpl_vars['core']->hasPanel('L') == 1): ?>		  
	  <TD width="159" valign="top" bgcolor="#4173c5">
	  
	  <?php echo $this->_tpl_vars['core']->showPanel('L'); ?>

		
	  </TD>
	  <?php endif; ?>
	  <TD vAlign=top width="100%">
	  
	  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/index.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	  
	  </TD>
	  <?php if ($this->_tpl_vars['core']->hasPanel('R') == 1): ?>	
	  <TD width="148" valign="top" bgcolor="#e5e5e5">
	  
	  <?php echo $this->_tpl_vars['core']->showPanel('R'); ?>

	  
	  </TD>
	  <?php endif; ?>
	</TR>
	</TABLE>
</TD>
</TR>
<TR>
	<TD width="100%" height="100%" valign="bottom">
	<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/_footer.html")): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/_footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php else: ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	</TD>
</TR>
</TABLE>
</body>
</html>