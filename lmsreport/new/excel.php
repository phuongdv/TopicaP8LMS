<?php
extract($_REQUEST);//This file is necesary if you have register_globas OFF in your php.ini
	//*********************************************************
	//		DATABASE CONNECTION
	//*********************************************************
	include_once ("db/ut_para.php");
	include_once ("db/ut_con.php");
    include_once ("class/ExportToExcel.class.php");
    $exp=new ExportToExcel();
	//$bd_ID = new BD;
    

	//$bd_ID->con($bd_Nombre,$bd_Servidor,$bd_Usuario,$bd_Clave);  	
	
	
	$conn=mysql_connect($bd_Servidor,$bd_Usuario,$bd_Clave)or die('Sorry Could not make connection');
mysql_select_db($bd_Nombre);
	$set_utf8 = mysql_query("SET NAMES utf8",$conn);
	$exp->exportWithQuery($sql,"personalinfo.xls",$conn,'Assign Tracker');	
	/*
		$name=$name."_".date("Y_m_d").".csv";
		if(file_exists($name))
			unlink($name);
		$sql=str_replace("*@","%'",str_replace("@*","'%",$sql));
		$sql=str_replace("@@","'",$sql);
		//echo "sql:$sql<br>nom:$name<br>ruta:$ruta";
		$sql=str_replace("FROM","INTO OUTFILE $ruta/$name FIELDS TERMINATED BY ',' LINES TERMINATED BY ',\n'  FROM",$sql);
		$id=$bd_ID->sql($sql); 
		die($sql);
		if(!$id)
			echo "Error MySql:".mysql_error();
		if($colocar_nombres=="true"){
			$nombre_campos=str_replace(";",",",$nombre_campos);
			$nombre_campos.="\n";
			if(!$fp=fopen($name,"r"))
				echo "Open file problem";
			elseif(!$fp_bak=fopen("backup.csv","w"))
				echo "open backup file problem";
			else{
				fputs($fp_bak,strtoupper($nombre_campos));
				while(!feof($fp)){
					fputs($fp_bak,fgets($fp));
				}
			}
			fclose($fp);
			fclose($fp_bak);
			unlink($name);
			rename("backup.csv",$name);
		}
		*/
		?>

