<?php /* Smarty version 2.6.18, created on 2013-10-15 15:40:38
         compiled from sms/act_check.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'sms/act_check.html', 7, false),)), $this); ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr style="background:#FBFBFB">
<td width="55px" style="border-bottom:1px #CCCCCC solid;">
<div style="padding:3px"><a href="?<?php echo $this->_tpl_vars['_SITE_ROOT']; ?>
&mod=<?php echo $this->_tpl_vars['mod']; ?>
"><img src="<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/largeicon/n-UserGroup-Quan-ly-nhom-nguoi-dung.gif" border="0"/></a></div>
</td>
<td style="color:#990000;border-bottom:1px #CCCCCC solid;">
<font style="font-size:24px;"><b><?php if ($this->_tpl_vars['_LANG_ID'] != 'vn'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['clsDataGrid']->getTitle())) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php else: ?><?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
<?php endif; ?></b></font><br />
<font style="font-size:9px"><i><?php if ($this->_tpl_vars['_LANG_ID'] != 'vn'): ?><?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
 <?php echo $this->_tpl_vars['core']->getLang('Management'); ?>
<?php else: ?><?php echo $this->_tpl_vars['core']->getLang('Management'); ?>
 <?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
<?php endif; ?></i></font>
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
	<strong><?php echo $this->_tpl_vars['core']->getLang(""); ?>
 <?php echo $this->_tpl_vars['clsDataGrid']->getTitle(); ?>
</strong>
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
  

'; ?>
</p>
<div align="left" style="padding-left:20px; font-family:Arial, Helvetica, sans-serif; font-size:9pt">
</div>
<?php if ($this->_tpl_vars['Is_Send'] == '0'): ?>
<p><b>KIỂM TRA LẠI THÔNG TIN TRƯỚC KHI GỬI</b></p>

<form method="post" name="frm_check" action="">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
    	<td class="gridrow1" style="padding-left:10px;padding-top:15px;">
            <b>Nội dung tin nhắn :</b><br />
           <p><?php echo $this->_tpl_vars['OneSmsInfo']['content']; ?>
</p><br/>
           <b>Lớp : </b>&nbsp; <?php echo $this->_tpl_vars['OneSmsInfo']['topica_lop']; ?>
<br />
           <b>Số ký tự :</b> &nbsp; <?php echo $this->_tpl_vars['OneSmsInfo']['so_ky_tu']; ?>
<br />
           <b>Số tin nhắn cần gửi : </b>&nbsp; <?php echo $this->_tpl_vars['count_send']; ?>
<br />
                   </td>
    </tr>
    <tr>
    	<td height="30"></td>
    </tr>
	<tr>
    	<td width="650" style="padding-left:10px;">
        	<!-- Left -->
        	<table cellpadding="0" cellspacing="0" border="0" width="680" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px;" align="center">
                <tr height="25" bgcolor="#f0f0f0">
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" >Danh sách số điện thoại</td>
                    
                </tr>
                
                <tr>
                    <td >
                    	<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['arrListUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                        	<span  style="color:#0000FF"><?php echo $this->_tpl_vars['clsMdl_User']->getNumberMobile($this->_tpl_vars['arrListUser'][$this->_sections['id']['index']]); ?>
</span>(<?php echo $this->_tpl_vars['clsMdl_User']->getName($this->_tpl_vars['arrListUser'][$this->_sections['id']['index']]); ?>
),
                        <?php endfor; endif; ?>
                    </td>
                </tr>
            </table>
            <!-- end left-->
        </td>
        <td>
        	
        </td>
    </tr>
    <tr>
    	<td height="30" colspan="2"></td>
    </tr>
    <tr>
	 
    	<td style="padding-left:30px;">
		<p class="error" style="font-weight:bold;color:red"><?php echo $this->_tpl_vars['error']; ?>
</p>
		<input class="btn-submit" type="submit" name="btnSignin" id="btnSignin" value="GỬI TIN" <?php echo $this->_tpl_vars['enable_send']; ?>
  style="width:180px;"/>
                    <input type="hidden" value="hi_check" name="hi_check" id="hi_check"></td>
        <td></td>
    </tr>


</form>
<?php else: ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="20">Tin nhắn đã được gửi</td>
    </tr>
		<tr>
    	<td height="20" align="center"><a href="/lipe">Quay lại</a></td>
    </tr>
</table>
<?php endif; ?>
