<?php /* Smarty version 2.6.18, created on 2014-08-13 11:52:05
         compiled from home/act_lttn.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'md5', 'home/act_lttn.html', 32, false),)), $this); ?>
<!-- Sidebar Toggle & Tabbed Navigation -->
<header>
    <div class="controls">
        <a title="Toggle Sidebar"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/icon-toggle.png" alt="Toggle Sidebar"></a>
    </div>
    <div id="textLogo">
    <a href="/index.html" title="Quay lại trang chủ">Topica Mobile Learning</a>
    </div>
</header>

<!-- Breadcrumb -->
<section id="breadcrumb">
<a href="/index.html">Topica Mobile Learning</a>
› 
<a href="#">Multiple choice practice</a>
</section>

<!-- Main Content Area -->
<section id="main">

    <!-- Repeat this Area for Multiple Boxes -->
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
   
    <?php $this->assign('arrLTTN', $this->_tpl_vars['clsMdlCourse']->getArrLTTN($this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id'])); ?>
    
    <?php if ($this->_tpl_vars['arrLTTN'] != ''): ?>
    <div class="module">
        <h4><a href="<?php echo $this->_tpl_vars['NV_CMS']; ?>
/course-<?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id']; ?>
.html"><?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['fullname']; ?>
</a></h4>
        <div class="practice-list">
                <ul>
                	<?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['arrLTTN']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                  <li><a href="http://elearning.tvu.topica.vn/mod/bt72/review_pr_mobile.php?q=<?php echo $this->_tpl_vars['arrLTTN'][$this->_sections['k']['index']]['id']; ?>
&u=<?php echo $this->_tpl_vars['userid']; ?>
&c=<?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id']; ?>
&s=<?php echo ((is_array($_tmp=$this->_tpl_vars['secret'])) ? $this->_run_mod_handler('md5', true, $_tmp) : md5($_tmp)); ?>
"><?php echo $this->_tpl_vars['arrLTTN'][$this->_sections['k']['index']]['NAME']; ?>
</a></li>
                  	<?php endfor; endif; ?>
              </ul>
        </div>
    </div>
    <?php endif; ?>
    <?php endfor; endif; ?>
    
    

</section>