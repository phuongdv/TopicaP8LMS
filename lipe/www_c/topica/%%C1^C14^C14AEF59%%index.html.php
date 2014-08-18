<?php /* Smarty version 2.6.18, created on 2013-10-11 07:00:43
         compiled from default/index.html */ ?>
<?php if ($this->_tpl_vars['sub'] != 'default'): ?>
	<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/sub_".($this->_tpl_vars['sub']).".html")): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/sub_".($this->_tpl_vars['sub']).".html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php else: ?>
		Template Sub Module File sub_<?php echo $this->_tpl_vars['sub']; ?>
.html not Found!
	<?php endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['act'] != 'default'): ?>
		<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/act_".($this->_tpl_vars['act']).".html")): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/act_".($this->_tpl_vars['act']).".html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
		<?php else: ?>
			Template Action File act_<?php echo $this->_tpl_vars['act']; ?>
.html not Found!
		<?php endif; ?>
	<?php else: ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/act_default.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php endif; ?>