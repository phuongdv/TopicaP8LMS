<?
$sub = $stdio->GET("sub", "default");
$act = $stdio->GET("act", "default");
$clsModule = new Module("_module");
$clsModule->run($sub, $act);	

//Find module and Add to DB



$assign_list["sub"] = $sub;
$assign_list["act"] = $act;	
?>