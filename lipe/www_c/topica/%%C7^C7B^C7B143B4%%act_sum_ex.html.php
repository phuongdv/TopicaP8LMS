<?php /* Smarty version 2.6.18, created on 2014-01-07 16:03:41
         compiled from act_sum_ex.html */ ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table width="1108" cellpadding="0" cellspacing="0">
  <col width="26" />
  <col width="54" />
  <col width="100" />
  <col width="51" />
  <col width="48" span="4" />
  <col width="50" />
  <col width="33" />
  <col width="30" />
  <col width="53" />
  <col width="38" />
  <col width="56" />
  <col width="38" />
  <col width="65" />
  <col width="55" />
  <tr>
    <td colspan="5" align="left" valign="top">
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="5" width="284"><div align="center" style="font-size:14px"><strong>TRƯỜNG ĐẠI HỌC KINH TẾ QUỐC DÂN<br />
            TRUNG TÂM ĐÀO TẠO TỪ XA</strong></div></td>
        </tr>
      </table></td>
    <td width="1"></td>
    <td width="48"></td>
    <td width="48"></td>
    <td colspan="9" width="435"></td>
  </tr>
  <tr>
    <td colspan="5"></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="9" width="435"><div align="center"><strong>DANH SÁCH THI VÀ BẢNG    ĐIỂM<br />
      LỚP HỌC PHẦN:.................................................</strong></div></td>
  </tr>
  <tr>
    <td colspan="5"> Lớp: &nbsp; &nbsp; <?php echo $this->_tpl_vars['lop']; ?>
 &nbsp; &nbsp; Hệ: ĐTTX (2012-2016)</td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="9">Ngày thi: ...... /..... / 20...                   Ca thi:    .........................................</td>
  </tr>
  <tr>
    <td colspan="5">Phòng thi/GĐ thi:    .........................................</td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="9">Địa điểm thi:    .........................................................................................</td>
  </tr>
  <tr>
    <td colspan="5">Thời gian học:    ..............................................</td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="9"></td>
  </tr>
</table>
<table width="1108" border="1" cellpadding="1" cellspacing="0">
  <col width="26" />
  <col width="64" />
  <col width="125" />
  <col width="64" />
  <col width="48" span="4" />
  <col width="64" />
  <col width="33" />
  <col width="30" />
  <col width="53" />
  <col width="38" />
  <col width="56" />
  <col width="38" />
  <col width="65" />
  <col width="55" />
  <tr>
    <td rowspan="2" width="26"><div align="center"><strong>TT</strong></div></td>
    <td rowspan="2" width="64"><div align="center"><strong>Mã số<br />
      SV/HV</strong></div></td>
    <td colspan="2" rowspan="2" width="189"><div align="center"><strong>Họ và tên</strong></div></td>
    <td rowspan="2" width="48"><div align="center"><strong>Điểm <br />
      đánh <br />
      giá <br />
      (10%)</strong></div></td>
    <td rowspan="2" width="48"><div align="center"><strong>Điểm BTVN1</strong></div></td>
    <td rowspan="2" width="48"><div align="center"><strong>Điểm BTVN2</strong></div></td>
    <td rowspan="2" width="48"><div align="center"><strong>Điểm BT nhóm</strong></div></td>
    <td rowspan="2" width="64"><div align="center"><strong>Điểm kiểm tra<br />
      (20%)</strong></div></td>
    <td colspan="5" width="210"><div align="center"><strong>Điểm    thi hết học phần<br />
      (70%)</strong></div></td>
    <td colspan="2" width="103"><div align="center"><strong>Điểm    học phần</strong></div></td>
    <td rowspan="2" width="55"><div align="center"><strong>Ghi<br />
      chú </strong></div></td>
  </tr>
  <tr>
    <td width="33"><div align="center"><strong>Số <br />
      đề</strong></div></td>
    <td width="30"><div align="center"><strong>Số <br />
      tờ</strong></div></td>
    <td width="53"><div align="center"><strong>Chữ<br />
      ký</strong></div></td>
    <td width="38"><div align="center"><strong>Bằng    số</strong></div></td>
    <td width="56"><div align="center"><strong>Bằng <br />
      chữ</strong></div></td>
    <td width="38"><div align="center"><strong>Bằng    số</strong></div></td>
    <td width="65"><div align="center"><strong>Bằng <br />
      chữ</strong></div></td>
  </tr>
  <tr>
    <td align="right"><div align="center">1</div></td>
    <td width="64"><div align="center">2</div></td>
    <td><div align="center">3</div></td>
    <td><div align="center">4</div></td>
    <td width="48"><div align="center">5</div></td>
    <td width="48"><div align="center">6</div></td>
    <td width="48"><div align="center">7</div></td>
    <td width="48"><div align="center">8</div></td>
    <td width="64"><div align="center">9</div></td>
    <td width="33"><div align="center">10</div></td>
    <td width="30"><div align="center">11</div></td>
    <td width="53"><div align="center">12</div></td>
    <td width="38"><div align="center">13</div></td>
    <td width="56"><div align="center">14</div></td>
    <td width="38"><div align="center">15</div></td>
    <td width="65"><div align="center">16</div></td>
    <td width="55"><div align="center">17</div></td>
  </tr>
  <?php unset($this->_sections['sv']);
$this->_sections['sv']['name'] = 'sv';
$this->_sections['sv']['loop'] = is_array($_loop=$this->_tpl_vars['arrUser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sv']['show'] = true;
$this->_sections['sv']['max'] = $this->_sections['sv']['loop'];
$this->_sections['sv']['step'] = 1;
$this->_sections['sv']['start'] = $this->_sections['sv']['step'] > 0 ? 0 : $this->_sections['sv']['loop']-1;
if ($this->_sections['sv']['show']) {
    $this->_sections['sv']['total'] = $this->_sections['sv']['loop'];
    if ($this->_sections['sv']['total'] == 0)
        $this->_sections['sv']['show'] = false;
} else
    $this->_sections['sv']['total'] = 0;
if ($this->_sections['sv']['show']):

            for ($this->_sections['sv']['index'] = $this->_sections['sv']['start'], $this->_sections['sv']['iteration'] = 1;
                 $this->_sections['sv']['iteration'] <= $this->_sections['sv']['total'];
                 $this->_sections['sv']['index'] += $this->_sections['sv']['step'], $this->_sections['sv']['iteration']++):
$this->_sections['sv']['rownum'] = $this->_sections['sv']['iteration'];
$this->_sections['sv']['index_prev'] = $this->_sections['sv']['index'] - $this->_sections['sv']['step'];
$this->_sections['sv']['index_next'] = $this->_sections['sv']['index'] + $this->_sections['sv']['step'];
$this->_sections['sv']['first']      = ($this->_sections['sv']['iteration'] == 1);
$this->_sections['sv']['last']       = ($this->_sections['sv']['iteration'] == $this->_sections['sv']['total']);
?>
  <tr>
    <td align="center"><?php echo $this->_sections['sv']['index']; ?>
</td>
    <td><?php echo $this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['topica_msv']; ?>
</td>
    <td><?php echo $this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['lastname']; ?>
</td>
    <td><?php echo $this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['firstname']; ?>
</td>
    <td align="center">
		<?php unset($this->_sections['calendar']);
$this->_sections['calendar']['name'] = 'calendar';
$this->_sections['calendar']['loop'] = is_array($_loop=$this->_tpl_vars['arrSettingCalendar']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['calendar']['show'] = true;
$this->_sections['calendar']['max'] = $this->_sections['calendar']['loop'];
$this->_sections['calendar']['step'] = 1;
$this->_sections['calendar']['start'] = $this->_sections['calendar']['step'] > 0 ? 0 : $this->_sections['calendar']['loop']-1;
if ($this->_sections['calendar']['show']) {
    $this->_sections['calendar']['total'] = $this->_sections['calendar']['loop'];
    if ($this->_sections['calendar']['total'] == 0)
        $this->_sections['calendar']['show'] = false;
} else
    $this->_sections['calendar']['total'] = 0;
if ($this->_sections['calendar']['show']):

            for ($this->_sections['calendar']['index'] = $this->_sections['calendar']['start'], $this->_sections['calendar']['iteration'] = 1;
                 $this->_sections['calendar']['iteration'] <= $this->_sections['calendar']['total'];
                 $this->_sections['calendar']['index'] += $this->_sections['calendar']['step'], $this->_sections['calendar']['iteration']++):
$this->_sections['calendar']['rownum'] = $this->_sections['calendar']['iteration'];
$this->_sections['calendar']['index_prev'] = $this->_sections['calendar']['index'] - $this->_sections['calendar']['step'];
$this->_sections['calendar']['index_next'] = $this->_sections['calendar']['index'] + $this->_sections['calendar']['step'];
$this->_sections['calendar']['first']      = ($this->_sections['calendar']['iteration'] == 1);
$this->_sections['calendar']['last']       = ($this->_sections['calendar']['iteration'] == $this->_sections['calendar']['total']);
?>
	  <?php if ($this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['week_name'] == 'Tổng'): ?>
	  <?php $this->assign('count_post2', $this->_tpl_vars['clsSettingCalendar']->getRelationCalendarAndLipesettingVBB($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['username'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
	  <?php $this->assign('h2472', $this->_tpl_vars['clsSettingCalendar']->countPostInWeekH2472($this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['end_date'],$this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'])); ?>
	  <?php $this->assign('count_practice', $this->_tpl_vars['clsSettingCalendar']->CountPractice($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['start_date'],$this->_tpl_vars['arrSettingCalendar'][$this->_sections['calendar']['index']]['end_date'])); ?>				
	 <?php endif; ?>
	
	<?php endfor; endif; ?>
	
	
	<?php $this->assign('offline', $this->_tpl_vars['clsOffline']->getOffline($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'])); ?>
	<?php $this->assign('diemcc', $this->_tpl_vars['clsOffline']->getCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'],$this->_tpl_vars['mode'])); ?>
	 <?php $this->assign('chitietdiemcc', $this->_tpl_vars['clsOffline']->showGetCc($this->_tpl_vars['offline'],$this->_tpl_vars['count_post2'],$this->_tpl_vars['h2472'],$this->_tpl_vars['count_practice'])); ?>
	<?php echo $this->_tpl_vars['diemcc']; ?>

	</td>
   <td align="center"><?php $this->assign('btvn1', $this->_tpl_vars['clsSettingCalendar']->getbtvn($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'],1)); ?> <?php echo $this->_tpl_vars['btvn1']; ?>
</td>
		<td align="center">
		
		<?php $this->assign('btvn2', $this->_tpl_vars['clsSettingCalendar']->getbtvn($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'],2)); ?> <?php echo $this->_tpl_vars['btvn2']; ?>

		</td>
		 
		<td align="center"><?php $this->assign('btvn', $this->_tpl_vars['clsOffline']->getBt($this->_tpl_vars['arrUser'][$this->_sections['sv']['index']]['id'],$this->_tpl_vars['c_id'])); ?> <?php echo $this->_tpl_vars['btvn']; ?>
</td>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php endfor; endif; ?>
 
</table>
<table cellspacing="0" cellpadding="0" width="1108px">
  <col width="26" />
  <col width="64" />
  <col width="125" />
  <col width="64" />
  <col width="48" span="4" />
  <col width="64" />
  <col width="33" />
  <col width="30" />
  <col width="53" />
  <col width="38" />
  <col width="56" />
  <col width="38" />
  <col width="65" />
  <col width="55" />
  <tr>
    <td colspan="10">Tổng số người dự thi:................... Số bài:........... Số    tờ:..............</td>
    <td width="217">&nbsp;</td>
    <td colspan="6">Hà Nội, ngày .....    tháng ..... năm 20...</td>
  </tr>
  <tr>
    <td colspan="11"><em>(Không bổ sung    thêm các trường hợp học ghép, thi ghép vào DS này)</em></td>
    <td colspan="6"><div align="center">Thư ký vào điểm</div></td>
  </tr>
  <tr>
    <td colspan="2">Giáo viên CN</td>
    <td colspan="6">Xác nhận của CB giảng dạy:</td>
    <td colspan="3"><div align="right">Cán bộ coi thi 1:</div></td>
    <td colspan="6"></td>
  </tr>
  <tr>
    <td width="69"></td>
    <td width="30"></td>
    <td width="33"></td>
    <td width="43"></td>
    <td width="81"></td>
    <td width="1"></td>
    <td width="1"></td>
    <td width="23"></td>
    <td width="1"></td>
    <td width="174"></td>
    <td></td>
    <td width="396"></td>
    <td width="6"></td>
    <td width="6"></td>
    <td width="6"></td>
    <td width="6"></td>
    <td width="13"></td>
  </tr>
  <tr>
    <td height="108" colspan="2"></td>
    <td colspan="3"></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="3"><div align="right">Cán bộ coi thi 2:</div></td>
    <td colspan="6"><div align="center">Xác nhận của Trung tâm ĐT Từ xa:</div></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="41"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="6"></td>
  </tr>
</table>