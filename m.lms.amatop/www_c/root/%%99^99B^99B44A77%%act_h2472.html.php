<?php /* Smarty version 2.6.18, created on 2014-03-06 16:06:00
         compiled from home/act_h2472.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'md5', 'home/act_h2472.html', 50, false),)), $this); ?>
<!DOCT
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
            <a href="#">H2472</a>
            </section>
			
			<!-- Main Content Area -->
			<section id="main">
			
				<!-- Repeat this Area for Multiple Boxes -->
				<div class="module">
					<h4><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/course-<?php echo $this->_tpl_vars['cid']; ?>
.html"><?php echo $this->_tpl_vars['NameCourse']; ?>
</a></h4>
					<div class="h2472">
			<div style="text-align:center" align="center"><h5><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/course-<?php echo $this->_tpl_vars['cid']; ?>
.html">Quay lại</a></h5></div>
<table summary="Summary of your previous attempts" id="box-table-h2472">
<thead>
<tr>
<th scope="col" align="center">Chủ đề</th>
<th scope="col" align="center">Độ trễ</th>
<th scope="col" align="center">Trạng thái</th>
</tr>
</thead>
<tbody>


<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['ArrH2472']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<tr>
<td><a href="http://elearning.tvu.topica.vn/h2472/mobile/detail.php?id=<?php echo $this->_tpl_vars['ArrH2472'][$this->_sections['id']['index']]['id']; ?>
" title=""><?php echo $this->_tpl_vars['ArrH2472'][$this->_sections['id']['index']]['answername']; ?>
</a></td>
<td><?php echo $this->_tpl_vars['clsH2472']->secondsToTime($this->_tpl_vars['ArrH2472'][$this->_sections['id']['index']]['delay']); ?>
</td>
<td align="center"><img height="15" width="15" align="absmiddle" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/<?php echo $this->_tpl_vars['ArrH2472'][$this->_sections['id']['index']]['status']; ?>
.png"></td>
</tr>
<?php endfor; endif; ?>

</tbody>
</table>

            <div class="trigger">
            	<a href="http://elearning.tvu.topica.vn/h2472/mobile/?u=<?php echo $this->_tpl_vars['uid']; ?>
&c=<?php echo $this->_tpl_vars['cid']; ?>
&s=<?php echo ((is_array($_tmp=$this->_tpl_vars['secret'])) ? $this->_run_mod_handler('md5', true, $_tmp) : md5($_tmp)); ?>
"  class="postnew">
				<h2>Đặt câu hỏi mới</h2>
				</a>
            </div>
            
      				</div>
				</div>
				
				
                
<table style="margin-left:auto; margin-right: auto; width: 100%;">
<thead>
<tr>
<th align="center"><img height="15" width="15" align="absmiddle" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/0.png">
  Mở</th>
<td align="center"><img height="15" width="15" align="absmiddle" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/3.png">
  Chờ trả lời</td>
<th align="center"><img height="15" width="15" align="absmiddle" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/2.png">
  Đã trả lời</th>
<th align="center"><img height="15" width="15" align="absmiddle" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/cdd.png">
  Chủ đề đóng</th>
</tr>
</thead>
</table>

			</section>
			