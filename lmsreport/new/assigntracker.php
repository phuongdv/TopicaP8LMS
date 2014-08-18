<?
	extract($_REQUEST);//This file is necesary if you have register_globas OFF in your php.ini
	$select="SELECT nguoiassign,assigncho,answerid,threadid,tencauhoi,datime,delay";
	$from="FROM view_assign";
	$where="";
	$group="";
	$sql="$select $from $where";
	//echo $sql;
	//***********************************************************************
	//		Variables
	/************************************************************************
	$distinctrow
	Primary key or UNique Key of the SQL query
	If the key doesn't appear on the $select statement, the class will put it at the end of the $select but won't show it on the grid. Like this example. 
	The $dstinctrow variable will be used to edit or erase the rows.
	**************************************************************************/
	//$distinctrow="code";
	/*
	$field_names=
	If you want to show on the top of any column other name diferent that the name of the name of the fields on the query, you must 
	*/
	$field_names=array("Assign from","Assignto","Question id","Thread id","Question tittle","Time stamp","Delay time");
	$page_title="Assign tracker list";
	$name_excel="lists_clients";
	
	// Instructions to delete rows, in this example, delete the client.
	//$delete_sentence['table']=array("clients"); //Tables
	//$delete_sentence['key']=array("code"); //Primary key or Unique key to find the row to delete.
//	$erase=1;//If you want to show the erase icon 
	
	//$currency_symbol[8]=1;
	//$actual_page="example_simple_query.php";
	//$edit_page="client_edit.php";
	
	//The second column (name)on this query  will replace the column on the select statement, give by position $replace[position]
	//On this example, the column number 4 will replace by (name)
	//$replace[4]="SELECT code,name FROM conf_vehicule_type";
	
	$links['window'][4]="http://elearning.hou.topica.vn/h2472/";
	$links['position'][4]=3;
	//$links['distinct'][6]=1;
	//$links['link_name'][4]="Client Invoices";
	$links['link_variable'][4]="act=answers&do=detail&id";
	$links['target'][4]="_blank";
	//$links['width'][6]=800;
	//$links['height'][6]=555;
	//$links['others'][6]="";
		
	require("class/lists.inc.php");
	$list=new lists($sql,$group,$distinctrow,$page_title,$name_excel,$links,$field_names,$delete_sentence,$currency_symbol,$actual_page,$edit_page,$erase,$replace);
	
?>


<body>
<? $list->show($bd,$orden,$inicio_filas,$num_filas,$page_number,$encabezados,$send,$ordenado,$busqueda_campo,$busqueda,$cod_erase);?>
</body>
</html>
