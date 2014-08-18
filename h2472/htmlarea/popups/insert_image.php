<?php
include('../../includes/config.inc.php');
var_dump('../../'.$dir_upload);
function gen_rand_string($hash){
		$chars = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
		$max_chars = count($chars) - 1;
		srand((double) microtime()*1000000);		
		$rand_str = '';
		for($i = 0; $i < 10; $i++)
		{
			$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
		}	
		return ( $hash ) ? md5($rand_str) : $rand_str;
	}
$char = gen_rand_string("");
$gio=date("H:i:s");
$ngay=date("d_m_Y");
$time=$gio." | ".$ngay;
$size = "5000000";
if($_GET['action'] == 'upload')
{
	$uploaddir = '../../'.$dir_upload;
	$trim = str_replace(" ", "",basename($_FILES['userfile']['name']));
	$name = strtolower($trim);
	srand((double)microtime()*1000000);
	if( substr($name, -5, 5) == '.jpeg' || substr($name, -5, 5) == '.JPEG')
	{
		$number2 = $char . "_" . rand(0,100000000000) . "_" . $ngay . substr($name, -5, 5);
	}
	else
	{
		$number2 = $char . "_" . rand(0,100000000000) . "_" . $ngay . substr($name, -4, 4);
	}

	$uploadfile = $uploaddir . $number2;
//check the image size
	if($_FILES['userfile']['size'] == $size || $_FILES['userfile']['size'] > $size)
	{
		$size2 = $size;
		echo "<br>B&#7841;n kh&#244;ng &#273;&#432;&#7907;c upload dung l&#432;&#7907;ng file l&#7899;n h&#417;n " . $size2 . "kb";
		exit;
	}
	else
	{
		if(
			substr($name, -5, 5) == '.jpeg' || 
			substr($name, -4, 4) == '.gif' || 
			substr($name, -4, 4) == '.jpg' || 
			substr($name, -4, 4) == '.png' || 
			substr($name, -4, 4) == '.bmp' || 

			substr($name, -5, 5) == '.JPEG' || 
			substr($name, -4, 4) == '.GIF' || 
			substr($name, -4, 4) == '.JPG' || 
			substr($name, -4, 4) == '.PNG' || 
			substr($name, -4, 4) == '.BMP')
		{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
			{
			   chmod($uploadfile,0644);
			   if( substr($name, -5, 5) == '.jpeg' || substr($name, -5, 5) == '.JPEG' )
				{
					  $imgmime = "image/jpeg";
				}
				elseif( substr($name, -4, 4) == '.gif' || substr($name, -4, 4) == '.GIF' )
				{
					$imgmime = "image/gif";
				}
				elseif( substr($name, -4, 4) == '.jpg' || substr($name, -4, 4) == '.JPG' )
				{
					$imgmime = "image/jpeg";
				}
				elseif( substr($name, -4, 4) == '.png' || substr($name, -4, 4) == '.PNG' )
				{
					$imgmime = "image/png";
				}
				elseif( substr($name, -4, 4) == '.bmp' || substr($name, -4, 4) == '.BMP' )
				{
					$imgmime = "image/x-MS-bmp";
				}
				
				$imgurl = $Config_link_site . $dir_upload . $number2;
				
				//echo $imgurl;
			}
			else 
			{
				echo "B&#7841;n kh&#244;ng &#273;&#432;&#7907;c upload file n&#224;y";
			}
		}
		else
		{
			echo "B&#7841;n kh&#244;ng &#273;&#432;&#7907;c upload file n&#224;y";
		}
	}
}

?>
<html>
<head>
  <title>Insert Image</title>

<script type="text/javascript" src="popup.js"></script>

<script type="text/javascript">

window.resizeTo(400, 100);

function Init() {
  __dlg_init();
  var param = window.dialogArguments;
  if (param) {
      document.getElementById("f_url").value = param["f_url"];
      document.getElementById("f_alt").value = param["f_alt"];
      document.getElementById("f_border").value = param["f_border"];
      document.getElementById("f_align").value = param["f_align"];
      document.getElementById("f_vert").value = param["f_vert"];
      document.getElementById("f_horiz").value = param["f_horiz"];
      window.ipreview.location.replace(param.f_url);
  }
  document.getElementById("f_url").focus();
};

function onOK() {
  var required = {
    "f_url": "You must enter the URL"
  };
  for (var i in required) {
    var el = document.getElementById(i);
    if (!el.value) {
      alert(required[i]);
      el.focus();
      return false;
    }
  }
  // pass data back to the calling window
  var fields = ["f_url", "f_alt", "f_align", "f_border",
                "f_horiz", "f_vert"];
  var param = new Object();
  for (var i in fields) {
    var id = fields[i];
    var el = document.getElementById(id);
    param[id] = el.value;
  }
  __dlg_close(param);
  return false;
};

function onCancel() {
  __dlg_close(null);
  return false;
};

function onPreview() {
  var f_url = document.getElementById("f_url");
  var url = f_url.value;
  if (!url) {
    alert("You have to enter an URL first");
    f_url.focus();
    return false;
  }
  window.ipreview.location.replace(url);
  return false;
};
</script>

<style type="text/css">
html, body {
  background: ButtonFace;
  color: ButtonText;
  font: 11px Tahoma,Verdana,sans-serif;
  margin: 0px;
  padding: 0px;
}
body { padding: 5px; }
table {
  font: 11px Tahoma,Verdana,sans-serif;
}
form p {
  margin-top: 5px;
  margin-bottom: 5px;
}
.fl { width: 9em; float: left; padding: 2px 5px; text-align: right; }
.fr { width: 6em; float: left; padding: 2px 5px; text-align: right; }
fieldset { padding: 0px 10px 5px 5px; }
select, input, button { font: 11px Tahoma,Verdana,sans-serif; }
button { width: 70px; }
.space { padding: 2px; }

.title { background: #ddf; color: #000; font-weight: bold; font-size: 120%; padding: 3px 10px; margin-bottom: 10px;
border-bottom: 1px solid black; letter-spacing: 2px;
}
form { padding: 0px; margin: 0px; }
</style>

</head>

<body onload="Init()">

<div class="title">Insert Image</div>
<!--- new stuff --->
<table border="0" width="100%" style="padding: 0px; margin: 0px">
  <tbody>
  <tr>
    <td colspan="2"><form enctype="multipart/form-data" method="post" action="insert_image.php?action=upload">Upload File: <input name="userfile" type="file" size="40"> <input type="submit" value="Upload"></form></td>
  </tr>
<form action="" method="get">
  <tr>
    <td style="width: 7em; text-align: right">Image URL:</td>
    <td><input type="text" name="url" id="f_url" style="width:70%" value="<?php echo $imgurl; ?>" title="Enter the image URL here" />
      <button name="preview" onclick="return onPreview();"
      title="Preview the image in a new window">Preview</button>
    </td>
  </tr>
  <tr>
    <td style="width: 7em; text-align: right">Alternate text:</td>
    <td><input type="text" name="alt" id="f_alt" style="width:100%"
      title="For browsers that don't support images" /></td>
  </tr>

  </tbody>
</table>

<p />

<fieldset style="float: left; margin-left: 5px;">
<legend>Layout</legend>

<div class="space"></div>

<div class="fl">Alignment:</div>
<select size="1" name="align" id="f_align"
  title="Positioning of this image">
  <option value=""                             >Not set</option>
  <option value="left"                         >Left</option>
  <option value="right"                        >Right</option>
  <option value="texttop"                      >Texttop</option>
  <option value="absmiddle"                    >Absmiddle</option>
  <option value="baseline" selected="1"        >Baseline</option>
  <option value="absbottom"                    >Absbottom</option>
  <option value="bottom"                       >Bottom</option>
  <option value="middle"                       >Middle</option>
  <option value="top"                          >Top</option>
</select>

<p />

<div class="fl">Border thickness:</div>
<input type="text" name="border" id="f_border" size="5"
title="Leave empty for no border" />

<div class="space"></div>

</fieldset>

<fieldset style="float:right; margin-right: 5px;">
<legend>Spacing</legend>

<div class="space"></div>

<div class="fr">Horizontal:</div>
<input type="text" name="horiz" id="f_horiz" size="5"
title="Horizontal padding" />

<p />

<div class="fr">Vertical:</div>
<input type="text" name="vert" id="f_vert" size="5"
title="Vertical padding" />

<div class="space"></div>

</fieldset>
<br clear="all" />
<table width="100%" style="margin-bottom: 0.2em">
 <tr>
  <td valign="bottom">
    Image Preview:<br />
    <iframe name="ipreview" id="ipreview" frameborder="0" style="border : 1px solid gray;" height="200" width="300" src=""></iframe>
  </td>
  <td valign="bottom" style="text-align: right">
    <button type="button" name="ok" onclick="return onOK();">OK</button><br>
    <button type="button" name="cancel" onclick="return onCancel();">Cancel</button>
  </td>
 </tr>
</table>
</form>


</body>
</html>
