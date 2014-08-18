<?php /* Smarty version 2.6.18, created on 2014-08-13 11:03:49
         compiled from member/act_login.html */ ?>
<script language="javascript" src="<?php echo $this->_tpl_vars['URL_JS']; ?>
/check_login.js"></script>
<!-- Sidebar Toggle & Tabbed Navigation -->
<header>
    <div id="textLogo">
    <a href="#" title="">Topica Mobile Learning</a>
    </div>
</header>



<!-- Main Content Area -->
<section id="main">

    <!-- Repeat this Area for Multiple Boxes -->
    <div class="module login-modul">
        <h4 class="center-text">Login</h4>
        <div>
        
        <div class="login">
        <form name="frmLogin" method="POST" action="">
			<input type="hidden" value="kvqji8h9mpacnl5hbj61qj1r80" name="MoodleSession">
			<input type="hidden" value="kvqji8h9mpacnl5hbj61qj1r80" name="MoodleSession">
			<label for="username">Username</label>
  			<input type="text" value="" size="15" id="username" name="username">
			<label for="password">Password</label>
  			<input type="password" value="" size="15" id="password" name="password"><br/>
			<span class="center-text">
            <input type="hidden" name="doLogin" value="signin" />
			<input type="submit" value="Login" onclick="return checkLogin();">
			<input type="hidden" value="1" name="testcookies">
			</span>
		</form>
        </div>                    
        
        </div>
    </div>
    
                    
</section>

<!-- Copyright Information -->