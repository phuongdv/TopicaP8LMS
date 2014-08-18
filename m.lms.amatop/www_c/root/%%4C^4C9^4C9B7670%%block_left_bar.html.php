<?php /* Smarty version 2.6.18, created on 2014-08-13 11:14:53
         compiled from blocks/block_left_bar.html */ ?>
<!-- Section Profile -->
<section id="profiles">
    <div><img class="img-profile" height="40px" width="40px" src="http://el.dtu.topica.edu.vn/user/pix.php?file=/<?php echo $this->_tpl_vars['userid']; ?>
/f1.jpg" alt="Profile Images"/><p><?php echo $this->_tpl_vars['OneMember']['firstname']; ?>
 <?php echo $this->_tpl_vars['OneMember']['lastname']; ?>
</p><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/logout.html">logout</a></div>        
</section>

<!-- Notification -->
<section>
<div>
<h2>Notifications</h2>
<nav>
    <ul>
        <!-- Use <span> in order to display a count -->
        <li><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/lttn.html" title="LTTN">Multiple choice practice<span><?php echo $this->_tpl_vars['number_lttn']; ?>
</span></a></li>
        <li><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/btvn.html" title="BTVN">Homework<span><?php echo $this->_tpl_vars['number_btvn']; ?>
</span></a></li>
        <!--<li><a href="notification.html" title="Bản tin lớp">Bản tin lớp <span>3</span></a></li>-->
    </ul>
</nav>
</div>
</section>

<!-- Course -->
<section>
<div>
<h2>Courses</h2>
<nav>
    <ul>
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
        <li><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/course-<?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['id']; ?>
.html" title="<?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['fullname']; ?>
"><?php echo $this->_tpl_vars['listCourse'][$this->_sections['id']['index']]['fullname']; ?>
</a></li>
        <?php endfor; endif; ?>
    </ul>
</nav>
</div>
</section>
    
<!-- Main Navigation -->
<section id="navigator">
<div>
<h2>Menu</h2>
<nav>
    <ul>
        <li class="active"><a href="index.html" title="Home">Home</a></li>
        <!-- Use <span> in order to display a count -->
        <li><a href="lipe.html" title="LIPE">Lipe</a></li>
        <!--<li><a href="list-course.html" title="Các khóa học">Các khóa học</a></li>-->
        <!--<li><a href="notification.html" title="Bản tin lớp">Bản tin lớp</a></li>-->
        <!--<li><a href="profile.html" title="Thông tin cá nhân">Thông tin cá nhân</a></li>-->
    </ul>
</nav>
</div>
</section>