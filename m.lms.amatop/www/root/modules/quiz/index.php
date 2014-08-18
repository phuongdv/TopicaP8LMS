<?
$sub = $stdio->GET("sub", "default");
//$act = $stdio->GET("act", "default");
$act = $_REQUEST['act'];
$clsModule = new Module("quiz");
$clsModule->run($sub, $act);	

$assign_list["sub"] = $sub;
$assign_list["act"] = $act;	
?>