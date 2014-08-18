<?php /* Smarty version 2.6.18, created on 2014-03-31 17:11:33
         compiled from sms/act_default.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'sms/act_default.html', 7, false),array('modifier', 'html_entity_decode', 'sms/act_default.html', 221, false),array('modifier', 'strip_tags', 'sms/act_default.html', 221, false),)), $this); ?>
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
  <script>

//Check all radio/check buttons script- by javascriptkit.com
//Visit JavaScript Kit (http://javascriptkit.com) for script
//Credit must stay intact for use  

function CheckAll() {
	 var fmobj = document.frm_check;
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != \'allbox\') && (e.type==\'checkbox\') && (!e.disabled)) {
			 e.checked = fmobj.allbox.checked;
		 }
	 }
	 return true;
}

</script>
<SCRIPT LANGUAGE="JavaScript">
	/*
	Created by: Will Bontrager 
	Web Site: http://willmaster.com/
*/


/* For additional information about this JavaScript
and how to use it, see the "Displaying Number of Words
Typed Into Form Fields" article, linked from the archives
at from http://willmaster.com/possibilities/archives/
The above note and the copyright line must remain with
this JavaScript source code. Comments below this point
in the code may be removed if desired.
*/
// Customizing this JavaScript code requires specifying eight values.

// Value One:
// Specify the maximum number of characters the form field
// may contain. If you have no maximum, specify 0 (zero).

var MaximumCharacters = "160";

// Value Two:
// Specify the maximum number of words the form field may
// contain. If you have no maximum, specify 0 (zero).

var MaximumWords = "100";

// Value Three:
// Specify the form\'s name (provided by the name="_____"
// attribute in the FORM tag).

var FormName = "frm_check";

// Value Four:
// Specify the name of the text field being monitored
// (provided by the name="_____" attribute in the
// INPUT or TEXTARE tag).

var TextFieldName = "TextField";

// Value Five:
// Specify the field name where where is to be displayed
// the number of characters the user has typed. Make
// it blank (nothing between the quotation marks) if
// you aren\'t displaying the number of characters typed.

var CharactersTypedFieldName = "CharsTyped";

// Value Six:
// Specify the field name where where is to be displayed
// the number of characters left that may be typed.
// Make it blank (nothing between the quotation marks)
// if you aren\'t displaying the number of characters
// left.

var CharactersLeftFieldName = "CharsLeft";

// Value Seven:
// Specify the field name where where is to be displayed
// the number of words the user has typed. Make it
// blank (nothing between the quotation marks) if you
// aren\'t displaying the number of words typed.

var WordsTypedFieldName = "WordsTyped";

// Value Eight:
// Specify the field name where where is to be displayed
// the number of words left that may be typed. Make it
// blank (nothing between the quotation marks) if you
// aren\'t displaying the number of words left.

var WordsLeftFieldName = "WordsLeft";

//////////////////////////////////////////////////////
//                                                  //
//  No modfications are required below this point.  //
//                                                  //
//////////////////////////////////////////////////////

var WordsMonitor = 0;
var MaxWords = parseInt(MaximumWords);
var MaxChars = parseInt(MaximumCharacters);
var textfield = \'document.\' + FormName + \'.\' + TextFieldName + \'.value\';

function WordLengthCheck(s,l) {
WordsMonitor = 0;
var f = false;
var ts = new String();
for(var vi = 0; vi < s.length; vi++) {
	vs = s.substr(vi,1);
	if((vs >= \'A\' && vs <= \'Z\') || (vs >= \'a\' && vs <= \'z\') || (vs >= \'0\' && vs <= \'9\')) {
		if(f == false)	{
			f = true;
			WordsMonitor++;
			if((l > 0) && (WordsMonitor > l)) {
				s = s.substring(0,ts.length);
				vi = s.length;
				WordsMonitor--;
				}
			}
		}
	else { f = false; }
	ts += vs;
	}
return s;
} // function WordLengthCheck()

function CharLengthCheck(s,l) {
if(s.length > l) { s = s.substring(0,l); }
return s;
} // function CharLengthCheck()

function InputCharacterLengthCheck() {
if(MaxChars <= 0) { return; }
var currentstring = new String();
eval(\'currentstring = \' + textfield);
var currentlength = currentstring.length;
eval(\'currentstring = CharLengthCheck(\' + textfield + \',\' + MaxChars + \')\');
if(CharactersLeftFieldName.length > 0) {
	var left = 0;
	eval(\'left = \' + MaxChars + \' - \' + textfield + \'.length\');
	if(left < 0) { left = 0; }
	eval(\'document.\' + FormName + \'.\' + CharactersLeftFieldName + \'.value = \' + left);
	if(currentstring.length < currentlength) { eval(textfield + \' = currentstring.substring(0)\'); }
	}
if(CharactersTypedFieldName.length > 0) {
	eval(\'document.\' + FormName + \'.\' + CharactersTypedFieldName + \'.value = \' + textfield + \'.length\');
	if(currentstring.length < currentlength) { eval(textfield + \' = currentstring.substring(0)\'); }
	}
} // function InputCharacterLengthCheck()

function InputWordLengthCheck() {
if(MaxWords <= 0) { return; }
var currentstring = new String();
eval(\'currentstring = \' + textfield);
var currentlength = currentstring.length;
eval(\'currentstring = WordLengthCheck(\' + textfield + \',\' + MaxWords + \')\');
if (WordsLeftFieldName.length > 0) {
	var left = MaxWords - WordsMonitor;
	if(left < 0) { left = 0; }
	eval(\'document.\' + FormName + \'.\' + WordsLeftFieldName + \'.value = \' + left);
	if(currentstring.length < currentlength) { eval(textfield + \' = currentstring.substring(0)\'); }
	}
if (WordsTypedFieldName.length > 0) {
	eval(\'document.\' + FormName + \'.\' + WordsTypedFieldName + \'.value = \' + WordsMonitor);
	if(currentstring.length < currentlength) { eval(textfield + \' = currentstring.substring(0)\'); }
	}
} // function InputWordLengthCheck()

function InputLengthCheck() {
InputCharacterLengthCheck();
InputWordLengthCheck();
} // function InputLengthCheck()


	 </script>
'; ?>
</p>
<div align="left" style="padding-left:20px; font-family:Arial, Helvetica, sans-serif; font-size:9pt">
</div>
<p><b>Lớp môn : <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['LopMon'])) ? $this->_run_mod_handler('html_entity_decode', true, $_tmp) : html_entity_decode($_tmp)))) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</b></p>
<form method="post" name="frm_search1" action="">
<table width="80%" height="40" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
    	<td  style="width:260px"><label>Chọn lớp quản lý:</label>
        	<select name="lop" style="border: 1px solid  #999; width: 200px;">
                 
                 <option value="0">Tất cả</option>
                <?php $this->assign('arrClass', $this->_tpl_vars['clsSettingCalendar']->GetClass($this->_tpl_vars['c_id'])); ?>
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
                  <option value="<?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
" selected="selected"><?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
</option>
                  <?php else: ?>
                   <option value="<?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
"><?php echo $this->_tpl_vars['arrClass'][$this->_sections['cl']['index']]['topica_lop']; ?>
</option>
                   <?php endif; ?>
                  <?php endfor; endif; ?>
             </select>
        </td>
        <td style="width:290px"><label>Chọn bài tập học viên chưa làm :</label>
        	<select name="quiz" style="border: 1px solid  #999; width: 200px;">
                 
                 <option value="0">Tất cả</option>
                
                 <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['arrQuiz']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                 
                  <?php if ($this->_tpl_vars['arrQuiz'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['quiz']): ?>
                  <option value="<?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['i']['index']]['id']; ?>
" selected="selected"><?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['i']['index']]['name']; ?>
</option>
                  <?php else: ?>
                   <option value="<?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['arrQuiz'][$this->_sections['i']['index']]['name']; ?>
</option>
                   <?php endif; ?>
                  <?php endfor; endif; ?>
             </select>
             <input type="hidden" value="hi_feed" name="hi_feed" id="hi_feed">
        </td>
        <td>
        <input style="background: url(<?php echo $this->_tpl_vars['URL_IMAGES']; ?>
/b-search-sms1.jpg) no-repeat; border: none; color: #FFFFFF;font-weight: bold;font-size: 11px;width: 89px;height: 22px;cursor: pointer;" type="submit" class="" value="" id="btnSubmit" name="btnSubmit" >
        
        </td>
        <td>
        </td>
    </tr>
</table>
</form>
<form method="post" name="frm_check" action="">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
    	<td colspan="2" style="color:#F00; font-size:14px; font-weight:bold;" align="center" height="30"><?php echo $this->_tpl_vars['showalert']; ?>
</td>
    </tr>
	<tr>
    	<td width="650" style="padding-left:10px;" valign="top">
        	<!-- Left -->
        	<table cellpadding="0" cellspacing="0" border="0" width="680" style="border: solid 1px #CCC; font-family:Tahoma, Geneva, sans-serif; font-size:12px;" align="center">
                <tr height="25" bgcolor="#f0f0f0">
                    <td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center"><input type="checkbox" onclick="return CheckAll()" value="0" name="allbox"></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="100" >Họ</td>
                            <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="40">Tên</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="80">Nhóm/Lớp</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="80">Ngày sinh</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="80">Mã sinh viên</td>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="80">Số điện thoại</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" width="100">Trạng thái SMS</td>
                </tr>
                <?php if ($this->_tpl_vars['quiz'] != '0' || $this->_tpl_vars['quiz'] != ''): ?>
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
                <?php $this->assign('checkDoQuiz', $this->_tpl_vars['clsSettingCalendar']->checkDoQuiz($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'],$this->_tpl_vars['quiz'])); ?>
                <?php $this->assign('checksdt', $this->_tpl_vars['core']->checknumbermobile($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai'])); ?>
                <?php $this->assign('smsinfo', $this->_tpl_vars['clsSmsSend']->getHistory($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'])); ?>
                <?php if ($this->_tpl_vars['checkDoQuiz'] == '0'): ?>
                <tr height="25" >
                    <td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><input type="checkbox"  name="chkexpert[]"  value="<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
"  align="right" /></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
</td>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  ><a href="http://elearning.tvu.topica.vn/course/user.php?id=<?php echo $this->_tpl_vars['c_id']; ?>
&user=<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
&mode=outline" target="_blank"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</a></td>
                    
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php if ($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom'] != ''): ?><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
/<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
<?php else: ?> None/<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
 <?php endif; ?></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['ngaysinh']; ?>
&nbsp;</td>
                    <td  align="center" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_msv']; ?>
</td>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php if ($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai'] != ''): ?><?php if ($this->_tpl_vars['checksdt'] == '1'): ?><span style="color:#009900;"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai']; ?>
</span>&nbsp;<?php else: ?><span style="color:#FF0000"> <?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai']; ?>
&nbsp;</span> <?php endif; ?><?php else: ?> <span style="color:#F00;">Chưa cập nhật</span> <?php endif; ?></td>
                     <td style=" border-bottom:dashed 1px #CCC; "  align="center" width="120">
                     	<?php if ($this->_tpl_vars['smsinfo'] != ''): ?>
                     	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['smsinfo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                        	<?php echo $this->_tpl_vars['smsinfo'][$this->_sections['i']['index']]['reg_date']; ?>
 
                        <?php endfor; endif; ?>
                        <?php endif; ?>&nbsp;
                     </td>
                </tr>
                <?php endif; ?>
                <?php endfor; endif; ?>
                <?php else: ?>
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
                <?php $this->assign('smsinfo', $this->_tpl_vars['clsSmsSend']->getHistory($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id'])); ?>
                <?php $this->assign('checksdt', $this->_tpl_vars['core']->checknumbermobile($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai'])); ?>
                <tr height="25" >
                    <td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><input type="checkbox"  name="chkexpert[]"  value="<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
"  align="right" /></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['lastname']; ?>
</td>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC"  ><a href="http://elearning.neu.topica.vn/course/user.php?id=<?php echo $this->_tpl_vars['c_id']; ?>
&user=<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['id']; ?>
&mode=outline" target="_blank"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['firstname']; ?>
</a></td>
                     
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php if ($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom'] != ''): ?><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_nhom']; ?>
/<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
<?php else: ?> None/<?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_lop']; ?>
 <?php endif; ?></td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['ngaysinh']; ?>
&nbsp;</td>
                    <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_msv']; ?>
</td>
                     <td style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><?php if ($this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai'] != ''): ?><?php if ($this->_tpl_vars['checksdt'] == '1'): ?><span style="color:#009900;"><?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai']; ?>
</span>&nbsp;<?php else: ?><span style="color:#FF0000"> <?php echo $this->_tpl_vars['arrUser'][$this->_sections['id']['index']]['topica_dienthoai']; ?>
&nbsp;</span> <?php endif; ?><?php else: ?> <span style="color:#F00;">Chưa cập nhật</span> <?php endif; ?></td>
                     <td style=" border-bottom:dashed 1px #CCC; "  align="center" width="120">
                     	<?php if ($this->_tpl_vars['smsinfo'] != ''): ?>
                     	<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['smsinfo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                        	<?php echo $this->_tpl_vars['smsinfo'][$this->_sections['id']['index']]['reg_date']; ?>
 
                        <?php endfor; endif; ?>
                        <?php endif; ?>&nbsp;
                     </td>
                </tr>
                <?php endfor; endif; ?>
                
                <?php endif; ?>
                <tr height="25" >
                	<td width="30" style=" border-bottom:dashed 1px #CCC; border-right:dashed 1px #CCC" align="center" ><input type="checkbox"  name="chkexpert[]"  value="<?php echo $this->_tpl_vars['user_login_id']; ?>
"  align="right" /></td>
                    <td colspan="7" style=" border-bottom:dashed 1px #CCC; font-weight:bold; color:#FF0000; ">Thêm số điện thoại của bạn để kiểm tra (<?php if ($this->_tpl_vars['user_login_mobile'] == ''): ?>Bạn chưa cập nhật số điện thoại<?php else: ?><?php echo $this->_tpl_vars['user_login_mobile']; ?>
<?php endif; ?>)</td>
                </tr>
                <tr>
                    <td colspan="8" height="50"></td>
                </tr>
            </table>
            <!-- end left-->
        </td>
        <td valign="top">
        	<table width="400" >
            	<tr>
                    <td class="gridrow1" style="padding-left:10px;">
                        <b>NỘI DUNG TIN NHẮN :</b><br />
                       	<span><em>Chú ý : Gõ tiếng Việt không dấu. Không dùng phím 'Enter' để xuống dòng.</em></span>
                    </td>
                </tr>
                <tr>
                    <td>
                     <em>
                    <textarea  style="border:1px solid #A8C3D6;width:100%" rows="5" name="TextField" onBlur="InputLengthCheck();" onKeyUp="InputLengthCheck();" ><?php echo $this->_tpl_vars['content']; ?>
</textarea>
                    
                    <br>
                     </em> Số ký tự đã gõ :
<input readonly type="text" name="CharsTyped" size="8" value="" maxlength="160" max="160" > 
                    <br>
                    <input readonly type="hidden" name="CharsLeft" size="8"> 
                    <br>
                    <input readonly type="hidden" name="WordsTyped" size="8">
                    <br>
                    
                    <input readonly type="hidden" name="WordsLeft" size="8"> 
                    <br>
                    &nbsp;&nbsp;&nbsp;
                    <input class="btn-submit" type="submit" name="btnSignin" id="btnSignin" value="GỬI TIN"  style="width:180px;"/>
                    <input type="hidden" value="hi_check" name="hi_check" id="hi_check">
                   
                    <br>
                    <br>
                    
                    </td>
                </tr>
            </table>
        </td>
    </tr>


</form>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="20"></td>
    </tr>
</table>