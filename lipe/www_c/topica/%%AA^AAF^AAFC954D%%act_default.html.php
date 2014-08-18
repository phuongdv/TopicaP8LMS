<?php /* Smarty version 2.6.18, created on 2013-10-10 22:29:39
         compiled from lipe/act_default.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'html_entity_decode', 'lipe/act_default.html', 119, false),array('modifier', 'strip_tags', 'lipe/act_default.html', 119, false),)), $this); ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/n-UserGroup-Quan-ly-nhom-nguoi-dung.gif" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:24px;"><b>F100 – Quản lý lớp môn
</b></font><br />
<font style="font-size:9px"><i></i></font>
</td>
<td style="padding-right:10px; border-bottom:1px #CCCCCC solid;" align="right">
<div>
	<table cellpadding="2px" border="0">
	<tr>
		<?php echo $this->_tpl_vars['clsButtonNav']->render(); ?>
		
	</tr>
	</table>
</div>
</td>
</tr>
</table>

<table width="100%" border="0">
<tr>
<td style="padding-left:10px;padding-right:10px">
	<div style="padding-bottom:5px;font-size:14px">
	
	</div>
</td>
</tr>
<tr>
<td style="padding-left:10px;padding-right:10px" width="100%" valign="top">
</td>
</tr>
<tr>
<td  style="padding-left:10px;padding-right:10px">
	
</td>
</tr>
</table>

<p><?php echo '
  <script language="javascript">
	function searchDetail(field,e) {
	var frm = document.frmSearchDetail;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13) {
		if(frm.keyword.value == "") {
			alert("Xin vui lòng nhập vào từ khóa tìm kiếm !");
			frm.keyword.focus();
			return false;
		}
		
		frm.action = \'?topica&mod=lipe&act=search&keyword=\'+frm.keyword.value;
		frm.submit();
		return true;
	}
}

function checkSearchDetail() {
	var frm = document.frmSearchDetail;
	
	if(frm.keyword.value == "") {
		alert("Xin vui lòng nhập vào từ khóa tìm kiếm !");
		frm.keyword.focus();
		retval = false;
		return false;
	}
	
	
	window.location.href = \'?topica&mod=lipe&act=search&keyword=\'+frm.keyword.value;		
	return true;
}
  </script>
'; ?>
</p>
<div align="left" style="padding-left:20px; font-family:Arial, Helvetica, sans-serif; font-size:9pt">
11-04-2012 : Thông báo<br>
- Thêm chức năng add mode cho lớp môn.<br>
- TẤT CẢ CÁC LỚP MÔN POVH ĐỀU PHẢI THIẾT LẬP MODE.<br>
- Nếu lớp môn nào chưa thiết lập mode đề nghị gửi phản hồi ngay cho Việt Hà qua email hatvv@topica.edu.vn hoặc điện thoại 0983.061.583.<br>
- Các phần Settting Calendar và Setting Lipe không có gì thay đổi.<br>
Ghi chú:<br>
- M_CoOffline: là mode 1 trước đây<br>
- M_KoOffline_CoDienDan: là mode 2 trước đây<br>
- M_KoOffline_KoDienDan: là mode 3 trước đây<br>
</div>
<p>&nbsp;</p>
<form name="frmSearchDetail" id="frmSearchDetail" method="post" action="">
<table width="80%" height="40" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
    	<td >
        	<input type="text" name="keyword" id="keyword" onkeypress="javascript:return searchDetail(this,event);" style="width:240px; border:1px solid #F00;" value="<?php echo $this->_tpl_vars['keyword']; ?>
"/> <!--<input name="" type="submit" value="Search"   />--><a href="#" onclick="return checkSearchDetail();" class="find_sim">
                    <img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/b-search.jpg" border="0" align="absmiddle" />
                    </a>
        </td>
    </tr>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="80%" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px;" align="center">
	<tr height="25" bgcolor="#f0f0f0">
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">ID</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">Tên lớp</td>
                <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">Chế độ xem</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">Calendar</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150">Lipe</td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150">View Report</td>
         <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150">Số buổi đi 0ffline</td>
		 <td style=" border-bottom:dashed 1px #CCC; " align="center" width="50">Dịch vụ SMS</td>
    </tr>
    <?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrCourse']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <?php $this->assign('mode', $this->_tpl_vars['clsMode']->getMode($this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id'])); ?>
    <?php if ($this->_sections['id']['index']%2 == '0'): ?>
    <tr height="25" >
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">	<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['fullname'])) ? $this->_run_mod_handler('html_entity_decode', true, $_tmp) : html_entity_decode($_tmp)))) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</td>
         <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150"><a href="javascript:void(0)"
onclick="window.open('?topica&mod=settingmode&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
',
'Setting Mode ','width=800,height=400,menubar=yes,status=yes')"  style="text-decoration:none" ><?php echo $this->_tpl_vars['mode']; ?>
</a></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150"><a href="?topica&mod=settingcalendar&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none" >Calendar</a></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150"><a href="?topica&mod=settinglipe&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none">Lipe</a></td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150"><a href="?topica&mod=lipe&act=report&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none">Xem báo cáo</a></td>
         <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150"><a href="?topica&mod=offline&act=add&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none" target="_blank">0ffline</a></td>
         <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150"><a href="?topica&mod=sms&act=default&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none" >SMS</a></td>
   
   </tr>
    <?php elseif ($this->_sections['id']['index']%2 == '1'): ?>
    <tr height="25" bgcolor="#d2d2fb" >
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">	<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['fullname'])) ? $this->_run_mod_handler('html_entity_decode', true, $_tmp) : html_entity_decode($_tmp)))) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</td>
         <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150"><a href="javascript:void(0)"
onclick="window.open('?topica&mod=settingmode&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
',
'Setting Mode ','width=800,height=400,menubar=yes,status=yes')"  style="text-decoration:none" ><?php echo $this->_tpl_vars['mode']; ?>
</a></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150"><a href="?topica&mod=settingcalendar&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none">Calendar</a></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="150"><a href="?topica&mod=settinglipe&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none">Lipe</a></td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150"><a href="?topica&mod=lipe&act=report&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none">Xem báo cáo</a></td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150"><a href="?topica&mod=offline&act=add&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none" target="_blank">0ffline</a></td>
     <td style=" border-bottom:dashed 1px #CCC; " align="center" width="150"><a href="?topica&mod=sms&act=default&c_id=<?php echo $this->_tpl_vars['arrCourse'][$this->_sections['id']['index']]['id']; ?>
" style="text-decoration:none" >SMS</a></td>

	</tr>
    <?php endif; ?>
    <?php endfor; endif; ?>
    <tr>
    	<td colspan="5" height="20"></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="20"></td>
    </tr>
</table>