<?php /* Smarty version 2.6.18, created on 2014-03-07 12:20:06
         compiled from act_report_excell.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'act_report_excell.html', 9, false),)), $this); ?>
<Meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px; padding-left:10px;" align="center">
	<tr  >
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0"  style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
            	<tr bgcolor="#f0f0f0" height="25">
                	
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"  colspan="5"><p>Khóa học: <b><?php echo $this->_tpl_vars['arrOneCourse']['fullname']; ?>
</b> Time:<b><?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></p>
                 <p>Lớp:<b><?php echo $this->_tpl_vars['lop']; ?>
</b><br />
                 Chế độ xem : Mode <?php echo $this->_tpl_vars['mode']; ?>
</p></td>
                    
                     <?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                     <?php $this->assign('endate', $this->_tpl_vars['clsSettingCalendar']->ConvertDateGMT($this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['end_date'])); ?>
                     <?php if ($this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['week_name'] != 'Tổng'): ?>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"colspan="4"><?php echo $this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['week_name']; ?>
<br />(<?php echo ((is_array($_tmp=$this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
 -> <?php echo ((is_array($_tmp=$this->_tpl_vars['endate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
)</td>
                      <?php else: ?>
                       <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"colspan="6"><?php echo $this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['week_name']; ?>
kết<br />
                  (<?php echo ((is_array($_tmp=$this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
 -> <?php echo ((is_array($_tmp=$this->_tpl_vars['endate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
)</td>
                  <?php endif; ?>
                      <?php endfor; endif; ?>
                        <!--<td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"  colspan="3" >Tá»•ng káº¿t</td>-->
                </tr>
                <tr bgcolor="#f0f0f0" height="25">
                	<td width="160" rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">STT</td>
                    <td width="129" rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">H&#7885;</td>
                    <td width="131" rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">T&ecirc;n</td>
                    <td width="201" rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">Nh&oacute;m</td>
                    <td width="202" rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">Mã sinh viên</td>
                     <?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                     <?php if ($this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['week_name'] != 'Tổng'): ?>
                     <?php $this->assign('count_quizweek', $this->_tpl_vars['clsSettingCalendar']->QuizPerWeek($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['k']['index']]['id'])); ?>
                     <td rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >I</td>
                      <td rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >P(<?php echo $this->_tpl_vars['count_quizweek']; ?>
)</td>
                       <td rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >E</td>
                       <td rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >H</td>
                       <?php else: ?>
                        <td rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >Forum Post</td>
                        <td rowspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >H2472</td>
                      <td colspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  ><p>S&#7889; b&agrave;i &#273;&atilde; l&agrave;m</p></td>
                       
                       <td colspan="2" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >Điểm</td>
                       <?php endif; ?>
                      <?php endfor; endif; ?>
                     <!-- <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"  >I</td>
                      <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"  >P</td>
                       <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"  >E</td>-->
                </tr>
                <tr bgcolor="#f0f0f0" height="25">
                  <td width="217" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >P</td>
                  <td width="212" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >E</td>
                  <td width="106" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >CC</td>
                  <td width="106" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  >BT</td>
                </tr>
<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                  <?php $this->assign(false, $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
               
                 <?php if ($this->_sections['id']['index']%2 == '0'): ?>
                <tr  height="25">
                	<td width="160" height="62" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"><?php echo $this->_sections['id']['index']+1; ?>
<!--<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
--></td>
                  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><a href="http://www.topica.vn/elearning/course/user.php?id=<?php echo $this->_tpl_vars['c_id']; ?>
&user=<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
&mode=outline" target="_blank"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php if ($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom'] != ''): ?><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
<?php else: ?> None <?php endif; ?></td>
                    
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_msv']; ?>
</td>
                  <?php unset($this->_sections['e']);
$this->_sections['e']['name'] = 'e';
$this->_sections['e']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['e']['show'] = true;
$this->_sections['e']['max'] = $this->_sections['e']['loop'];
$this->_sections['e']['step'] = 1;
$this->_sections['e']['start'] = $this->_sections['e']['step'] > 0 ? 0 : $this->_sections['e']['loop']-1;
if ($this->_sections['e']['show']) {
    $this->_sections['e']['total'] = $this->_sections['e']['loop'];
    if ($this->_sections['e']['total'] == 0)
        $this->_sections['e']['show'] = false;
} else
    $this->_sections['e']['total'] = 0;
if ($this->_sections['e']['show']):

            for ($this->_sections['e']['index'] = $this->_sections['e']['start'], $this->_sections['e']['iteration'] = 1;
                 $this->_sections['e']['iteration'] <= $this->_sections['e']['total'];
                 $this->_sections['e']['index'] += $this->_sections['e']['step'], $this->_sections['e']['iteration']++):
$this->_sections['e']['rownum'] = $this->_sections['e']['iteration'];
$this->_sections['e']['index_prev'] = $this->_sections['e']['index'] - $this->_sections['e']['step'];
$this->_sections['e']['index_next'] = $this->_sections['e']['index'] + $this->_sections['e']['step'];
$this->_sections['e']['first']      = ($this->_sections['e']['iteration'] == 1);
$this->_sections['e']['last']       = ($this->_sections['e']['iteration'] == $this->_sections['e']['total']);
?>
                   <?php unset($this->_sections['li']);
$this->_sections['li']['name'] = 'li';
$this->_sections['li']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingLipe']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['li']['show'] = true;
$this->_sections['li']['max'] = $this->_sections['li']['loop'];
$this->_sections['li']['step'] = 1;
$this->_sections['li']['start'] = $this->_sections['li']['step'] > 0 ? 0 : $this->_sections['li']['loop']-1;
if ($this->_sections['li']['show']) {
    $this->_sections['li']['total'] = $this->_sections['li']['loop'];
    if ($this->_sections['li']['total'] == 0)
        $this->_sections['li']['show'] = false;
} else
    $this->_sections['li']['total'] = 0;
if ($this->_sections['li']['show']):

            for ($this->_sections['li']['index'] = $this->_sections['li']['start'], $this->_sections['li']['iteration'] = 1;
                 $this->_sections['li']['iteration'] <= $this->_sections['li']['total'];
                 $this->_sections['li']['index'] += $this->_sections['li']['step'], $this->_sections['li']['iteration']++):
$this->_sections['li']['rownum'] = $this->_sections['li']['iteration'];
$this->_sections['li']['index_prev'] = $this->_sections['li']['index'] - $this->_sections['li']['step'];
$this->_sections['li']['index_next'] = $this->_sections['li']['index'] + $this->_sections['li']['step'];
$this->_sections['li']['first']      = ($this->_sections['li']['iteration'] == 1);
$this->_sections['li']['last']       = ($this->_sections['li']['iteration'] == $this->_sections['li']['total']);
?>
                   <?php if ($this->_tpl_vars['arrSettingLipe'][$this->_sections['li']['index']]['lipe_type'] == 'V'): ?>
                    <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                    
                   <?php else: ?>
                   <?php $this->assign('count_post', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesetting($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                   <?php endif; ?>
                   <?php endfor; endif; ?>
                   <?php $this->assign('activeID', $this->_tpl_vars['clsSettingCalendar']->GetActiveID($this->_tpl_vars['c_id'])); ?>
                     <?php $this->assign('GradeA', $this->_tpl_vars['clsSettingCalendar']->GetGradeFromAssignment($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['activeID'])); ?>
                   <?php $this->assign('grades', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingGrades($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                   <!-- Danglx thu hien thi điểm 0 -->
				   <?php $this->assign('grades_dang', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingGrades_dang($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
				   
				   <?php $this->assign('count_practice', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'])); ?>
			
                   <?php $this->assign('count_practiceCc', $this->_tpl_vars['clsSettingCalendar']->CountPracticeCC($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                    <?php $this->assign('count_practice_week', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'])); ?>
                    <?php if ($this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['week_name'] != 'Tổng'): ?>
                   
				  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?></font></td>
				  
                  <!--<td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['count_post'] != 0): ?><?php echo $this->_tpl_vars['count_post']; ?>
<?php endif; ?></font></td>-->
                  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="155" align="center"><font style="color:#000; font-weight:bold;"><?php if ($this->_tpl_vars['count_practice_week'] != 0): ?><?php echo $this->_tpl_vars['count_practice_week']; ?>
<?php endif; ?></font></td>
                  <!-- hien thi diem 0-->
                   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="70" align="center"><span style="color:#F00; font-weight:bold"><?php if ($this->_tpl_vars['grades_dang'] == ''): ?><?php elseif ($this->_tpl_vars['grades_dang'] == '0.00'): ?>0<?php else: ?><?php echo $this->_tpl_vars['grades_dang']; ?>
<?php endif; ?></span> </td> 
				   
				  <!--
				  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="70" align="center"><?php if ($this->_tpl_vars['grades'] != 0): ?><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['grades']; ?>
</span> <?php else: ?>  <?php endif; ?></td>
                  --> 
				   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="70" align="center"><?php echo $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']); ?>
</td>
                 <?php else: ?>
                  <?php $this->assign('count_exam', $this->_tpl_vars['clsSettingCalendar']->CountExam($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                  	<td  style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; " width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['count_post'] != 0): ?><?php echo $this->_tpl_vars['count_post']; ?>
<?php endif; ?></font></td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><?php echo $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']); ?>
</td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_practice']; ?>
</span></td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_exam']; ?>
</span></td>
                  
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">
                     <?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
					 <?php $this->assign('h2472', $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'])); ?>
                     <?php $this->assign('diemcc', $this->_tpl_vars['clsOffline']->getCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'],$this->_tpl_vars['mode'])); ?>
                      <?php $this->assign('chitietdiemcc', $this->_tpl_vars['clsOffline']->showGetCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'])); ?>
                      <label title="<?php echo $this->_tpl_vars['chitietdiemcc']; ?>
"><?php echo $this->_tpl_vars['diemcc']; ?>
</label> 
                     </td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><?php $this->assign('btvn', $this->_tpl_vars['clsOffline']->getBt($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?> <?php echo $this->_tpl_vars['btvn']; ?>
</td>
                  <?php endif; ?>
               <?php endfor; endif; ?>
              <!-- <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="80">
                   </td>
                   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="80">
                   </td>
                   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="80">
                   </td>-->
                </tr>
                <?php elseif ($this->_sections['id']['index']%2 == '1'): ?>
                <tr  height="25" bgcolor="#ededfe">
                	<td width="160" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><?php echo $this->_sections['id']['index']+1; ?>
<!--<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
--></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><a href="http://www.topica.vn/elearning/course/user.php?id=<?php echo $this->_tpl_vars['c_id']; ?>
&user=<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
&mode=outline" target="_blank"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"><?php if ($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom'] != ''): ?><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
<?php else: ?> None <?php endif; ?></td>
                     
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"> <?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_msv']; ?>
</td>
                  <?php unset($this->_sections['e']);
$this->_sections['e']['name'] = 'e';
$this->_sections['e']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['e']['show'] = true;
$this->_sections['e']['max'] = $this->_sections['e']['loop'];
$this->_sections['e']['step'] = 1;
$this->_sections['e']['start'] = $this->_sections['e']['step'] > 0 ? 0 : $this->_sections['e']['loop']-1;
if ($this->_sections['e']['show']) {
    $this->_sections['e']['total'] = $this->_sections['e']['loop'];
    if ($this->_sections['e']['total'] == 0)
        $this->_sections['e']['show'] = false;
} else
    $this->_sections['e']['total'] = 0;
if ($this->_sections['e']['show']):

            for ($this->_sections['e']['index'] = $this->_sections['e']['start'], $this->_sections['e']['iteration'] = 1;
                 $this->_sections['e']['iteration'] <= $this->_sections['e']['total'];
                 $this->_sections['e']['index'] += $this->_sections['e']['step'], $this->_sections['e']['iteration']++):
$this->_sections['e']['rownum'] = $this->_sections['e']['iteration'];
$this->_sections['e']['index_prev'] = $this->_sections['e']['index'] - $this->_sections['e']['step'];
$this->_sections['e']['index_next'] = $this->_sections['e']['index'] + $this->_sections['e']['step'];
$this->_sections['e']['first']      = ($this->_sections['e']['iteration'] == 1);
$this->_sections['e']['last']       = ($this->_sections['e']['iteration'] == $this->_sections['e']['total']);
?>
                   <?php unset($this->_sections['li']);
$this->_sections['li']['name'] = 'li';
$this->_sections['li']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingLipe']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['li']['show'] = true;
$this->_sections['li']['max'] = $this->_sections['li']['loop'];
$this->_sections['li']['step'] = 1;
$this->_sections['li']['start'] = $this->_sections['li']['step'] > 0 ? 0 : $this->_sections['li']['loop']-1;
if ($this->_sections['li']['show']) {
    $this->_sections['li']['total'] = $this->_sections['li']['loop'];
    if ($this->_sections['li']['total'] == 0)
        $this->_sections['li']['show'] = false;
} else
    $this->_sections['li']['total'] = 0;
if ($this->_sections['li']['show']):

            for ($this->_sections['li']['index'] = $this->_sections['li']['start'], $this->_sections['li']['iteration'] = 1;
                 $this->_sections['li']['iteration'] <= $this->_sections['li']['total'];
                 $this->_sections['li']['index'] += $this->_sections['li']['step'], $this->_sections['li']['iteration']++):
$this->_sections['li']['rownum'] = $this->_sections['li']['iteration'];
$this->_sections['li']['index_prev'] = $this->_sections['li']['index'] - $this->_sections['li']['step'];
$this->_sections['li']['index_next'] = $this->_sections['li']['index'] + $this->_sections['li']['step'];
$this->_sections['li']['first']      = ($this->_sections['li']['iteration'] == 1);
$this->_sections['li']['last']       = ($this->_sections['li']['iteration'] == $this->_sections['li']['total']);
?>
                   <?php if ($this->_tpl_vars['arrSettingLipe'][$this->_sections['li']['index']]['lipe_type'] == 'V'): ?>
                    <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                    
                   <?php else: ?>
                   <?php $this->assign('count_post', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesetting($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                   <?php endif; ?>
                   <?php endfor; endif; ?>
                   <?php $this->assign('activeID', $this->_tpl_vars['clsSettingCalendar']->GetActiveID($this->_tpl_vars['c_id'])); ?>
                     <?php $this->assign('GradeA', $this->_tpl_vars['clsSettingCalendar']->GetGradeFromAssignment($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['activeID'])); ?>
                   <?php $this->assign('grades', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingGrades($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                    <!-- Danglx thu hien thi điểm 0 -->
				   <?php $this->assign('grades_dang', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingGrades_dang($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
				   
					<?php $this->assign('count_practice', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'])); ?>
                    <?php $this->assign('count_practiceCc', $this->_tpl_vars['clsSettingCalendar']->CountPracticeCC($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
                    <?php $this->assign('count_practice_week', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'])); ?>
                    <?php if ($this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['week_name'] != 'Tổng'): ?>
					
					<td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC;"  width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?></font></td>
					
                  <!-- <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC;"  width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['count_post'] != 0): ?><?php echo $this->_tpl_vars['count_post']; ?>
<?php endif; ?></font></td>-->
                  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="155" align="center"><font style="color:#000; font-weight:bold;"><?php if ($this->_tpl_vars['count_practice_week'] != 0): ?><?php echo $this->_tpl_vars['count_practice_week']; ?>
<?php endif; ?></font></td>
                   <!-- hien thi diem 0-->
                   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="70" align="center"><span style="color:#F00; font-weight:bold"><?php if ($this->_tpl_vars['grades_dang'] == ''): ?><?php elseif ($this->_tpl_vars['grades_dang'] == '0.00'): ?>0<?php else: ?><?php echo $this->_tpl_vars['grades_dang']; ?>
<?php endif; ?></span> </td> 
				   
				  <!--
				  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="70" align="center"><?php if ($this->_tpl_vars['grades'] != 0): ?><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['grades']; ?>
</span> <?php else: ?>  <?php endif; ?></td>
                  --> 
                  <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="70" align="center"><?php echo $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']); ?>
</td>
                  	<?php else: ?>
                     <?php $this->assign('count_exam', $this->_tpl_vars['clsSettingCalendar']->CountExam($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
					 
					 <td  style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; " width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?></font></td>
					 
                  	<!--<td  style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; " width="139" align="center"><font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['count_post'] != 0): ?><?php echo $this->_tpl_vars['count_post']; ?>
<?php endif; ?></font></td>-->
                  <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><?php echo $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']); ?>
</td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_practice']; ?>
</span></td>
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_exam']; ?>
</span></td>
                  
                    <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">
                     <?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
					 <?php $this->assign('h2472', $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['e']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'])); ?>
                     <?php $this->assign('diemcc', $this->_tpl_vars['clsOffline']->getCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'],$this->_tpl_vars['mode'])); ?>
                      <?php $this->assign('chitietdiemcc', $this->_tpl_vars['clsOffline']->showGetCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'])); ?>
                        <label title="<?php echo $this->_tpl_vars['chitietdiemcc']; ?>
"><?php echo $this->_tpl_vars['diemcc']; ?>
</label> 
                     </td>
                  <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><?php $this->assign('btvn', $this->_tpl_vars['clsOffline']->getBt($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['c_id'])); ?> <?php echo $this->_tpl_vars['btvn']; ?>
</td>
                  <?php endif; ?>
               <?php endfor; endif; ?> 
                <!--<td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="80">
                   </td>
                   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="80">
                   </td>
                   <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "  width="80">
                   </td>-->
                </tr>
                <?php endif; ?>
  <?php endfor; endif; ?>
            </table>
   </td>
       
       <!-- <td>
        	<table cellpadding="0" cellspacing="0" border="0"  style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
            	<tr bgcolor="#f0f0f0" height="25">
                    
                   
                </tr>
                <?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                 <?php if ($this->_sections['id']['index']%2 == '0'): ?>
                <tr  height="25">
                	<td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">Há»?</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">TÃªn</td>
                </tr>
                <?php elseif ($this->_sections['id']['index']%2 == '1'): ?>
                <tr  height="25" bgcolor="#d2d2fb">
                	<td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">Há»?</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">TÃªn</td>
                </tr>
                <?php endif; ?>
                <?php endfor; endif; ?>
            </table>
        </td>-->
       
    </tr>
   	
    <tr>
    	<td colspan="5" height="20"></td>
    </tr>
</table>