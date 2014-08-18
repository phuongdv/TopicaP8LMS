<?php /* Smarty version 2.6.18, created on 2014-08-13 12:02:53
         compiled from home/act_default.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'home/act_default.html', 35, false),array('modifier', 'html_entity_decode', 'home/act_default.html', 35, false),)), $this); ?>
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
<a href="#">Courses</a>
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
    <!-- Repeat this Area for Multiple Boxes -->
    <div class="module">
        <h4><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/course-<?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id']; ?>
.html"><?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['fullname']; ?>
</a></h4>
        <div>
<!--<strong>THÔNG TIN LỚP HỌC</strong><br>
                <ul>
                  <li>Môn  Pháp luật đại cương cho lớp O12 ngành Quản trị kinh doanh, lớp T4 ngành Tài chính ngân hàng và lớp F8-F9 ngành Kế toán.<br>
                </li>
                  <li>Giảng viên: Ths.Phạm Thị Mai Vui, Ths. Nguyễn Hoài Sơn - Luật sư Công ty Luật TNHH Châu Á.<br>
                </li>
                  <li>Phụ trách lớp: Lê Thị Ánh Ly (O12) - 08 667 214 93, Trần Thị Bích Hảo (T4) - 04 85855 621, Huỳnh Việt Lào (F8) - 08 6659 7647, Bùi Thị Minh Huệ (F9) - 04 8585 5761. </li>
              </ul>
                <strong>NHIỆM VỤ HỌC TẬP</strong><br>
                <p align="center">LỚP HỌC ĐÃ KẾT THÚC - ĐÃ THI HẾT MÔN</p>-->
			<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['summary'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'href', '') : smarty_modifier_replace($_tmp, 'href', '')))) ? $this->_run_mod_handler('html_entity_decode', true, $_tmp) : html_entity_decode($_tmp)); ?>

        </div>
    </div>
    <?php endfor; endif; ?>


</section>