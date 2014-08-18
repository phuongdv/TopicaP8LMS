<?php /* Smarty version 2.6.18, created on 2014-08-12 04:56:29
         compiled from index.html */ ?>
<!DOCTYPE html>
<html lang="en">
<head>




<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Topica Mobile Learning Assitant</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    
    <?php if ($this->_tpl_vars['act'] == 'viewmp3'): ?>
   <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/style.css" media="screen">
    <script src="<?php echo $this->_tpl_vars['URL_BUILD']; ?>
/jquery.js"></script>
    <script src="<?php echo $this->_tpl_vars['URL_BUILD']; ?>
/mediaelement-and-player.min.js"></script>
	<script src="<?php echo $this->_tpl_vars['URL_BUILD']; ?>
/testforfiles.js"></script>	
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['URL_BUILD']; ?>
/mediaelementplayer.min.css" />
    
    <?php else: ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/style.css" media="screen">



  

   
    <!-- JQuery -->
   
    <script src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/jquery.js"></script>
   <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['URL_CSS']; ?>
/colorbox.css" media="screen">
<script src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/jquery.colorbox.js"></script>
    <!-- 	
        Simple Carousel
        Copyright (c) 2010 Tobias Zeising, http://www.aditu.de
        Licensed under the MIT license
        
        http://code.google.com/p/simple-carousel
    -->
	<script src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/slider.js"></script>
	<!-- iOS4 Scrolling Fix -->
	<script src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/scrolling.js"></script>
	<!-- Script Controls -->
	<script src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/scripts.js"></script>
	<!--
		Change Color Scheme from Red to Blue, Green, Pink or Purple
		<link rel="stylesheet" type="text/css" href="css/blue.css" media="screen" />
	-->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    <!-- Chang URLs to wherever Video.js files will be hosted -->
   <?php endif; ?>
 </head>
<body>
<?php if ($this->_tpl_vars['act'] != 'viewpdf'): ?>
<div id="wrapper">
	<!-- Sidebar Begin -->
	<aside id="sidebar">
    	<div class="sidebar-scroll">
    	<?php if ($this->_tpl_vars['core']->hasPanel('L') == 1): ?>		  
            <?php echo $this->_tpl_vars['core']->showPanel('L'); ?>
										
        <?php endif; ?>
		</div>
	</aside>
	<!-- Sidebar End -->
	
	<!-- Main Content Begin -->
	<section id="content">
    	
		<div class="content-scroll">
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/index.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div style="clear:both;"></div>
			<footer>
            	
            	<?php if ($this->_tpl_vars['core']->template_exists(($this->_tpl_vars['mod'])."/_footer.html")): ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/_footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php else: ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
		
			</footer>
	
		</div>
	</section>
	<!-- Main Content End -->
		
</div>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod'])."/index.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<!--
<p id="back-top">
		<a href="#top"><span></span>Back to Top</a>
	</p>
	-->
</body></html>
<?php echo '

<script>

$(".iframe").colorbox({iframe:true, width:"100%", height:"80%"});
				
/*
$(document).ready(function(){

	// hide #back-top first
	//$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(\'#content\').scroll(function () {
			if ($(this).scrollTop() > 20) {
			  
				$(\'#back-top\').fadeIn();
			} else {
				$(\'#back-top\').fadeOut();
			}
		});

		// scroll body to 0px on click
		$(\'#back-top a\').click(function () {
			$(\'#content\').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
*/
</script>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(["setCookieDomain", "*.m.tvu.topica.vn"]);
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);
 
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://noc.tis.topica.vn/topica/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "26"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->

'; ?>