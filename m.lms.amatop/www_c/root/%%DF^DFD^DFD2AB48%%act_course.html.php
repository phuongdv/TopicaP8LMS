<?php /* Smarty version 2.6.18, created on 2014-08-13 15:36:27
         compiled from home/act_course.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'home/act_course.html', 28, false),array('modifier', 'md5', 'home/act_course.html', 84, false),)), $this); ?>
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
<a href="/index.html">Topica Mobile Learning</a>
› 
<a href="#"><?php echo $this->_tpl_vars['NameCourse']; ?>
</a>
</section>


	<?php if ($this->_tpl_vars['checkHocLieu'] == '1'): ?>
    	<section id="main">
			<div class="course_calendar">
			
                	<img class="calendar" alt="Lịch tuần" src="http://elearning.tvu.topica.vn/lich/calendar2.php?f=<?php echo $this->_tpl_vars['C_start']; ?>
&amp;l=<?php echo $this->_tpl_vars['C_end']; ?>
">
            </div>
            
				<!-- Repeat this Area for Multiple Boxes -->
				<div class="module">
					<h4><?php echo $this->_tpl_vars['arrCalendarTop'][0]['week_name']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['arrCalendarTop'][0]['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d/%m/%Y') : smarty_modifier_date_format($_tmp, '%d/%m/%Y')); ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['arrCalendarTop'][0]['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d/%m/%Y') : smarty_modifier_date_format($_tmp, '%d/%m/%Y')); ?>
)</h4>
					<div>
                    <img class="imgpe" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/lecture.gif" alt="Lecture"> 
                    <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['TuanHienTai']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
                    <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['lession'] != ''): ?>
	                	<h5 class="center-text"><?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['lession']; ?>
</h5>
                        <div class="container" style="overflow: hidden">
                            <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['pdf'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['pdf']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                          </div>
                          
                            <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['video_1'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a  href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/slide-<?php echo $this->_tpl_vars['c_id']; ?>
/week-<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['week']; ?>
/"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/slide.png"></a></em>
                          </div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['mp3'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/mp3-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['mp3']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/mp3.jpg"></a></em>
                          </div>
                            <?php endif; ?>
                          <!--<div class="column-two-one">
                            <em class="center-text"><a href="http://115.146.127.234/mdata/<?php echo $this->_tpl_vars['NameCourseS']; ?>
/<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['slide']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/slide.png"></a></em>
                          </div>-->
                            <?php endif; ?>
                             <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_1'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_1']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                          </div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_2'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_2']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                          </div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_3'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_3']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                          </div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_4'] != ''): ?>
                          <div class="column-two-one">
                            <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['TuanHienTai'][$this->_sections['j']['index']]['PDFTK_4']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                          </div>
                            <?php endif; ?>
                          
                        </div>
                    <?php endif; ?>
                    <?php endfor; endif; ?>
                    <?php $this->assign('PTuanHienTai', $this->_tpl_vars['core']->getPractive($this->_tpl_vars['c_id'],$this->_tpl_vars['arrCalendarTop'][0]['id'])); ?>
                    <?php if ($this->_tpl_vars['PTuanHienTai'] != '0'): ?>
                    <?php $this->assign('NameQuiz', $this->_tpl_vars['clsQuiz']->getName($this->_tpl_vars['PTuanHienTai'])); ?>
	                	<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/practice.gif" alt="Practice"> 
                    	<br/>
                    	<span class="pe">
                    		<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pe.gif"/><a href="http://elearning.tvu.topica.vn/mod/bt72/review_pr_mobile.php?q=<?php echo $this->_tpl_vars['PTuanHienTai']; ?>
&u=<?php echo $this->_tpl_vars['userid']; ?>
&c=<?php echo $this->_tpl_vars['c_id']; ?>
&s=<?php echo ((is_array($_tmp=$this->_tpl_vars['secret'])) ? $this->_run_mod_handler('md5', true, $_tmp) : md5($_tmp)); ?>
"><?php echo $this->_tpl_vars['NameQuiz']; ?>
</a> 
                    	</span>
                    <?php endif; ?>
                    <br/>
                   <img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/h2472.gif" alt="H2472" style="border:0;">
					<br/>
					<span class="pe">
						<a href="/h2472-<?php echo $this->_tpl_vars['c_id']; ?>
.html">Make questions with H2472</a>
					</span>
      				</div>
				</div>
                
				<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['listTuan']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <?php $this->assign('OneCalendar', $this->_tpl_vars['core']->getCalendar($this->_tpl_vars['listTuan'][$this->_sections['id']['index']]['week'],$this->_tpl_vars['c_id'])); ?>
                <?php $this->assign('InfoWeek', $this->_tpl_vars['core']->getInfoWeek($this->_tpl_vars['table_name'],$this->_tpl_vars['listTuan'][$this->_sections['id']['index']]['week'])); ?>
				<div class="module">
					<h4><?php if ($this->_tpl_vars['OneCalendar'][0]['week_name'] != ''): ?> <?php echo $this->_tpl_vars['OneCalendar'][0]['week_name']; ?>
 <?php else: ?> Tuần <?php echo $this->_tpl_vars['listTuan'][$this->_sections['id']['index']]['week']; ?>
<?php endif; ?>(<?php echo ((is_array($_tmp=$this->_tpl_vars['OneCalendar'][0]['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d/%m/%Y') : smarty_modifier_date_format($_tmp, '%d/%m/%Y')); ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['OneCalendar'][0]['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d/%m/%Y') : smarty_modifier_date_format($_tmp, '%d/%m/%Y')); ?>
)</h4>
					<div>
                   <img class="imgpe" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/lecture.gif" alt="Lecture"> 
                    <?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['InfoWeek']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    	<?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['lession'] != ''): ?>
                            
                            <h5 class="center-text"><?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['lession']; ?>
</h5>
                            <div class="container" style="overflow: hidden">
                                <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['pdf'] != ''): ?>
                              <div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['pdf']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                              </div>
                                <?php endif; ?>
                              
                                <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['video_1'] != ''): ?>
                              <!--<div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/slide-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['NameCourseS']; ?>
/<?php echo $this->_tpl_vars['listTuan'][$this->_sections['id']['index']]['slide']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/slide.png"></a></em>
                              </div>-->
                              <div class="column-two-one">
                                <em class="center-text"><a  href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/slide-<?php echo $this->_tpl_vars['c_id']; ?>
/week-<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['id']; ?>
/"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/slide.png"></a></em>
                              </div>
                                <?php endif; ?>
                                  <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['mp3'] != ''): ?>
                              <div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/mp3-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['mp3']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/mp3.jpg"></a></em>
                              </div>
                                <?php endif; ?>
                                 <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_1'] != ''): ?>
                              <div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_1']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                              </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_2'] != ''): ?>
                              <div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_2']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                              </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_3'] != ''): ?>
                              <div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_3']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                              </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_4'] != ''): ?>
                              <div class="column-two-one">
                                <em class="center-text"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/pdf-<?php echo $this->_tpl_vars['c_id']; ?>
/url=<?php echo $this->_tpl_vars['InfoWeek'][$this->_sections['k']['index']]['PDFTK_4']; ?>
"><img width="50" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pdf.jpg"></a></em>
                              </div>
                                <?php endif; ?>
                              
                            </div>
                    	<?php endif; ?>
                    <?php endfor; endif; ?>
                    
                    
                    <?php $this->assign('PlistTuan', $this->_tpl_vars['core']->getPractive($this->_tpl_vars['c_id'],$this->_tpl_vars['OneCalendar'][0]['id'])); ?>
                    <?php $this->assign('ElistTuan', $this->_tpl_vars['core']->getExam($this->_tpl_vars['c_id'],$this->_tpl_vars['OneCalendar'][0]['id'])); ?>
                    <?php if ($this->_tpl_vars['PlistTuan'] != '0'): ?>
                    <?php $this->assign('NameQuiz', $this->_tpl_vars['clsQuiz']->getName($this->_tpl_vars['PlistTuan'])); ?>
	                	<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/practice.gif" alt="Practice"> 
                    	<br/>
                    	<span class="pe">
                    		<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pe.gif"/><a href="http://elearning.tvu.topica.vn/mod/bt72/review_pr_mobile.php?q=<?php echo $this->_tpl_vars['PlistTuan']; ?>
&u=<?php echo $this->_tpl_vars['userid']; ?>
&c=<?php echo $this->_tpl_vars['c_id']; ?>
&s=<?php echo ((is_array($_tmp=$this->_tpl_vars['secret'])) ? $this->_run_mod_handler('md5', true, $_tmp) : md5($_tmp)); ?>
"><?php echo $this->_tpl_vars['NameQuiz']; ?>
</a> 
                    	</span>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['ElistTuan'] != '0'): ?>
                    <?php $this->assign('NameQuiz', $this->_tpl_vars['clsQuiz']->getName($this->_tpl_vars['ElistTuan'])); ?>
	                	<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/practice.gif" alt="Practice"> 
                    	<br/>
                    	<span class="pe">
                    		<img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/pe.gif"/><a href="http://elearning.tvu.topica.vn/mod/bt30/bt30_mobile.php?q=<?php echo $this->_tpl_vars['ElistTuan']; ?>
&u=<?php echo $this->_tpl_vars['userid']; ?>
&c=<?php echo $this->_tpl_vars['c_id']; ?>
&s=<?php echo ((is_array($_tmp=$this->_tpl_vars['secret'])) ? $this->_run_mod_handler('md5', true, $_tmp) : md5($_tmp)); ?>
"><?php echo $this->_tpl_vars['NameQuiz']; ?>
</a> 
                    	</span>
                    <?php endif; ?>
                    <br/>
                    <img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/h2472.gif" alt="H2472" style="border:0;">
					<br/>
					<span class="pe">
						<a href="/h2472-<?php echo $this->_tpl_vars['c_id']; ?>
.html">Make questions with H2472</a>
					</span>
      				</div>
				</div>
				<?php endfor; endif; ?>
				
			</section>
    
    <?php else: ?>
    	Class mobile interface is currently not supported, please come back later!
    <?php endif; ?>