<?php /* Smarty version 2.6.18, created on 2013-07-10 16:17:52
         compiled from vbb/act_export.html */ ?>
<table cellpadding="0" cellspacing="0" border="0" width="80%" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px;" align="center">
	<tr height="25" bgcolor="#f0f0f0">
    	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center">STT</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="left">Họ và tên</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Lớp</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" >Nhóm</td>
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
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="left"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
&nbsp;<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
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
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="left"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
&nbsp;<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
</td>
        <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
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