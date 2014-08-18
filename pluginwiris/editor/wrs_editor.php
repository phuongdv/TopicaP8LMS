<?php
// Load configuration constants
if(!isset($CFG)){
  require_once('../../config.php');
}
require_once($CFG->dirroot . '/pluginwiris/wrs_config.php');
require_once($CFG->dirroot . '/pluginwiris/lib/wrs_lang_inc.php');

// absolute url to the jar directory
if ($CFG->wiriseditorcodebase)
{
 $jardirurl = $CFG->wiriseditorcodebase;
 if(strtolower(substr($jardirurl,0,4))!='http') $jardirurl = $CFG->wwwroot . $CFG->wiriseditorcodebase;
}
else
{
 $jardirurl =$CFG->wwwroot .'/pluginwiris/editor/jar/';
}

// get the character encoding
$charset = get_string("thischarset");
$lang = current_language();
$lang = substr($lang,0, 2);  //ignoring specific country code
?>

<html>
<head>
<title><?php echo wrs_get_string($lang, 'wirisformulaeditor');?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot;?>/pluginwiris/editor/wrs_dialog.css"/>
<script type="text/javascript">
  lang = "<?php echo $lang ?>";
	<?php 
		include('wrs_editor.js'); 
		echo "\n";
	?>
</script>
</head>

<body onload="wrs_initDocument()">

<!-- Outer Table -->
<table class="wirisdialog_outer" width="100%" height="100%" cellpadding="0" cellspacing="0">
<tbody>

<!-- Formula Editor Applet -->
<tr><td class="wirisdialog_applet" colspan="2">
<?php
  $applet = '<applet alt="Wiris Editor" ';
  $applet .= 'name="' . 'FormulaEditor' . '" ';
  $applet .= 'codebase="' . $jardirurl . '" ';
  $applet .= 'archive="' . $CFG->wiriseditorarchive . '" ';
  $applet .= 'code="' . $CFG->wiriseditorclass . '" ';
  $applet .= 'width="' . '100%' . '" ';
  $applet .= 'height="' . '100%' . '"'; 
  $applet .= '>';
  
  $applet .= '<param name="lang" value="' . $lang . '" />'; 
  $applet .= '<param name="menuBar" value="true"/>';
  $applet .= '</applet>';
  echo $applet;
?>
</td></tr>

<!-- Controls -->
<tr><td id="wirisdialog_controls">
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td class="wirisdialog_controls1">
<!-- <button id="button_Remove"><?php echo wrs_get_string($lang, 'remove');?></button> -->
</td>
<td class="wirisdialog_controls2">
<button id="button_Ok"><?php echo wrs_get_string($lang, 'ok');?></button>
<button id="button_Cancel"><?php echo wrs_get_string($lang, 'cancel');?></button>
</td></tr>
</tbody></table>
</td></tr>
</tbody>
</table>

</body>
</html>