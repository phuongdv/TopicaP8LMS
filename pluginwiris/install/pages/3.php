<?php
if (!defined('SECURITY_CONSTANT')) exit;

$howeverInstall = false;
$tag = null;

if (isset($_POST['restore'])) {
	if (copy('../lib/weblib.php.old', '../lib/weblib.php')) {
		$howeverInstall = true;
	}
	else {
		echo translate("Plugin WIRIS Installer hasn't write permisions on"), ' ../lib/weblib.php<br /><br />';
		$tag = 'acthtml';
	}
}

if ((isset($_POST['option']) and $_POST['option'] == translate('Yes')) or $howeverInstall) {
	if (downloadEditor()) {
		if (extractEditor()) {
			if (full_copy("./install/filter/wiris", "../filter/wiris/")) {
				$response = parseWebLib();
				if ($response == ALL_WELL) {
					echo '<form action="./install.php" method="POST">';
					echo '<input type="hidden" name="step" value="4" />';
					echo '<input type="hidden" name="language" value="', addSlashesOnDoubleQuotes($shortLanguageName), '" />';

					if (isset($_POST['proxy']) and isset($_POST['proxy_host']) and isset($_POST['proxy_port'])) {
						echo '<input type="hidden" name="proxy" value="1" />';
						echo '<input type="hidden" name="proxy_host" value="', addSlashesOnDoubleQuotes($_POST['proxy_host']), '" />';
						echo '<input type="hidden" name="proxy_port" value="', (int)$_POST['proxy_port'], '" />';
					}
					
					if (file_exists('./wrs_config.php')) {
						include('./wrs_config.php');
					}
					else {
						$CFG->wirisformulaeditorenabled = true;
						$CFG->wirisimageservicehost = 'services.wiris.com';
						$CFG->wirisimageserviceport = '80';
						$CFG->wirisimageservicepath = '/formula/render';
						$CFG->wirisimagebgcolor = '#ffffff';
						$CFG->wiristransparency = 'false';
						$CFG->wirisimagesymbolcolor = '#000000';
						$CFG->wirisimagefontsize = '16';
						
						$CFG->wiriscasenabled = true;
						$CFG->wiriscascodebase = 'http://www.wiris.net/demo/wiris/wiris-codebase';
						$CFG->wiriscasarchive = 'wrs_net_en.jar';
						$CFG->wiriscasclass = 'WirisApplet_net_en';
						$CFG->wiriscaslang = 'es,en,fr';
					}
					
					echo '<div class="big_form">';
					
					// Editor form
					$enableEditor = ($CFG->wirisformulaeditorenabled) ? 'checked' : '';
					
					echo '<input type="checkbox" id="enableEditor" name="enableEditor" onclick="showDiv(\'editorForm\', this.checked);" ', $enableEditor, '/><b>', translate('Enable'), ' WIRIS Editor</b><br />';
					echo '<div id="editorForm" class="sub_form">';
					echo '<label for="imagehost">WIRIS Image Service Host</label> <input type="text" name="imagehost" value="', addSlashesOnDoubleQuotes($CFG->wirisimageservicehost), '" /><br />';
					echo '<label for="imageport">WIRIS Image Service Port</label> <input type="text" name="imageport" value="', addSlashesOnDoubleQuotes($CFG->wirisimageserviceport), '" /><br />';
					echo '<label for="imagepath">WIRIS Image Service Path</label> <input type="text" name="imagepath" value="',addSlashesOnDoubleQuotes($CFG->wirisimageservicepath), '" /><br />';
					echo '<label for="imagebgcolor">', translate('Formula background color'), '</label> <input type="text" name="imagebgcolor" value="', addSlashesOnDoubleQuotes($CFG->wirisimagebgcolor), '" /><br />';
					$transparency = ($CFG->wiristransparency) ? $transparency = 'checked' : '';
					echo '<br /><input type="checkbox" name="transparency" ', $transparency, '/>', translate('Enable formula background transparency'), '<br />';
					echo '<label for="imagesymbolcolor">', translate('Formula font color'), '</label> <input type="text" name="imagesymbolcolor" value="', addSlashesOnDoubleQuotes($CFG->wirisimagesymbolcolor), '" /><br />';
					echo '<label for="imagefontsize">', translate('Formula font size'), '</label> <input type="text" name="imagefontsize" value="', addSlashesOnDoubleQuotes($CFG->wirisimagefontsize), '" /><br />';
					echo '<br />';
					echo '</div>';
					
					// CAS form
					$enableCAS = ($CFG->wiriscasenabled) ? 'checked' : '';
					echo '<input type="checkbox" id="enableCAS" name="enableCAS" onclick="showDiv(\'CASForm\', this.checked);" ' . $enableCAS . '/><b>', translate('Enable'), ' WIRIS CAS</b><br />';
					echo '<div id="CASForm" class="sub_form">';
					echo '<label for="server">', translate('Choose your WIRIS CAS server'), '</label> ';
					echo '<select name="server" onclick="prepareSelect(this);">';
					
					$servers = array();
					$dirList = opendir("./install/servers/");
					while ($itemReaded = readdir($dirList)) {
						if ($itemReaded != '.' and $itemReaded != '..' and substr($itemReaded, strlen($itemReaded) - 4, 4) == '.php') {
							include('./install/servers/' . $itemReaded);
							$name = substr($itemReaded, 0, strlen($itemReaded) - 4);
							$servers[$name] = $serverName;
						}
					}
					closedir($dirList);
					
					sort($servers);		// Sort by server name, alphabetically
					//rsort($servers);		// Sort by server name, inverse alphabetically
					//ksort($servers);		// Sort by file name, alphabetically
					//krsort($servers);		// Sort by file name, inverse alphabetically
					
					foreach ($servers as $key => $value) {
						echo '<option value="', addslashes($key), '">', $value, '</option>';
					}
					
					echo '<option value="own">', translate('Use your own server'), '</option>';
					
					echo '</select>';
					echo '<div id="serverForm" class="sub_form" style="display: none;">';
					echo '<label for="codebase">WIRIS CAS codebase</label> <input type="text" name="codebase" value="', addslashes($CFG->wiriscascodebase), '" /><br />';
					echo '<label for="archive">WIRIS CAS archive</label> <input type="text" name="archive" value="', addslashes($CFG->wiriscasarchive), '" /><br />';
					echo '<label for="class">WIRIS CAS class</label> <input type="text" name="class" value="', addslashes($CFG->wiriscasclass), '" /><br />';
					
					echo '<label>', translate('Avaiable languages'), '</label>';
					$langList = array('es', 'en', 'ca', 'it', 'fr', 'eu', 'nl', 'et');
					foreach ($langList as $langItem) {
						echo '<input type="checkbox" name="', addslashes($langItem), '" ';
						if (strpos($CFG->wiriscaslang, $langItem) !== false) {
							echo 'checked';
						}
						echo '/>', $langItem, ' ';
					}
					
					echo '</div>';
					echo '</div>';
					
					echo '</div>';
					
					echo '
					<script type="text/javascript">
						function prepareSelect(selectObject) {
							if (selectObject.value == "own") {
								showDiv("serverForm", true);
							}
							else {
								showDiv("serverForm", false);
							}
						}
						
						function showDiv(divID, visible) {
							if (visible) {
								document.getElementById(divID).style.display = "block";
							}
							else {
								document.getElementById(divID).style.display = "none";
							}
						}
						
						var textboxes = document.getElementsByTagName("input");
						for (var i = 0; i < textboxes.length; ++i) {
							if (textboxes[i].type == "text") {
								textboxes[i].style.width = "300px";
							}
						}
						
						showDiv("editorForm", document.getElementById("enableEditor").checked);
						showDiv("CASForm", document.getElementById("enableCAS").checked);
					</script>
					';

					echo '<input type="submit" value="', translate('Continue'), '" />';
					
					echo '<div id="information">';
					echo translate("If you click on 'Continue'"), ':<br />';
					echo '<ul>';
					echo '<li>', translate('A new'), ' wrs_config.php ', translate('will created on'), ' ./</li>';
					echo '</ul>';
					echo '</div>';
					
					echo '</form>';
				}
				else if ($response == UNKNOWN_VERSION) {
					echo translate('Your moodle version is unknown for Plugin WIRIS Installer. Please, install it manually.'), '<br /><br />';
					echo errorMessage('acthtml');
				}
				else if ($response == NO_WRITE_PERMISION) {
					echo translate("Plugin WIRIS Installer hasn't write permisions on"), ' ../lib/weblib.php<br /><br />';
					echo errorMessage('acthtml');
				}
				else if ($response == NO_READ_PERMISION) {
					echo translate("Plugin WIRIS Installer hasn't read permisions on"), ' ../lib/weblib.php<br /><br />';
					echo errorMessage('acthtml');
				}
				else if ($response == ALREADY_PARSED) {
					echo '<form action="./install.php" method="POST">';
					echo '<input type="hidden" name="step" value="3" />';
					echo '<input type="hidden" name="language" value="', addSlashesOnDoubleQuotes($shortLanguageName), '" />';
					if (isset($_POST['proxy']) and isset($_POST['proxy_host']) and isset($_POST['proxy_port'])) {
						echo '<input type="hidden" name="proxy" value="1" />';
						echo '<input type="hidden" name="proxy_host" value="', addslashes($_POST['proxy_host']), '" />';
						echo '<input type="hidden" name="proxy_port" value="', (int)$_POST['proxy_port'], '" />';
					}
					
					echo translate('Plugin WIRIS is already installed. If you want to reinstall it, please, uninstall it first'), ' <a href="http://www.wiris.com/download/moodle/uninstall.html">', translate('here'), '</a> ', translate('or'), ':<br /><br />';
					echo '<input type="submit" name="restore" value="', addSlashesOnDoubleQuotes(translate('Restore') . ' ../lib/weblib.php ' . translate('and try to reinstall.')) , '"><br /><br />';
					
					echo errorMessage('acthtml');
					
					echo '<div id="information">';
					echo '<ul>';
					echo '<li>../lib/weblib.php.old ', translate('will be restored to'), ' ../lib/weblib.php</li>';
					echo '</ul>';
					echo '</div>';
					echo '</form>';
				}
				else if ($response == CAN_NOT_CONNECT) {
					echo translate('Could not connect to http://www.wiris.com/download/moodle/versions.php. It is needed to get a patch for your moodle version.');
					echo errorMessage('acthtml');
				}
			}
			else {
				echo translate('Error while copying'), ' ./install/filter/wiris ', translate('to'), ' ../filter/wiris/';
				echo errorMessage('req2');
			}
		}
		else {
			echo translate('Error while extracting'), ' pluginwiris.zip.<br /><br />';
			echo errorMessage('req2');
		}
	}
	else {
		echo translate('Error while downloading'), ' http://www.wiris.com/download/editor/download?file=wiriseditor.zip. ', translate('Are you connected to internet? Do you have write permissions on'), ' ./editor/jar?<br /><br />';
		echo errorMessage('req2');
	}
}
else {
	echo errorMessage($tag);
}
?>