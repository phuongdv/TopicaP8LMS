<?php
$lv=$_REQUEST['lv'];
if($lv=='')
{
	$lv=1;
}
require "JSON.php";
$json = new JSON;
$url_request='http://183.91.14.157:8088/Api_tsm/View/getResultsOfLearnDetail.ashx?type=SU&account=vietth&level='.$lv.'&unit=2';

$fullContent= file($url_request);
echo $str=substr($fullContent[0],8,-2);
$lv=$lv+1;
echo "<h1>The JSON to php</h1>";

print "<pre>".print_r( $json->unserialize( $str ),true)."</pre>";
if($lv<=7)
{
echo '<br><a href="?lv='.$lv.'"> next </a>';
}
else 
{
	echo '<br><a href="?lv=1"> home </a>';
}
?>
