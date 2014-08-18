<?php /* Smarty version 2.6.18, created on 2013-11-22 14:07:27
         compiled from lipe/act_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'lipe/act_add.html', 51, false),)), $this); ?>
<?php echo '
<script language="JavaScript">
function CheckAll1(cb) {
	 var fmobj = document.theForm;
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != \'allbox1\') && (e.type==\'checkbox\') && (e.value==cb)&& (!e.disabled)) {
			 e.checked = fmobj.allbox1.checked;
		 }
	 }
}
function CheckAll2(cb) {
	 var fmobj = document.theForm;
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != \'allbox2\') && (e.type==\'checkbox\') && (e.value==cb)&& (!e.disabled)) {
			 e.checked = fmobj.allbox2.checked;
		 }
	 }
}
function CheckAll3(cb) {
	 var fmobj = document.theForm;
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != \'allbox3\') && (e.type==\'checkbox\') && (e.value==cb)&& (!e.disabled)) {
			 e.checked = fmobj.allbox3.checked;
		 }
	 }
}
function CheckAll4(cb) {
	 var fmobj = document.theForm;
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != \'allbox4\') && (e.type==\'checkbox\') && (e.value==cb)&& (!e.disabled)) {
			 e.checked = fmobj.allbox4.checked;
		 }
	 }
}
function save2(){
	document.theForm.btnSave.value = "SaveAndContinue";
	document.theForm.submit();
}
</script>
'; ?>

<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/n-UserGroup-Quan-ly-nhom-nguoi-dung.gif" border="0"/></a></div>
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
<td style="padding-left:10px;padding-right:10px" width="100%" valign="top">
	<?php echo $this->_tpl_vars['clsForm']->showJS(); ?>

	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable">
	<tr>
		<td colspan="2" class="gridheader1"><?php echo $this->_tpl_vars['core']->getLang('InputCorrectlyAllBelowFields'); ?>
<Br />
		
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
	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable">
	<tr>
		<td colspan="6" class="gridheader1"><?php echo $this->_tpl_vars['core']->getLang('Permissions'); ?>
:</td>
	</tr>
	<tr>
		<td class="gridrow1" width="40%"><strong>Module Name</strong></td>
		<td class="gridrow1" width="10%"><strong><?php echo $this->_tpl_vars['core']->getLang('List'); ?>
</strong><br /><input type="checkbox" name="allbox4" onClick="CheckAll4(4)" /></td>
		<td class="gridrow1" width="10%"><strong><?php echo $this->_tpl_vars['core']->getLang('Add'); ?>
</strong><br /><input type="checkbox" name="allbox1" onClick="CheckAll1(1)" /></td>
		<td class="gridrow1" width="10%"><strong><?php echo $this->_tpl_vars['core']->getLang('Edit'); ?>
</strong><br /><input type="checkbox" name="allbox2" onClick="CheckAll2(2)" /></td>
		<td class="gridrow1"><strong><?php echo $this->_tpl_vars['core']->getLang('Delete'); ?>
</strong><br /><input type="checkbox" name="allbox3" onClick="CheckAll3(3)" /></td>
	</tr>
	<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrAdminModule']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['id']['show'] = true;
$this->_sections['id']['max'] = $this->_sections['id']['loop'];
$this->_sections['id']['step'] = 1;
$this->_sections['id']['start'] = $this->_sections['id']['step'] > 0 ? 0 : $this->_sections['id']['loop']-1;
if ($this->_sections['id']['show']) {
    $this->_sections['id']['total'] = $this->_sections['id']['loop'];
    if ($this->_sections['id']['total'] == 0)
        $this->_sections['id']['show'] = false;
} else
    $this->_sections['id']['total'] = 0;
if ($this->_sections['id']['show']):

            for ($this->_sections['id']['index'] = $this->_sections['id']['start'], $this->_sections['id']['iteration'] = 1;
                 $this->_sections['id']['iteration'] <= $this->_sections['id']['total'];
                 $this->_sections['id']['index'] += $this->_sections['id']['step'], $this->_sections['id']['iteration']++):
$this->_sections['id']['rownum'] = $this->_sections['id']['iteration'];
$this->_sections['id']['index_prev'] = $this->_sections['id']['index'] - $this->_sections['id']['step'];
$this->_sections['id']['index_next'] = $this->_sections['id']['index'] + $this->_sections['id']['step'];
$this->_sections['id']['first']      = ($this->_sections['id']['iteration'] == 1);
$this->_sections['id']['last']       = ($this->_sections['id']['iteration'] == $this->_sections['id']['total']);
?>
	<?php $this->assign('site_name', $this->_tpl_vars['arrAdminModule'][$this->_sections['id']['index']]['site_name']); ?>
	<tr>
		<td class="gridrow" width="40%"><?php echo $this->_tpl_vars['arrAdminModule'][$this->_sections['id']['index']]['display_name']; ?>
</td>
		<td class="gridrow1" width="10%"><input type="checkbox" name="<?php echo $this->_tpl_vars['site_name']; ?>
[L]" value="4" <?php if ($this->_tpl_vars['arrAccessPermiss'][$this->_tpl_vars['site_name']]['L'] > 0): ?>checked<?php endif; ?>/></td>
		<td class="gridrow1" width="10%"><input type="checkbox" name="<?php echo $this->_tpl_vars['site_name']; ?>
[A]" value="1"  <?php if ($this->_tpl_vars['arrAccessPermiss'][$this->_tpl_vars['site_name']]['A'] > 0): ?>checked<?php endif; ?>/></td>
		<td class="gridrow1" width="10%"><input type="checkbox" name="<?php echo $this->_tpl_vars['site_name']; ?>
[E]" value="2"  <?php if ($this->_tpl_vars['arrAccessPermiss'][$this->_tpl_vars['site_name']]['E'] > 0): ?>checked<?php endif; ?>/></td>
		<td class="gridrow1"			><input type="checkbox" name="<?php echo $this->_tpl_vars['site_name']; ?>
[D]" value="3"  <?php if ($this->_tpl_vars['arrAccessPermiss'][$this->_tpl_vars['site_name']]['D'] > 0): ?>checked<?php endif; ?>/></td>
	</tr>
	<?php endfor; endif; ?>
	</table>
	<em><font style="font-size:10px"><?php echo $this->_tpl_vars['core']->getLang("Note: * isrequired"); ?>
</font></em>
</td>
</tr>
</table>
</form>