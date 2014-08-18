<?php /* Smarty version 2.6.18, created on 2013-05-14 11:29:04
         compiled from settingmode/act_default.html */ ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&amp;mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/folders.png" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:18px;"><b>Setting mode for Course <?php echo $this->_tpl_vars['arrOneCourse']['fullname']; ?>
</b></font><br />
<font style="font-size:9px"><i></i></font>
</td>
<td style="padding-right:10px; border-bottom:1px #CCCCCC solid;" align="right">
<div>
	<table cellpadding="2px" border="0">
	<tr>
		
	</tr>
	</table>
</div>
</td>
</tr>
</table>
<form name="theForm" action="" method="post">
<table width="100%" border="0">
<tr>
<td style="padding-left:10px;padding-right:10px" colspan="4">
	
</td>
</tr>
<tr>
<td style="padding-left:10px;padding-right:10px">
	
</td>
</tr>
<tr>

<td style="padding-left:10px;padding-right:10px" width="100%" valign="top">
 
	<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0">
 <tr>
    <td><div align="right">Mode hiện tại :  </div></td>
    <td><?php echo $this->_tpl_vars['currentmode']; ?>
</td>
  </tr>
  <tr>
    <td width="50%"><div align="right">Sửa Mode thành :  </div></td>
    <td width="50%">
      <label>
        <select name="mode" id="mode">
          <option value="1">Mode 1</option>
          <option value="2">Mode 2</option>
          <option value="3">Mode 3</option>
        </select>
      </label>
    </td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><span style="color : orange"><strong><?php echo $this->_tpl_vars['msg']; ?>
<strong></span></div></td>
    
  </tr>
  <tr>
    <td colspan="2"><label>
      <div align="center">
        <input type="submit" name="button" id="button" value="     Lưu     " />
      </div>
    </label></td>
  </tr>
</table>
</form>
</td>
</tr>
<tr>
	<td></td>
</tr>
</table>
</form>