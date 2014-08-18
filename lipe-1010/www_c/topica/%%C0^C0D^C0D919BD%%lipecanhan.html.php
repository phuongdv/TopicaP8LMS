<?php /* Smarty version 2.6.18, created on 2013-10-10 18:52:28
         compiled from lipecanhan.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'lipecanhan.html', 52, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>TOPICA - LIPE CÁ NHÂN</title>

<META http-equiv=Content-Type content="text/html; charset=utf-8">

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bottommargin="0" >
<div align="center">

  <table width="548" border="0">
    <tr>
    <?php $this->assign('arrUser', $this->_tpl_vars['clsLipecanhan']->getUserinfo($this->_tpl_vars['userid'])); ?>
      <td width="112" class="title_col">Họ tên học viên: &nbsp;&nbsp;</td>
      <td width="155" class="title_col"><?php echo $this->_tpl_vars['arrUser'][0]['lastname']; ?>
 <?php echo $this->_tpl_vars['arrUser'][0]['firstname']; ?>
 </td>
      
      <td class="title_col">&nbsp;</td>
    </tr>
    <tr>
      <td class="title_col">Lớp: &nbsp;&nbsp;</td>
      <td class="title_col">  <?php echo $this->_tpl_vars['arrUser'][0]['topica_lop']; ?>
</td>
      
      <td width="190" class="title_col"><?php echo $this->_tpl_vars['arrUser'][0]['topica_namsinh']; ?>
</td>
    </tr>

    <tr>
      <td colspan="2">&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
  </table>
</div>
<div align="center">
  <table width="98%" border="0">
    
   
<?php $this->assign('arrCourse', $this->_tpl_vars['clsLipecanhan']->getCourse($this->_tpl_vars['userid'])); ?>
      <?php unset($this->_sections['c']);
$this->_sections['c']['name'] = 'c';
$this->_sections['c']['loop'] = is_array($_loop=$this->_tpl_vars['arrCourse']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['c']['show'] = true;
$this->_sections['c']['max'] = $this->_sections['c']['loop'];
$this->_sections['c']['step'] = 1;
$this->_sections['c']['start'] = $this->_sections['c']['step'] > 0 ? 0 : $this->_sections['c']['loop']-1;
if ($this->_sections['c']['show']) {
    $this->_sections['c']['total'] = $this->_sections['c']['loop'];
    if ($this->_sections['c']['total'] == 0)
        $this->_sections['c']['show'] = false;
} else
    $this->_sections['c']['total'] = 0;
if ($this->_sections['c']['show']):

            for ($this->_sections['c']['index'] = $this->_sections['c']['start'], $this->_sections['c']['iteration'] = 1;
                 $this->_sections['c']['iteration'] <= $this->_sections['c']['total'];
                 $this->_sections['c']['index'] += $this->_sections['c']['step'], $this->_sections['c']['iteration']++):
$this->_sections['c']['rownum'] = $this->_sections['c']['iteration'];
$this->_sections['c']['index_prev'] = $this->_sections['c']['index'] - $this->_sections['c']['step'];
$this->_sections['c']['index_next'] = $this->_sections['c']['index'] + $this->_sections['c']['step'];
$this->_sections['c']['first']      = ($this->_sections['c']['iteration'] == 1);
$this->_sections['c']['last']       = ($this->_sections['c']['iteration'] == $this->_sections['c']['total']);
?>
      <?php $this->assign('arrListCalendar', $this->_tpl_vars['clsSettingCalendar']->getCalendarInLipeCN($this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'])); ?>

       <tr>
      		<td class="content_col" colspan="8" style="font-weight:bold; font-size:14px;"><?php echo $this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['fullname']; ?>
</td>
      </tr>
      
   		<tr>
        	<td class="gridheader">
            	<table cellspacing="0" cellpadding="0" border="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
            		<tr height="25" bgcolor="#f0f0f0">
                    	<?php unset($this->_sections['ca']);
$this->_sections['ca']['name'] = 'ca';
$this->_sections['ca']['loop'] = is_array($_loop=$this->_tpl_vars['arrListCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ca']['show'] = true;
$this->_sections['ca']['max'] = $this->_sections['ca']['loop'];
$this->_sections['ca']['step'] = 1;
$this->_sections['ca']['start'] = $this->_sections['ca']['step'] > 0 ? 0 : $this->_sections['ca']['loop']-1;
if ($this->_sections['ca']['show']) {
    $this->_sections['ca']['total'] = $this->_sections['ca']['loop'];
    if ($this->_sections['ca']['total'] == 0)
        $this->_sections['ca']['show'] = false;
} else
    $this->_sections['ca']['total'] = 0;
if ($this->_sections['ca']['show']):

            for ($this->_sections['ca']['index'] = $this->_sections['ca']['start'], $this->_sections['ca']['iteration'] = 1;
                 $this->_sections['ca']['iteration'] <= $this->_sections['ca']['total'];
                 $this->_sections['ca']['index'] += $this->_sections['ca']['step'], $this->_sections['ca']['iteration']++):
$this->_sections['ca']['rownum'] = $this->_sections['ca']['iteration'];
$this->_sections['ca']['index_prev'] = $this->_sections['ca']['index'] - $this->_sections['ca']['step'];
$this->_sections['ca']['index_next'] = $this->_sections['ca']['index'] + $this->_sections['ca']['step'];
$this->_sections['ca']['first']      = ($this->_sections['ca']['iteration'] == 1);
$this->_sections['ca']['last']       = ($this->_sections['ca']['iteration'] == $this->_sections['ca']['total']);
?>
                        <?php if ($this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['week_name'] != "Tổng"): ?>
                		<td align="center" colspan="4" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"><?php echo $this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['week_name']; ?>
<br>
                       <?php echo ((is_array($_tmp=$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
 -&gt; <?php echo ((is_array($_tmp=$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
)</td>
                       	<?php endif; ?>
                        <?php endfor; endif; ?>
                        <td align="center" colspan="6" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">Tuần tổng
                       </td>
                	</tr>
                	<tr height="25" bgcolor="#f0f0f0">
                    	<?php unset($this->_sections['ca']);
$this->_sections['ca']['name'] = 'ca';
$this->_sections['ca']['loop'] = is_array($_loop=$this->_tpl_vars['arrListCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ca']['show'] = true;
$this->_sections['ca']['max'] = $this->_sections['ca']['loop'];
$this->_sections['ca']['step'] = 1;
$this->_sections['ca']['start'] = $this->_sections['ca']['step'] > 0 ? 0 : $this->_sections['ca']['loop']-1;
if ($this->_sections['ca']['show']) {
    $this->_sections['ca']['total'] = $this->_sections['ca']['loop'];
    if ($this->_sections['ca']['total'] == 0)
        $this->_sections['ca']['show'] = false;
} else
    $this->_sections['ca']['total'] = 0;
if ($this->_sections['ca']['show']):

            for ($this->_sections['ca']['index'] = $this->_sections['ca']['start'], $this->_sections['ca']['iteration'] = 1;
                 $this->_sections['ca']['iteration'] <= $this->_sections['ca']['total'];
                 $this->_sections['ca']['index'] += $this->_sections['ca']['step'], $this->_sections['ca']['iteration']++):
$this->_sections['ca']['rownum'] = $this->_sections['ca']['iteration'];
$this->_sections['ca']['index_prev'] = $this->_sections['ca']['index'] - $this->_sections['ca']['step'];
$this->_sections['ca']['index_next'] = $this->_sections['ca']['index'] + $this->_sections['ca']['step'];
$this->_sections['ca']['first']      = ($this->_sections['ca']['iteration'] == 1);
$this->_sections['ca']['last']       = ($this->_sections['ca']['iteration'] == $this->_sections['ca']['total']);
?>
                        <?php if ($this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['week_name'] != "Tổng"): ?>
                        <?php $this->assign('count_quizweek', $this->_tpl_vars['clsSettingCalendar']->QuizPerWeek($this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['id'])); ?>
                        <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2">I</td>
                      	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2">P(<?php echo $this->_tpl_vars['count_quizweek']; ?>
)</td>
                       	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2">E</td>
                       	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2">H</td>
                        <?php endif; ?>
                        <?php endfor; endif; ?>
                        
                        <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2">Forum Post</td>
                        <td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2">H2472</td>
                      	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" colspan="2"><p>Số bài đã làm</p></td>
                                                
                	</tr>
                	<tr height="25" bgcolor="#f0f0f0">
                         <td align="center" width="217" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">P</td>
                         <td align="center" width="212" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC">E</td>
                         

                	</tr>
                    <tr height="25">
                    	<?php unset($this->_sections['ca']);
$this->_sections['ca']['name'] = 'ca';
$this->_sections['ca']['loop'] = is_array($_loop=$this->_tpl_vars['arrListCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ca']['show'] = true;
$this->_sections['ca']['max'] = $this->_sections['ca']['loop'];
$this->_sections['ca']['step'] = 1;
$this->_sections['ca']['start'] = $this->_sections['ca']['step'] > 0 ? 0 : $this->_sections['ca']['loop']-1;
if ($this->_sections['ca']['show']) {
    $this->_sections['ca']['total'] = $this->_sections['ca']['loop'];
    if ($this->_sections['ca']['total'] == 0)
        $this->_sections['ca']['show'] = false;
} else
    $this->_sections['ca']['total'] = 0;
if ($this->_sections['ca']['show']):

            for ($this->_sections['ca']['index'] = $this->_sections['ca']['start'], $this->_sections['ca']['iteration'] = 1;
                 $this->_sections['ca']['iteration'] <= $this->_sections['ca']['total'];
                 $this->_sections['ca']['index'] += $this->_sections['ca']['step'], $this->_sections['ca']['iteration']++):
$this->_sections['ca']['rownum'] = $this->_sections['ca']['iteration'];
$this->_sections['ca']['index_prev'] = $this->_sections['ca']['index'] - $this->_sections['ca']['step'];
$this->_sections['ca']['index_next'] = $this->_sections['ca']['index'] + $this->_sections['ca']['step'];
$this->_sections['ca']['first']      = ($this->_sections['ca']['iteration'] == 1);
$this->_sections['ca']['last']       = ($this->_sections['ca']['iteration'] == $this->_sections['ca']['total']);
?>
                        <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['arrUser'][0]['username'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['id'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'])); ?>
                        <?php $this->assign('count_practice_week', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['userid'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['start_date'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['end_date'])); ?>
                        <?php $this->assign('grades', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingGrades($this->_tpl_vars['userid'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['id'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'])); ?>
                        
                        <?php $this->assign('count_h2472', $this->_tpl_vars['clsSettingCalendar']->get2472($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['start_date'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['end_date'])); ?>
                        <?php if ($this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['week_name'] != "Tổng"): ?>
                		<td width="139" height="62" align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">&nbsp;<font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['count_post'] != 0): ?><?php echo $this->_tpl_vars['count_post']; ?>
<?php endif; ?></font></td>
                  		<td align="center" width="155" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><font style="color:#000; font-weight:bold;"><?php if ($this->_tpl_vars['count_practice_week'] != 0): ?><?php echo $this->_tpl_vars['count_practice_week']; ?>
<?php endif; ?></font></td>
                   		<td align="center" width="70" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">&nbsp;<?php if ($this->_tpl_vars['grades'] != 0): ?><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['grades']; ?>
</span> <?php else: ?>  <?php endif; ?></td>
                   		<td align="center" width="70" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><?php echo $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['start_date'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['end_date'],$this->_tpl_vars['userid']); ?>
&nbsp;</td>
                       	<?php endif; ?>
                        <?php endfor; endif; ?>
                        <!-- Tuan tong -->
                        <?php unset($this->_sections['ca']);
$this->_sections['ca']['name'] = 'ca';
$this->_sections['ca']['loop'] = is_array($_loop=$this->_tpl_vars['arrListCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ca']['show'] = true;
$this->_sections['ca']['max'] = $this->_sections['ca']['loop'];
$this->_sections['ca']['step'] = 1;
$this->_sections['ca']['start'] = $this->_sections['ca']['step'] > 0 ? 0 : $this->_sections['ca']['loop']-1;
if ($this->_sections['ca']['show']) {
    $this->_sections['ca']['total'] = $this->_sections['ca']['loop'];
    if ($this->_sections['ca']['total'] == 0)
        $this->_sections['ca']['show'] = false;
} else
    $this->_sections['ca']['total'] = 0;
if ($this->_sections['ca']['show']):

            for ($this->_sections['ca']['index'] = $this->_sections['ca']['start'], $this->_sections['ca']['iteration'] = 1;
                 $this->_sections['ca']['iteration'] <= $this->_sections['ca']['total'];
                 $this->_sections['ca']['index'] += $this->_sections['ca']['step'], $this->_sections['ca']['iteration']++):
$this->_sections['ca']['rownum'] = $this->_sections['ca']['iteration'];
$this->_sections['ca']['index_prev'] = $this->_sections['ca']['index'] - $this->_sections['ca']['step'];
$this->_sections['ca']['index_next'] = $this->_sections['ca']['index'] + $this->_sections['ca']['step'];
$this->_sections['ca']['first']      = ($this->_sections['ca']['iteration'] == 1);
$this->_sections['ca']['last']       = ($this->_sections['ca']['iteration'] == $this->_sections['ca']['total']);
?>
                         <?php $this->assign('count_practice', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['userid'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['start_date'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['end_date'])); ?>
                         <?php $this->assign('count_exam', $this->_tpl_vars['clsSettingCalendar']->CountExam($this->_tpl_vars['userid'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'])); ?>
                         <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['arrUser'][0]['username'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['id'],$this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'])); ?>
                        <?php if ($this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['week_name'] == "Tổng"): ?>
                        <td align="center" width="139" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">&nbsp;<font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?></font></td>
                    	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><?php echo $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['arrCourse'][$this->_sections['c']['index']]['id'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['start_date'],$this->_tpl_vars['arrListCalendar'][$this->_sections['ca']['index']]['end_date'],$this->_tpl_vars['userid']); ?>
</td>
                    	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">&nbsp;<span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_practice']; ?>
</span></td>
                    	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; "><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_exam']; ?>
</span></td>
                        
                    	
                        <?php endif; ?>
                          <?php endfor; endif; ?>                    
                	</tr>
                </table>
            </td>
   		</tr>
       
         
    <?php endfor; endif; ?>
  </table>
 

</div>
</body>
</html>