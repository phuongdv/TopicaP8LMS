<?php /* Smarty version 2.6.18, created on 2013-10-14 09:24:17
         compiled from lipe/act_sum.html */ ?>

<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/n-UserGroup-Quan-ly-nhom-nguoi-dung.gif" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:24px;"><b></b></font><br />
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
		
	</tr>
	</table>
</div>
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
          <td align="right" style="padding-right:20px;"> <a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/sub_sum.php?c_id=<?php echo $this->_tpl_vars['c_id']; ?>
&cls=<?php echo $this->_tpl_vars['lop']; ?>
&sft=<?php echo $this->_tpl_vars['sft']; ?>
&mode=<?php echo $this->_tpl_vars['mode']; ?>
" style="font-size: 12px; font-family: Arial,Helvetica,sans-serif; font-weight: bold; text-decoration: none; color: rgb(51, 51, 51);"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/export.jpg" align="absmiddle" border="0">XU&#7844;T RA EXCEL</a> </td>
     </tr>
</table>

<table cellspacing="0" border="1" cellpadding="5" width="100%" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px; padding-left:10px;" align="center">
	<tr style="background:#f0f0f0; font-weight:bold">
	<th>Mã HV</th>
	<th>Họ</th>
	<th>Tên</th>
	<th>Điểm đánh giá (10%)</th>
	<th>Điểm BTVN1</th>
		<th>Điểm BTVN2</th>
		<th>Điểm BT nhóm/ Kỹ năng</th>
	</tr>
    <?php unset($this->_sections['sv']);
$this->_sections['sv']['name'] = 'sv';
$this->_sections['sv']['loop'] = is_array($_loop=$this->_tpl_vars['arrUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sv']['show'] = true;
$this->_sections['sv']['max'] = $this->_sections['sv']['loop'];
$this->_sections['sv']['step'] = 1;
$this->_sections['sv']['start'] = $this->_sections['sv']['step'] > 0 ? 0 : $this->_sections['sv']['loop']-1;
if ($this->_sections['sv']['show']) {
    $this->_sections['sv']['total'] = $this->_sections['sv']['loop'];
    if ($this->_sections['sv']['total'] == 0)
        $this->_sections['sv']['show'] = false;
} else
    $this->_sections['sv']['total'] = 0;
if ($this->_sections['sv']['show']):

            for ($this->_sections['sv']['index'] = $this->_sections['sv']['start'], $this->_sections['sv']['iteration'] = 1;
                 $this->_sections['sv']['iteration'] <= $this->_sections['sv']['total'];
                 $this->_sections['sv']['index'] += $this->_sections['sv']['step'], $this->_sections['sv']['iteration']++):
$this->_sections['sv']['rownum'] = $this->_sections['sv']['iteration'];
$this->_sections['sv']['index_prev'] = $this->_sections['sv']['index'] - $this->_sections['sv']['step'];
$this->_sections['sv']['index_next'] = $this->_sections['sv']['index'] + $this->_sections['sv']['step'];
$this->_sections['sv']['first']      = ($this->_sections['sv']['iteration'] == 1);
$this->_sections['sv']['last']       = ($this->_sections['sv']['iteration'] == $this->_sections['sv']['total']);
?>
	<?php if ($this->_sections['sv']['index']%2 == '0'): ?>
                <tr  height="25">
	<?php elseif ($this->_sections['sv']['index']%2 == '1'): ?>
                <tr  height="25" bgcolor="#ededfe">			
	<?php endif; ?>	
	<td align="center">
	<?php echo $this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['topica_msv']; ?>

	</td>
	<td>
	<?php echo $this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['lastname']; ?>

	</td>
	<td>
	<?php echo $this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['firstname']; ?>

	</td>
	<td align="center">
	<?php unset($this->_sections['calendar']);
$this->_sections['calendar']['name'] = 'calendar';
$this->_sections['calendar']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['calendar']['show'] = true;
$this->_sections['calendar']['max'] = $this->_sections['calendar']['loop'];
$this->_sections['calendar']['step'] = 1;
$this->_sections['calendar']['start'] = $this->_sections['calendar']['step'] > 0 ? 0 : $this->_sections['calendar']['loop']-1;
if ($this->_sections['calendar']['show']) {
    $this->_sections['calendar']['total'] = $this->_sections['calendar']['loop'];
    if ($this->_sections['calendar']['total'] == 0)
        $this->_sections['calendar']['show'] = false;
} else
    $this->_sections['calendar']['total'] = 0;
if ($this->_sections['calendar']['show']):

            for ($this->_sections['calendar']['index'] = $this->_sections['calendar']['start'], $this->_sections['calendar']['iteration'] = 1;
                 $this->_sections['calendar']['iteration'] <= $this->_sections['calendar']['total'];
                 $this->_sections['calendar']['index'] += $this->_sections['calendar']['step'], $this->_sections['calendar']['iteration']++):
$this->_sections['calendar']['rownum'] = $this->_sections['calendar']['iteration'];
$this->_sections['calendar']['index_prev'] = $this->_sections['calendar']['index'] - $this->_sections['calendar']['step'];
$this->_sections['calendar']['index_next'] = $this->_sections['calendar']['index'] + $this->_sections['calendar']['step'];
$this->_sections['calendar']['first']      = ($this->_sections['calendar']['iteration'] == 1);
$this->_sections['calendar']['last']       = ($this->_sections['calendar']['iteration'] == $this->_sections['calendar']['total']);
?>
	  <?php if ($this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['week_name'] == 'Tổng'): ?>
	  <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['username'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
	  <?php $this->assign('h2472', $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'])); ?>
	  <?php $this->assign('count_practice', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['end_date'])); ?>				
	 <?php endif; ?>
	
	<?php endfor; endif; ?>
	
	
	<?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
	<?php $this->assign('diemcc', $this->_tpl_vars['clsOffline']->getCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'],$this->_tpl_vars['mode'])); ?>
	 <?php $this->assign('chitietdiemcc', $this->_tpl_vars['clsOffline']->showGetCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'])); ?>
	<?php echo $this->_tpl_vars['diemcc']; ?>
</td>
	
	<td align="center"><?php $this->assign('btvn1', $this->_tpl_vars['clsSettingCalendar']->getbtvn($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'],1)); ?> <?php echo $this->_tpl_vars['btvn1']; ?>
</td>
		<td align="center">
		
		<?php $this->assign('btvn2', $this->_tpl_vars['clsSettingCalendar']->getbtvn($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'],2)); ?> <?php echo $this->_tpl_vars['btvn2']; ?>

		</td>
		 
		<td align="center"><?php $this->assign('btvn', $this->_tpl_vars['clsOffline']->getBt($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'])); ?> <?php echo $this->_tpl_vars['btvn']; ?>
</td>
	</tr>
	
	
			
	
	<?php endfor; endif; ?>

	</table>	

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
          <td align="right" style="padding-right:20px;"> <a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/sub_sum.php?c_id=1728&cls=124501.TNE1&sft=&mode=3?c_id=<?php echo $this->_tpl_vars['c_id']; ?>
&cls=<?php echo $this->_tpl_vars['lop']; ?>
&sft=<?php echo $this->_tpl_vars['sft']; ?>
&mode=<?php echo $this->_tpl_vars['mode']; ?>
" style="font-size: 12px; font-family: Arial,Helvetica,sans-serif; font-weight: bold; text-decoration: none; color: rgb(51, 51, 51);"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/export.jpg" align="absmiddle" border="0">XU&#7844;T RA EXCEL</a> </td>
     </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="20"></td>
    </tr>
</table>
<!--

<?php if ($this->_tpl_vars['GradeA'] != -1 && $this->_tpl_vars['GradeA'] != 0): ?><?php echo $this->_tpl_vars['GradeA']; ?>
<?php else: ?><?php endif; ?>
-->