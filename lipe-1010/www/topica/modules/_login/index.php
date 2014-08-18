<?
$sub = $stdio->GET("sub", "default");
$act = $stdio->GET("act", "default");
$clsModule = new Module("_login");
$clsModule->run($sub, $act);	
$assign_list["sub"] = $sub;
$assign_list["act"] = $act;	
$assign_list["core"] = $core;

$smarty->assign($assign_list);
$smarty->display("$mod/index.html");
exit();
?>