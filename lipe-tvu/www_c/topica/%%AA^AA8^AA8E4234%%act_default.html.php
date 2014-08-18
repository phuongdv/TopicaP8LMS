<?php /* Smarty version 2.6.18, created on 2013-07-10 16:17:48
         compiled from vbb/act_default.html */ ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/n-UserGroup-Quan-ly-nhom-nguoi-dung.gif" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:24px;"><b></b></font><br />
<font style="font-size:9px"><i></i></font>
</td>
<td style="padding-right:10px; border-bottom:1px #CCCCCC solid;" align="right">

</td>
</tr>
</table>

<table width="100%" border="0">
<tr>
<td style="padding-left:10px;padding-right:10px">
	<div style="padding-bottom:5px;font-size:14px">
	<strong>Danh sách học viên tích cực diễn đàn</strong>: <strong><a href="?topica&mod=vbb&start=0&end=50" style="text-decoration:underline; font-family:Arial, Helvetica, sans-serif;">Top 50</a></strong>&nbsp;&nbsp;<strong><a href="?topica&mod=vbb&start=50&end=50" style="text-decoration:underline; font-family:Arial, Helvetica, sans-serif;">50 - 100</a></strong>&nbsp;&nbsp;<strong><a href="?topica&mod=vbb&start=100&end=50" style="text-decoration:underline; font-family:Arial, Helvetica, sans-serif;">100 - 150</a></strong>&nbsp;&nbsp;<strong><a href="?topica&mod=vbb&start=150&end=50" style="text-decoration:underline; font-family:Arial, Helvetica, sans-serif;">150 - 200</a></strong>
	</div><div style="float:left;"><a href="<?php echo $this->_tpl_vars['NVCMS_URL']; ?>
/?topica&mod=vbb&act=export&start=<?php echo $this->_tpl_vars['start']; ?>
&end=<?php echo $this->_tpl_vars['end']; ?>
" style="font-size: 12px; font-family: Arial,Helvetica,sans-serif; font-weight: bold; text-decoration: none; color: rgb(51, 51, 51);"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/export.jpg" align="absmiddle" border="0">XUẤT RA EXCEL</a></div>
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



<table cellpadding="0" cellspacing="0" border="0" width="80%" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px;" align="center">
	<tr height="25" bgcolor="#f0f0f0">
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">STT</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="left">Họ và tên</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Lớp</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Nhóm</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Thành phố</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Account (đăng nhập lớp học)</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Tổng số chung</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Diễn đàn học tập</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Diễn đàn giao lưu</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Hoạt động ngoại khóa</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Hỗ trợ kỹ thuật</td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" >Hội Trường</td>
    </tr>
    <?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <?php if ($this->_sections['id']['index']%2 == '0'): ?>
    	<?php $this->assign('Tong', $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['posts']); ?>
    	<?php $this->assign('GiaoLuu', $this->_tpl_vars['clsVbbUser']->countPostGiaoLuu($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        <?php $this->assign('NgoaiKhoa', $this->_tpl_vars['clsVbbUser']->countPostNgoaiKhoa($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        <?php $this->assign('KyThuat', $this->_tpl_vars['clsVbbUser']->countPostHTKyThuat($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        <?php $this->assign('HoiTruong', $this->_tpl_vars['clsVbbUser']->countPostHoiTruong($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        
    <tr height="25" >
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><?php echo $this->_sections['id']['index']+1; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="left"><a href="http://www.topica.vn/elearning/user/view.php?id=<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
" target="_blank" style="text-decoration:none;"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
&nbsp;<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</a></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['city']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><b><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['posts']; ?>
</b></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['Tong']-$this->_tpl_vars['GiaoLuu']-$this->_tpl_vars['NgoaiKhoa']-$this->_tpl_vars['KyThuat']-$this->_tpl_vars['HoiTruong']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['GiaoLuu']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['NgoaiKhoa']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['KyThuat']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" ><?php echo $this->_tpl_vars['HoiTruong']; ?>
</td>
    </tr>
    <?php elseif ($this->_sections['id']['index']%2 == '1'): ?>
    	<?php $this->assign('Tong', $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['posts']); ?>
    	<?php $this->assign('GiaoLuu', $this->_tpl_vars['clsVbbUser']->countPostGiaoLuu($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop'],$this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        <?php $this->assign('NgoaiKhoa', $this->_tpl_vars['clsVbbUser']->countPostNgoaiKhoa($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        <?php $this->assign('KyThuat', $this->_tpl_vars['clsVbbUser']->countPostHTKyThuat($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
        <?php $this->assign('HoiTruong', $this->_tpl_vars['clsVbbUser']->countPostHoiTruong($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username'])); ?>
    <tr height="25" bgcolor="#d2d2fb" >
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><?php echo $this->_sections['id']['index']+1; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="left"><a href="http://www.topica.vn/elearning/user/view.php?id=<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
" target="_blank" style="text-decoration:none;"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
&nbsp;<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</a></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['city']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['username']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><b><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['posts']; ?>
</b></td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['Tong']-$this->_tpl_vars['GiaoLuu']-$this->_tpl_vars['NgoaiKhoa']-$this->_tpl_vars['KyThuat']-$this->_tpl_vars['HoiTruong']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['GiaoLuu']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['NgoaiKhoa']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['KyThuat']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; " align="center" ><?php echo $this->_tpl_vars['HoiTruong']; ?>
</td>
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