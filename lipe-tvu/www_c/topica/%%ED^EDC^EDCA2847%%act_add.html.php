<?php /* Smarty version 2.6.18, created on 2013-05-10 11:00:47
         compiled from offline/act_add.html */ ?>
<div align="center">

<form name="theForm" action="?topica&mod=offline&act=insert&c_id=<?php echo $this->_tpl_vars['c_id']; ?>
" method="post">
<table width="83%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:9pt">
  <tr align="center">
    <td colspan="2" rowspan="2" bgcolor="#CCCCCC">H&#7885; v&agrave; t&ecirc;n <?php echo $this->_tpl_vars['lop']; ?>
</td>
    <td width="18%" rowspan="2" bgcolor="#CCCCCC"> M&atilde; h&#7885;c vi&ecirc;n </td>
    <td width="18%" bgcolor="#CCCCCC">L&#7899;p</td>
    <td width="31%" rowspan="2" bgcolor="#CCCCCC">Nh&oacute;m</td>
    <td width="8%" rowspan="2" bgcolor="#CCCCCC">S&#7889; bu&#7893;i &#273;i Offline</td>
    <td width="5%" rowspan="2" bgcolor="#CCCCCC">&#272;i&#7875;m b&agrave;i t&#7853;p k&#7929; n&#259;ng ho&#7863;c b&agrave;i t&#7853;p nh&oacute;m</td>
  </tr>
  <tr align="center">
    <td bgcolor="#CCCCCC"><label>
    <select name="select2" style="border: 1px solid  #999; width: 200px;"onchange="javascript:window.open(this.options[this.selectedIndex].value,'_self')">
      <option value="?topica&amp;mod=offline&amp;act=add&amp;c_id=<?php echo $this->_tpl_vars['c_id']; ?>
">-- T&#7845;t c&#7843; --</option>
      
      
      
                 <?php $this->assign('arrClass', $this->_tpl_vars['clsOffline']->GetClass($this->_tpl_vars['c_id'])); ?>
                  
                 <?php unset($this->_sections['cl']);
$this->_sections['cl']['name'] = 'cl';
$this->_sections['cl']['loop'] = is_array($_loop=$this->_tpl_vars['arrClass']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cl']['show'] = true;
$this->_sections['cl']['max'] = $this->_sections['cl']['loop'];
$this->_sections['cl']['step'] = 1;
$this->_sections['cl']['start'] = $this->_sections['cl']['step'] > 0 ? 0 : $this->_sections['cl']['loop']-1;
if ($this->_sections['cl']['show']) {
    $this->_sections['cl']['total'] = $this->_sections['cl']['loop'];
    if ($this->_sections['cl']['total'] == 0)
        $this->_sections['cl']['show'] = false;
} else
    $this->_sections['cl']['total'] = 0;
if ($this->_sections['cl']['show']):

            for ($this->_sections['cl']['index'] = $this->_sections['cl']['start'], $this->_sections['cl']['iteration'] = 1;
                 $this->_sections['cl']['iteration'] <= $this->_sections['cl']['total'];
                 $this->_sections['cl']['index'] += $this->_sections['cl']['step'], $this->_sections['cl']['iteration']++):
$this->_sections['cl']['rownum'] = $this->_sections['cl']['iteration'];
$this->_sections['cl']['index_prev'] = $this->_sections['cl']['index'] - $this->_sections['cl']['step'];
$this->_sections['cl']['index_next'] = $this->_sections['cl']['index'] + $this->_sections['cl']['step'];
$this->_sections['cl']['first']      = ($this->_sections['cl']['iteration'] == 1);
$this->_sections['cl']['last']       = ($this->_sections['cl']['iteration'] == $this->_sections['cl']['total']);
?>
                 <?php if ($this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop'] == $this->_tpl_vars['lop']): ?>
                  <option selected="selected" value="?topica&mod=offline&act=add&c_id=<?php echo $this->_tpl_vars['c_id']; ?>
&cls=<?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
"><?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
</option>
                  <?php else: ?>
                   <option value="?topica&mod=offline&act=add&c_id=<?php echo $this->_tpl_vars['c_id']; ?>
&cls=<?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
"><?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
</option>
      
      
                   <?php endif; ?>
                  <?php endfor; endif; ?>
                  
    
    
    
    </select>
    </label></td>    
  </tr>
   <?php unset($this->_sections['u']);
$this->_sections['u']['name'] = 'u';
$this->_sections['u']['loop'] = is_array($_loop=$this->_tpl_vars['arrUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['u']['show'] = true;
$this->_sections['u']['max'] = $this->_sections['u']['loop'];
$this->_sections['u']['step'] = 1;
$this->_sections['u']['start'] = $this->_sections['u']['step'] > 0 ? 0 : $this->_sections['u']['loop']-1;
if ($this->_sections['u']['show']) {
    $this->_sections['u']['total'] = $this->_sections['u']['loop'];
    if ($this->_sections['u']['total'] == 0)
        $this->_sections['u']['show'] = false;
} else
    $this->_sections['u']['total'] = 0;
if ($this->_sections['u']['show']):

            for ($this->_sections['u']['index'] = $this->_sections['u']['start'], $this->_sections['u']['iteration'] = 1;
                 $this->_sections['u']['iteration'] <= $this->_sections['u']['total'];
                 $this->_sections['u']['index'] += $this->_sections['u']['step'], $this->_sections['u']['iteration']++):
$this->_sections['u']['rownum'] = $this->_sections['u']['iteration'];
$this->_sections['u']['index_prev'] = $this->_sections['u']['index'] - $this->_sections['u']['step'];
$this->_sections['u']['index_next'] = $this->_sections['u']['index'] + $this->_sections['u']['step'];
$this->_sections['u']['first']      = ($this->_sections['u']['iteration'] == 1);
$this->_sections['u']['last']       = ($this->_sections['u']['iteration'] == $this->_sections['u']['total']);
?>
    <?php if ($this->_sections['u']['index']%2 == '0'): ?>
  <tr>
    <?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
    <?php $this->assign('btvn', $this->_tpl_vars['clsOffline']->getBt($this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
    <td width="19%"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['lastname']; ?>
</td>
    <td width="10%"> <?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['firstname']; ?>
</td>
    <td align="center"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['username']; ?>
</td>
    <td align="center"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['topica_lop']; ?>
</td>
    <td align="center"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['topica_nhom']; ?>
 </td>
    <td align="center"><label>
      
      <select name="lstOff<?php echo $this->_sections['u']['index']; ?>
" id="lstOff<?php echo $this->_sections['u']['index']; ?>
">
      
        <option selected="selected" value="0">0</option>
        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
$this->_sections['foo']['start'] = $this->_sections['foo']['step'] > 0 ? 0 : $this->_sections['foo']['loop']-1;
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = $this->_sections['foo']['loop'];
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
        <?php if ($this->_sections['foo']['iteration'] != ($this->_tpl_vars['offline'])): ?>
    <option value="<?php echo $this->_sections['foo']['iteration']; ?>
"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
    	<?php else: ?>
        	<option value="<?php echo $this->_sections['foo']['iteration']; ?>
" selected="selected"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
        <?php endif; ?>
       <?php endfor; endif; ?>
       
            </select>
      <input type="hidden" name="userId<?php echo $this->_sections['u']['index']; ?>
" id="userId<?php echo $this->_sections['u']['index']; ?>
" value="<?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['id']; ?>
" />
    </label></td>
    <td align="center"><label>
        <select name="lstBt<?php echo $this->_sections['u']['index']; ?>
" id="lstBt<?php echo $this->_sections['u']['index']; ?>
">
       <option selected="selected" value="0">0</option>
        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['loop'] = is_array($_loop=10) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
$this->_sections['foo']['start'] = $this->_sections['foo']['step'] > 0 ? 0 : $this->_sections['foo']['loop']-1;
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = $this->_sections['foo']['loop'];
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
        <?php if ($this->_sections['foo']['iteration'] != ($this->_tpl_vars['btvn'])): ?>
    <option value="<?php echo $this->_sections['foo']['iteration']; ?>
"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
    	<?php else: ?>
        	<option value="<?php echo $this->_sections['foo']['iteration']; ?>
" selected="selected"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
        <?php endif; ?>
       <?php endfor; endif; ?>
       
      </select>
    </label></td>
  </tr>
  <?php else: ?>
     <tr>
    <?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
    <?php $this->assign('btvn', $this->_tpl_vars['clsOffline']->getBt($this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
    <td width="19%" bgcolor="#99CCCC"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['lastname']; ?>
</td>
    <td width="10%" bgcolor="#99CCCC"> <?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['firstname']; ?>
</td>
    <td align="center" bgcolor="#99CCCC"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['username']; ?>
</td>
    <td align="center" bgcolor="#99CCCC"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['topica_lop']; ?>
</td>
    <td align="center" bgcolor="#99CCCC"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['topica_nhom']; ?>
 </td>
    <td align="center" bgcolor="#99CCCC"><label>
      
      <select name="lstOff<?php echo $this->_sections['u']['index']; ?>
" id="lstOff<?php echo $this->_sections['u']['index']; ?>
">
      
        <option selected="selected" value="0">0</option>
        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
$this->_sections['foo']['start'] = $this->_sections['foo']['step'] > 0 ? 0 : $this->_sections['foo']['loop']-1;
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = $this->_sections['foo']['loop'];
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
        <?php if ($this->_sections['foo']['iteration'] != ($this->_tpl_vars['offline'])): ?>
    <option value="<?php echo $this->_sections['foo']['iteration']; ?>
"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
    	<?php else: ?>
        	<option value="<?php echo $this->_sections['foo']['iteration']; ?>
" selected="selected"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
        <?php endif; ?>
       <?php endfor; endif; ?>
       
            </select>
      <input type="hidden" name="userId<?php echo $this->_sections['u']['index']; ?>
" id="userId<?php echo $this->_sections['u']['index']; ?>
" value="<?php echo $this->_tpl_vars['arrUser'][$this->_sections['u']['index']]['id']; ?>
" />
    </label></td>
    <td align="center" bgcolor="#99CCCC"><label>
        <select name="lstBt<?php echo $this->_sections['u']['index']; ?>
" id="lstBt<?php echo $this->_sections['u']['index']; ?>
">
       <option selected="selected" value="0">0</option>
        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['loop'] = is_array($_loop=10) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
$this->_sections['foo']['start'] = $this->_sections['foo']['step'] > 0 ? 0 : $this->_sections['foo']['loop']-1;
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = $this->_sections['foo']['loop'];
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
        <?php if ($this->_sections['foo']['iteration'] != ($this->_tpl_vars['btvn'])): ?>
    <option value="<?php echo $this->_sections['foo']['iteration']; ?>
"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
    	<?php else: ?>
        	<option value="<?php echo $this->_sections['foo']['iteration']; ?>
" selected="selected"><?php echo $this->_sections['foo']['iteration']; ?>
</option>
        <?php endif; ?>
       <?php endfor; endif; ?>
       
      </select>
    </label></td>
  </tr>
  <?php endif; ?>
  <?php endfor; endif; ?>
</table>
<div align="right">
  <label>
  <input type="submit" name="vvv" id="vvv" value="     Save    " />
  </label>
  </form>
</div>