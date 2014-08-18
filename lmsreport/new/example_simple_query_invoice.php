<?
	extract($_REQUEST);//This file is necesary if you have register_globas OFF in your php.ini
	$select="SELECT code_client,value,inscription_date,inscription_hour";
	$from="FROM invoices";
	if(isset($code_client))
		$where="WHERE code_client='$code_client'";
	else
		$where="";
	$group="";
	$sql="$select $from $where";
	
	//***********************************************************************
	//		Variables
	/************************************************************************
	$distinctrow
	Primary key or UNique Key of the SQL query
	If the key doesn't appear on the $select statement, the class will put it at the end of the $select but won't show it on the grid. Like this example. 
	The $dstinctrow variable will be used to edit or erase the rows.
	**************************************************************************/
	$distinctrow="code";
	/*
	$field_names=
	If you want to show on the top of any column other name diferent that the name of the name of the fields on the query, you must 
	*/
	$field_names=array("Client","Value","Inscription Date","Inscription Hour");
	$page_title="Invoices List";
	$name_excel="lists_invoice";
	
	$delete_sentence['table']=array("invoices");
	$delete_sentence['key']=array("code");
	$erase=1;
	$currency_symbol[1]=1;
	//$actual_page="example_simple_query.php";
	//$edit_page="client_edit.php";
	
	$replace[0]="SELECT code,name FROM clients";
	/*
	$links['window'][6]="example_simple_query_invoice.php";
	$links['position'][6]=1;
	$links['distinct'][6]=1;
	$links['link_name'][6]="Client Invoices";
	$links['link_variable'][6]="code_client";
	$links['target'][6]="_blank";
	$links['width'][6]=800;
	$links['height'][6]=555;
	$links['others'][6]="";
	*/
	
	require("class/lists.inc.php");
	$lista=new lists($sql,$group,$distinctrow,$page_title,$name_excel,$links,$field_names,$delete_sentence,$currency_symbol,$actual_page,$edit_page,$erase,$replace);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="text/javascript" src="class/lists.js"></script>
<title>Listado de Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<? $lista->show($bd,$orden,$inicio_filas,$num_filas,$page_number,$encabezados,$send,$ordenado,$busqueda_campo,$busqueda,$cod_erase);?>
</body>
</html>
