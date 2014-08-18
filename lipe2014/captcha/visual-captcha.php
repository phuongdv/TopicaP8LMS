<?php
$aFonts = array('fonts/VeraSeBd.ttf');
require_once('php-captcha.inc.php');
$oVisualCaptcha = new PhpCaptcha($aFonts,100,25);
$oVisualCaptcha->CaseInsensitive(true);
$oVisualCaptcha->Create();
?>