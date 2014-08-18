<?
	extract($_REQUEST);//This file is necesary if you have register_globas OFF in your php.ini
	$select="SELECT c.name,c.id,COUNT(f.code) as n_invoice, SUM(f.value) as value";
	$from="FROM clients as c, invoices as f";//OR    FROM clients as c LEFT JOIN invoices as f ON f.code_client=c.code
	$where="WHERE f.code_client=c.code";
	$group="GROUP BY f.code_client";
	$sql="$select $from $where";
	
	//***********************************************************************
	//		Variables
	/************************************************************************
	$distinctrow
	Primary key or UNique Key of the SQL query
	If the key doesn't appear on the $select statement, the class will put it at the end of the $select but won't show it on the grid. Like this example. 
	The $dstinctrow variable will be used to edit or erase the rows.
	**************************************************************************/
	$distinctrow="c.code";
	/*
	$field_names=
	If you want to show on the top of any column other name diferent that the name of the name of the fields on the query, you must 
	*/
	$field_names=array("Name","Id Number","# Invoices","Total");
	$page_title="Clients List";//Title of the window page
	$name_excel="lists_clients";//name file to export to excel
	
	// Instructions to delete rows, in this example, delete the client and his invoices.
	$delete_sentence['table']=array("clients","invoices"); //Tables
	$delete_sentence['key']=array("code","code_client"); //Primary key or Unique key to find the row to delete.
	$erase=1;//If you want to show the erase icon 
	
	$currency_symbol[3]=1; //In the column number 3 will show a currency symbol.
	
	// This variables are used if you have a edit page for the row.
	
	//$actual_page="example_simple_query.php";
	//$edit_page="client_edit.php";
	
	/**************************************************
	Links: on this example i used 2 links, one outside the grid and the second one on the Id Number column, column number 1.
	***************************************************/
	$links['window'][4]="example_simple_query_invoice.php";
	$links['position'][4]=1;
	$links['distinct'][4]=1;
	$links['link_name'][4]="Invoice Details";
	$links['link_variable'][4]="code_client";
	$links['target'][4]="_blank";
	$links['width'][4]=800;
	$links['height'][4]=555;
	$links['others'][4]="";
	
	$links['window'][1]="example_simple_query_invoice.php";
	$links['position'][1]=1;
	$links['distinct'][1]=1;
	//$links['link_name'][1]="Invoice Details"; Because the link is inside the grid, we dont need this variable.
	$links['link_variable'][1]="code_client";
	$links['target'][1]="_blank";
	$links['width'][1]=800;
	$links['height'][1]=555;
	$links['others'][1]="";
	
	
	require("class/lists.inc.php");
	$list=new lists($sql,$group,$distinctrow,$page_title,$name_excel,$links,$field_names,$delete_sentence,$currency_symbol,$actual_page,$edit_page,$erase,$replace);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="text/javascript" src="class/lists.js"></script>
<title>Listado de Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<? $list->show($bd,$orden,$inicio_filas,$num_filas,$page_number,$encabezados,$send,$ordenado,$busqueda_campo,$busqueda,$cod_erase);?>
</body>
</html>
