<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php

	$c_id = $_REQUEST['cid'];
	require_once( 'config.php' );
	include ("phpmydatagrid.class.php");
	
	$objGrid = new datagrid;
	
	$objGrid -> friendlyHTML();

	$objGrid -> pathtoimages("./images/");

	$objGrid -> closeTags(true);  
	
	$objGrid -> form('calendar', true);
	$objGrid -> linkparam("cid=".$c_id );
	
	$objGrid -> methodForm("post"); 
	
	$objGrid -> decimalDigits(2);
	
	$objGrid -> decimalPoint(",");
	
	$objGrid -> conectadb($dbhost, $dbuser, $dbpass, $dbmain);
	
	$objGrid -> tabla ("huy_setting_calendar");

	/* Allow Add, edit, delete or view records */
	$objGrid -> buttons(true,true,true,true);
	
	/* Keyfield must be defined to indentify each row */
	$objGrid -> keyfield("id");

	/* A code is related with some transactions. so is very dificult to someone to try to do unauthorized process */
	/* There are a internal code but you can made it strong by setting this function" */
	$objGrid -> salt("abc");

	$objGrid -> TituloGrid("Setting calender");

	$objGrid -> FooterGrid("<div style='float:left'>&copy; 2009 topica</div>");
	
	$objGrid -> paginationmode('links');

	$objGrid -> noorderarrows();
	
	$objGrid -> FormatColumn("id", "ID", 5, 5, 1, "50", "center", "integer");
	$objGrid -> FormatColumn("c_id", "ID Class", 30, 30, 0, "150","center", "integer",$c_id);
	$objGrid -> FormatColumn("week_number", "week_number", 30, 30, 0, "30", "left");
	$objGrid -> FormatColumn("week_name", "week name", 30, 30, 0, "200", "left");
	$objGrid -> FormatColumn("start_date", "start_date", 30, 30, 0, "200", "left","date:dmy:/");
	$objGrid -> FormatColumn("end_date", "end_date", 30, 30, 0, "200", "left","date:dmy:/");
	$objGrid -> FormatColumn("comment", "Ghi chú", 10, 255, 0, "250", "left","textarea");
	if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
	$objGrid -> where ("c_id = '$c_id'");
	}
	$objGrid -> setHeader();

	$objGrid -> grid();
	$objGrid -> desconectar();

?>
	
</body>
</html>