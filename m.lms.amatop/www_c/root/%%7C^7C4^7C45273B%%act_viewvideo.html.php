<?php /* Smarty version 2.6.18, created on 2014-03-06 10:52:33
         compiled from home/act_viewvideo.html */ ?>
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
<a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/course-<?php echo $this->_tpl_vars['c_id']; ?>
.html"><?php echo $this->_tpl_vars['NameCourse']; ?>
</a>
</section>


<section id="main">
<div class="module">
	<div class="container" style="overflow: hidden">
    <h5 class="center-text"><?php echo $this->_tpl_vars['arrListVideo'][0]['lession']; ?>
</h5>
   

    	<?php if ($this->_tpl_vars['arrListVideo'][0]['video_1'] != ''): ?>
    	<div class="column-two-one-video">
        	<em class="center-text">Video 1<a href="<?php echo $this->_tpl_vars['arrListVideo'][0]['video_1']; ?>
"><img width="60" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/video-logo.jpg"></a>
            </em>
        </div>
		<?php endif; ?>
        <?php if ($this->_tpl_vars['arrListVideo'][0]['video_2'] != ''): ?>
    	<div class="column-two-one-video">
        	<em class="center-text">Video 2<a href="<?php echo $this->_tpl_vars['arrListVideo'][0]['video_2']; ?>
"><img width="60" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/video-logo.jpg"></a>
            </em>
        </div>
		<?php endif; ?>
        <?php if ($this->_tpl_vars['arrListVideo'][0]['video_3'] != ''): ?>
    	<div class="column-two-one-video">
        	<em class="center-text">Video 3<a href="<?php echo $this->_tpl_vars['arrListVideo'][0]['video_3']; ?>
"><img width="60" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/video-logo.jpg"></a>
            </em>
        </div>
		<?php endif; ?>
        <?php if ($this->_tpl_vars['arrListVideo'][0]['video_4'] != ''): ?>
    	<div class="column-two-one-video">
        	<em class="center-text">Video 4<a href="<?php echo $this->_tpl_vars['arrListVideo'][0]['video_4']; ?>
"><img width="60" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/video-logo.jpg"></a>
            </em>
        </div>
		<?php endif; ?>
        <?php if ($this->_tpl_vars['arrListVideo'][0]['video_5'] != ''): ?>
    	<div class="column-two-one-video">
        	<em class="center-text">Video 5<a href="<?php echo $this->_tpl_vars['arrListVideo'][0]['video_5']; ?>
"><img width="60" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/video-logo.jpg"></a>
            </em>
        </div>
		<?php endif; ?>
        <?php if ($this->_tpl_vars['arrListVideo'][0]['video_6'] != ''): ?>
    	<div class="column-two-one-video">
        	<em class="center-text">Video 6<a href="<?php echo $this->_tpl_vars['arrListVideo'][0]['video_6']; ?>
"><img width="60" alt="img" class="replace-2x" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/video-logo.jpg"></a>
            </em>
        </div>
		<?php endif; ?>
    	
        
    
   </div>
 </div>  

</section>