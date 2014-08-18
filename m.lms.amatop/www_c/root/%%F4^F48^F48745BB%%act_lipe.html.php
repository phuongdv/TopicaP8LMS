<?php /* Smarty version 2.6.18, created on 2014-03-06 16:05:31
         compiled from home/act_lipe.html */ ?>
<!-- Sidebar Toggle & Tabbed Navigation -->
<header>
    <div class="controls">
        <a title="Toggle Sidebar"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/icon-toggle.png" alt="Toggle Sidebar"></a>
    </div>
    <div id="textLogo">
  <a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/index.html" title="Quay lại trang chủ">Topica Mobile Learning</a>
    </div>
</header>

<!-- Breadcrumb -->
<section id="breadcrumb">
<a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/index.html">Topica Mobile Learning</a>
› 
<a href="#">Lipe</a>
</section>

<!-- Main Content Area -->
<section id="main">
	<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['listCourse']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <?php $this->assign('calenda_tong', $this->_tpl_vars['clsSettingCalendar']->getTuanTong($this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
    <!-- Repeat this Area for Multiple Boxes -->
    <div class="module">
       <h4><a href="<?php echo $this->_tpl_vars['NV_CMS']; ?>
/course-<?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id']; ?>
.html"><?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['fullname']; ?>
</a></h4>
        <div>
            <table style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;" border="0" cellpadding="0" cellspacing="0" width="100%">
                <!--<tr height="25" bgcolor="#f0f0f0">
                <td colspan="6" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">Tổng kết                      </td>
                </tr>-->
                <tr height="25" bgcolor="#f0f0f0">
                <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2" align="center">Forum Post</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2" align="center">H2472</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" colspan="2" align="center"><p>Số bài tập đã làm</p></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" rowspan="2" align="center">Điểm CC</td>
                </tr>
                <tr height="25" bgcolor="#f0f0f0">
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="30%">Luyện tập trắc nghiệm</td>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="30%">Bài tập về nhà</td>
                </tr>
                <tr height="25">
                <!-- Tuan tong -->
                          <?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['userid'],$this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
                           <?php $this->assign('h2472', $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['calenda_tong'][0]['start_date'],$this->_tpl_vars['calenda_tong'][0]['end_date'],$this->_tpl_vars['userid'])); ?>
                          <?php $this->assign('mode', $this->_tpl_vars['clsmode']->getModeReport($this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
                         <?php $this->assign('count_practice', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['userid'],$this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['calenda_tong'][0]['start_date'],$this->_tpl_vars['calenda_tong'][0]['end_date'])); ?>
                         <?php $this->assign('count_exam', $this->_tpl_vars['clsSettingCalendar']->CountExam($this->_tpl_vars['userid'],$this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
                         <?php $this->assign('show_exam', $this->_tpl_vars['clsSettingCalendar']->get_bt_grade($this->_tpl_vars['userid'],$this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
                         <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['username'],$this->_tpl_vars['calenda_tong'][0]['id'],$this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
                         <?php $this->assign('diemcc', $this->_tpl_vars['clsOffline']->getCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'],$this->_tpl_vars['mode'])); ?>
                        <td align="center" width="15%" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">&nbsp;<font style="color:#00F; font-weight:bold;"><?php if ($this->_tpl_vars['count_post2'] != 0): ?><?php echo $this->_tpl_vars['count_post2']; ?>
<?php endif; ?></font></td>
                    	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; " width="15%"><?php echo $this->_tpl_vars['h2472']; ?>
</td>
                    	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; " width="30%">&nbsp;<span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_practice']; ?>
</span></td>
                    	<td align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; " width="30%"><span style="color:#F00; font-weight:bold"><?php echo $this->_tpl_vars['count_exam']; ?>
 <?php echo $this->_tpl_vars['show_exam']; ?>
</span></td>
                        
                    	
                        <td align="center" width="15%" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC; ">&nbsp;<font style="color:#00F; font-weight:bold;"><?php echo $this->_tpl_vars['diemcc']; ?>
</font></td>
                         
                </tr>
            </table>
            
            
            
        </div>
    </div>
    <?php endfor; endif; ?>
    
    
</section>