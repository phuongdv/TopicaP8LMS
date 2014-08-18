<?php /* Smarty version 2.6.18, created on 2013-06-03 14:33:29
         compiled from _login/index.html */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  
  <title>Topica System 1.0</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/logo.jpg" />

  <?php echo '
  <style type="text/css">

body {
  margin: 5px 15px 0px 15px;
  font-family:arial,sans-serif;
  background-color: #ffffff;
  font-size: 80%;
}

table.header {
  margin-bottom: 0.4em;
}

.smallfont {
  font-size: 80%;
  padding: 10px;
}

#gaia_loginbox {
  margin-top: 0.5em;
}

#gaia_loginform {
  margin: 0;
}

a:link, a:active, a:visited {
  color:#0000CC
}

.form-noindent {
  cell-padding:1px;
  background-color: #c3d9ff;
  border: #3366cc 1px solid;
}

li {
  margin-bottom: 1em;
}

h1 {
  font-weight: bold;
  font-size: 130%;
}

.header h1 {
  border-bottom: solid 1px #bbbbbb;
  padding-bottom: 5px;
  
    margin: 0 0 0 15px;
  
}

h2 {
  margin: 0 0 0 0;
  font-weight: bold;
  font-size: 120%;
}

.loginBox {
  padding: 0 0 20px;
  margin: 0px;
  text-align: center;
}

.loginBox h2 {
  margin:0 0 0 0;
  font-weight: bold;
  font-size: 120%;
}

.loginBox table {
  margin: 0px auto;
  text-align: left;
}
.loginBox table td {
  padding-bottom: 0.2em;
}

.loginBox .gaia.le.rem {
  font-size: 80%;
}

#alBoxWrap {
  margin-top: 10px;
}

.alBox {
  padding: 5px 10px;
  margin: 0px;
}

.alBox h4 {
  margin: 0px;
  font-size: 80%;
}

.errormsg {
  color: #cc0000
}
.alert {
  color: #FF0000;

}
.sites-teaser {
  margin-top: 2em;
  padding: .5em;
  background-color: #ffffee;
  border: 1px solid #eeee00;
}
div.errormsg { color: red; font-size: smaller; font-family:arial,sans-serif; }
  font.errormsg { color: red; font-size: smaller; font-family:arial,sans-serif; }  
 
 .gaia.le.lbl { font-family: Arial, Helvetica, sans-serif; font-size: smaller; }
.gaia.le.fpwd { font-family: Arial, Helvetica, sans-serif; font-size: 70%; }
.gaia.le.chusr { font-family: Arial, Helvetica, sans-serif; font-size: 70%; }
.gaia.le.val { font-family: Arial, Helvetica, sans-serif; font-size: smaller; }
.gaia.le.button { font-family: Arial, Helvetica, sans-serif; font-size: smaller; }
.gaia.le.rem { font-family: Arial, Helvetica, sans-serif; font-size: smaller; }

.gaia.captchahtml.desc { font-family: arial, sans-serif; font-size: smaller; } 
.gaia.captchahtml.cmt { font-family: arial, sans-serif; font-size: smaller; font-style: italic; }
 .f {border-top: solid 1px #bbbbbb; color: #676767;
  font-size: 90%; padding-top: 5px; margin-top:15px}
  .f span {position: relative; bottom: 7px}


</style>
'; ?>

</head>
<body  >
<div id="main">
<table class="header" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign="bottom" width="94"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/logo.png" alt="Topica"></td>
		<td valign="bottom">
            <h1>
              Welcome to
              TOPICA - TVU
            </h1>
		</td>
   </tr>
</table>
<table class="container" border="0" cellpadding="1" cellspacing="1" width="90%">
	<tr>
  		<td align="center" valign="top">
        <div id="gaia_loginbox">
		<form action="" method="post" name="frmLogin" id="frmLogin">
			<table class="form-noindent" border="0" cellpadding="5" cellspacing="3" width="100%">
  				<tr>
  					<td style="text-align: center;" bgcolor="#c3d9ff" nowrap="nowrap" valign="top">
  					<div class="loginBox">
  						<table id="gaia_table" align="center" border="0" cellpadding="1" cellspacing="0">
  							<tr>
								<td height="20"></td>
							</tr>
  							<tr>
								<td class="smallfont" colspan="2" align="center">
 								<h2>TOPICA - TVU </h2>Topica System 1.0
                                </td>
							</tr>
 							<tr>
								<td height="25"></td>
							</tr>
                            <tr>
                              <td colspan="2" align="center">
                              </td>
                            </tr>
							<tr>
                              <td nowrap="nowrap">
                              <div align="right">
                              <span class="gaia le lbl">
                              Username:
                              </span>
                              </div>
                              </td>
                              <td>
                              <input type="text" name="txtUsername" id="txtUsername" value="<?php echo $this->_tpl_vars['txtUsername']; ?>
" size="18" class="gaia le val" >
                              
                              </td>
                            </tr>
                            <tr>
                                  <td></td>
                                  <td style="overflow: hidden; color: rgb(68, 68, 68); font-size: 75%;" dir="ltr" align="right"></td>
                                  <td></td>
                            </tr>
                            <tr>
                                  <td></td>
                                  <td align="left"></td>
                            </tr>
                            <tr>
                                <td align="right" nowrap="nowrap"><span class="gaia le lbl">Password:</span></td>
                                <td><input type="password" name="txtPassword" id="txtPassword" size="18" class="gaia le val" ></td>
                            </tr>
                            <tr>
                                  <td></td>
                                  <td align="left"></td>
                            </tr>   
                            <tr>
                                  <td></td>
                                  <td align="left"><input type="submit" src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/btnlogin.jpg" name="btnLogin" value="  Login  " style="border:1px solid #cccccc"></td>
                            </tr>
                            <tr id="ga-fprow">
                                <td colspan="2" class="gaia le fpwd" align="center" height="33.0" valign="bottom"></td>
                            </tr>
                            <tr>
                                <td height="10" colspan="2"><?php if ($this->_tpl_vars['isValid'] == 0): ?><font style="font-size:11px;color:red">InCorrect! Please try again!</font><?php endif; ?></td>
                            </tr>
                    </table>
  					</div>
  					</td>
  				</tr>
			</table>
		</form>
		</div>
        </td>
  		<td class="smallfont" valign="top" width="100%">
            <h2>
              Hệ thống quản lý sinh viên, giáo viên.
            </h2>
            <p>
              Chào mừng bạn đến với Topica System 1.0. Đây là hệ thống quản lý sinh viên, giáo viên và các bộ phận khác.
            </p>
            <ul>
              <li>
              Quản lý hồ sơ sinh viên.
              </li>
              <li>
              Quản lý, phân lớp, nhóm.
              </li>
              <li>
              Lịch giảng dạy dành cho giáo viên
              </li>
            </ul>
              <p class="sites-teaser">
              <b><span class="alert">New!</span>&nbsp;Đã có tài liệu hướng dẫn quản lý hệ thống Topica System<a href="http://topica.edu.vn">Link</a></b><br>
              Với tài liệu này, các quản trị viên có thể nhanh chóng nắm bắt và quản lý nhanh chóng, chính xác.<br>
              
              </p>
  		</td>
  </tr>
</table>
 
  <!-- footer -->
<table class="f" border="0" cellpadding="0" cellspacing="0" width="100%">
 	<tr>
  		<td valign="bottom">
          <span>©2009 Topica&nbsp;&nbsp;
          <a href="#">Privacy Policy</a>
          -
          <a href="#">Terms of Service</a>
          </span>
        </td>
  		<td align="right" valign="bottom">
  			<span>Powered by </span>
  			<a href="http://topica.edu.vn"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/logo.png" height="30" alt="Topica" border="0"></a>
  
  		</td>
 	 </tr>
</table>
</div>
<script>document.frmLogin.txtUsername.focus();</script>
</body>
</html>