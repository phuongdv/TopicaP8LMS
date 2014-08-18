<?php /* Smarty version 2.6.18, created on 2014-01-14 14:03:26
         compiled from home/act_viewmp3.html */ ?>

<!-- Sidebar Toggle & Tabbed Navigation -->
<header>
    <div class="controls">
        <a title="Toggle Sidebar"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/icon-toggle.png" alt="Toggle Sidebar"></a>
    </div>
    <div id="textLogo">
<a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/index.html" title="Quay lại trang chủ">Mobile Learning Assitant</a>
    </div>
</header>

<!-- Breadcrumb -->
<section id="breadcrumb">
<a href="/index.html">Mobile Learning Assitant</a>
› 
<a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/course-<?php echo $this->_tpl_vars['c_id']; ?>
.html"><?php echo $this->_tpl_vars['NameCourse']; ?>
</a>
</section>




<section id="main">


<audio id="player2" src="<?php echo $this->_tpl_vars['link']; ?>
" type="audio/mp3" controls="controls">		
</audio>	
<script>
$('audio,video').mediaelementplayer();
</script>

</section>