<?php /* Smarty version 2.6.18, created on 2013-05-14 11:34:22
         compiled from settinglipe/act_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'settinglipe/act_add.html', 7, false),)), $this); ?>
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
<table width="60%" border="0" align="center">
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

    
    <tr>
   		<td colspan="2">
        	<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:Tahoma, Geneva, sans-serif; font-size:11px;">	
            	<tr>
                	<td>Forum :</td>
                </tr>
            	<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrForumDiscussions']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
               <?php if ($this->_tpl_vars['arrForumDiscussions'][0]['forum'] != $this->_tpl_vars['arrForumDiscussions'][$this->_sections['id']['index']]['forum']): ?>
            	<tr>
                	<td>----Active_id =<font style="color:#F00; font-weight:bold;"><?php echo $this->_tpl_vars['arrForumDiscussions'][$this->_sections['id']['index']]['forum']; ?>
</font><!--<input name="<?php echo $this->_tpl_vars['arrForumDiscussions'][$this->_sections['id']['index']]['forum']; ?>
" value="1" type="radio">--></td>
                </tr>
                <?php endif; ?>
                <?php endfor; endif; ?>
                <tr>
                	<td>----Active_id =<font style="color:#F00; font-weight:bold;"><?php echo $this->_tpl_vars['arrForumDiscussions'][0]['forum']; ?>
</font></td>
                </tr>
                <tr>
                	<td height="5"></td>
                </tr>
                <tr>
                	<td>Quiz :</td>
                </tr>
                <?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['arrQuiz']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['step'] = 1;
$this->_sections['k']['start'] = $this->_sections['k']['step'] > 0 ? 0 : $this->_sections['k']['loop']-1;
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = $this->_sections['k']['loop'];
    if ($this->_sections['k']['total'] == 0)
        $this->_sections['k']['show'] = false;
} else
    $this->_sections['k']['total'] = 0;
if ($this->_sections['k']['show']):

            for ($this->_sections['k']['index'] = $this->_sections['k']['start'], $this->_sections['k']['iteration'] = 1;
                 $this->_sections['k']['iteration'] <= $this->_sections['k']['total'];
                 $this->_sections['k']['index'] += $this->_sections['k']['step'], $this->_sections['k']['iteration']++):
$this->_sections['k']['rownum'] = $this->_sections['k']['iteration'];
$this->_sections['k']['index_prev'] = $this->_sections['k']['index'] - $this->_sections['k']['step'];
$this->_sections['k']['index_next'] = $this->_sections['k']['index'] + $this->_sections['k']['step'];
$this->_sections['k']['first']      = ($this->_sections['k']['iteration'] == 1);
$this->_sections['k']['last']       = ($this->_sections['k']['iteration'] == $this->_sections['k']['total']);
?>
               
            	<tr>
                	<td>----Active_id =<font style="color:#F00; font-weight:bold;"><?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['k']['index']]['id']; ?>
</font>-<?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['k']['index']]['name']; ?>
<!--<input name="<?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['k']['index']]['id']; ?>
" value="1" type="radio">--></td>
                </tr>
             
                <?php endfor; endif; ?>
            </table>
        </td>
    </tr>
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