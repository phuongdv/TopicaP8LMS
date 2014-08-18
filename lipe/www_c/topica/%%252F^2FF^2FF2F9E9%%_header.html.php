<?php /* Smarty version 2.6.18, created on 2013-05-09 17:28:16
         compiled from _header.html */ ?>
<?php if ($this->_tpl_vars['mod'] != 'vbb' && $this->_tpl_vars['act'] != 'canhan' && $this->_tpl_vars['act'] != 'export'): ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td background="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/bg_header.gif" height="60" style="padding:5px">
	<table cellpadding="0" cellspacing="3" border="0" align="left">
	<tr>
		<td class="menubutton" id="m1" nowrap width="" onmouseover="this.className='menubuttonActive';" onmouseout="this.className='menubutton';" onclick="gotoUrl('?topica')" title="Home"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/house.png" border="0" align="left" >Trang chủ</td>
        <td class="menubutton" id="m1" nowrap width="" onmouseover="this.className='menubuttonActive';" onmouseout="this.className='menubutton';" onclick="gotoUrl('?topica&mod=vbb&start=0&end=50')" title="Home"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/house.png" border="0" align="left" >Học viên tích cực diễn đàn</td>
		<td class="menubutton" id="m2" nowrap width="" onmouseover="this.className='menubuttonActive';" onmouseout="this.className='menubutton';" onclick="gotoUrl('?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&mod=user&act=profile&id=<?php echo $this->_tpl_vars['core']->_SESS->id; ?>
')" title="Your Account"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/account.png" border="0" align="left">Tài khoản</td>			
		<td class="menubutton" nowrap width="" onmouseover="this.className='menubuttonActive';" onmouseout="this.className='menubutton';" onclick="return logout()"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/admin/close_16.png" border="0" align="left" />Thoát</td>
		
	</tr>
	</table>
	</td>
	<td>
	
	</td>
</tr>
</table>
<?php endif; ?>
