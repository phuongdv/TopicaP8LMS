<?
	extract($_REQUEST);//You must put this line if you dont have register_globals on in your php.ini
	//*********************************************************
	//		DATABASE CONNECTION
	//*********************************************************
	include_once("bd/ut_para.php");
	include_once("bd/ut_con.php");
	$bd_ID = new BD;
	$bd_ID->con($bd_Nombre,$bd_Servidor,$bd_Usuario,$bd_Clave);

	
	
	//****************************************************************
	$table="clients";
	//****************************************************************
	if(isset($codigo_editar) && $send!=1){//Exist Data
		$cod_table=$codigo_editar;
		$sql="SELECT name,id,birthday,age FROM $table WHERE code='$cod_table'";
		$id=$bd_ID->sql($sql);
		if($row=mysql_fetch_array($id)){
			$n_fields=mysql_num_fields($id);//Table Number fields
			for($i=0;$i<$n_fields;$i++)
				$client[mysql_field_name($id,$i)]=$row[$i];
		}
		
	}elseif($send==1){ //update option
		if($cod_table!=""){
			$sql="UPDATE $table SET name='".ucfirst(strtolower($name))."',id='$id',birthday='$birthday',age='$age' WHERE code='$cod_table'";
			$id=$bd_ID->sql($sql);
			?><script>this.location.href='<?=$ventana;?>?orden=<?=$orden?>&page_number=<?=$page_number?>&busqueda_campo=<?=$busqueda_campo?>'</script><?
		}else{
			$sql="INSERT INTO $table (mane_id_brithday_age) VALUES ('".ucfirst(strtolower($name))."','$id','$birthday','$age')";
			$id=$bd_ID->sql($sql);
			$pantalla=1;
			if(!$id){
				$pantalla=2;
				$error=mysql_error();
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edici&oacute;n Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
.Estilo3 {font-size: 11px}
.Estilo4 {
	color: #000000;
	font-size: 11px;
}
.Estilo7 {font-weight: bold; color: #333333;}
.Estilo9 {font-size: 11px; color: #FFFFFF; }
.Estilo10 {color: #FFFF00}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' debe contener un numero.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- La '+nm+' debe estar entre '+min+' y '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('Se encontraron los siguientes errores:\n'+errors);
  document.MM_returnValue = (errors == '');
}


//-->
</script>
</head>

<body>
<? if($pantalla==0){?>
<form action="" method="post" name="form1"">
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="675"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#000000">
    <tr align="center" valign="middle">
      <td colspan="4" background="images/tbl_error.png" class="titulo_ayuda Estilo2"><div align="center" class="titulo_tablas">&nbsp;EXAMPLE EDIT PAGE </div></td>
    </tr>
    <tr class="titulo1">
      <td width="127" height="17" bgcolor="#7977AA" class="Estilo3"><div align="right" class="Estilo2">Name:</div></td>
      <td width="203" bgcolor="#BDBCD6"><span class="Estilo3">
        <input name="name" type="text" id="name" value="<?=$client[name]?>" size="30">
      </span></td>
      <td width="127" bgcolor="#7977AA" class="Estilo2"><div align="right" class="Estilo2 Estilo3">
          <div align="right">Id:</div>
      </div></td>
      <td width="205" bgcolor="#BDBCD6"><input name="id" type="text" id="id" value="<?=$client[id]?>" size="12"></td>
    </tr>
    <tr class="titulo1">
      <td height="17" bgcolor="#7977AA" class="Estilo3"><div align="right" class="Estilo2">Birthday:</div></td>
      <td bgcolor="#BDBCD6">        <input name="birthday" type="text" id="birthday" value="<?=$client[birthday]?>"  >        </td>
      <td width="127" bgcolor="#7977AA" class="Estilo2"><div align="right" class="Estilo2 Estilo3">
          <div align="right">Age:</div>
      </div></td>
      <td width="205" bgcolor="#BDBCD6">      <input name="age" type="text" id="age" value="<?=$client[age]?>" size="2"></td>
    </tr>
    <tr bgcolor="#e9ecef" class="titulo1">
      <td height="40" colspan="4" class="Estilo3"><div align="center">
        <input type="submit" name="Submit" value="Send">
        <input type="reset" name="Submit2" value="Reset">
        <? if($cod_table!=""){?>
        <input type="button" name="Submit3" value="Cancelar" onClick="window.location.href='<?=$ventana?>?numero_pagina='+document.form1.numero_pagina.value+'&orden='+document.form1.orden.value">
        <? } ?>
        <input name="cod_table" type="hidden" id="cod_table" value="<?=$cod_table?>">
        <input name="send" type="hidden" id="send" value="1">
        <input name="ventana" type="hidden" id="ventana" value="<?=$ventana?>">
        <input name="orden" type="hidden" id="orden" value="<?=$orden?>">
        <input name="page_number" type="hidden" id="ventana4" value="<?=$page_number?>">
        <input name="busqueda_campo" type="hidden" id="busqueda_campo" value="<?=$busqueda_campo?>">
      </div></td>
    </tr>
  </table>
</form>
<? }elseif($pantalla==1){?>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="497"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000">
      <tr>
        <td height="60" bgcolor="#E9ECEF" class="Estilo4"><div align="center">
          <p>&nbsp;</p>
          <p><strong>Los datos del nuevo cliente han sido almacenados exitosamente.</strong><br>
            <br>
            <br>
            Si desea <span class="Estilo7">insertar otro cliente </span> haga <a href="<?=$PHP_SELF?>">click aqu&iacute;.</a><br>
            <br>
          Si desea ver el <span class="Estilo7">listado de clientes </span>, haga <a href="example_simple_query.php">click aqu&iacute;.</a></p>
          <p>&nbsp;</p>
        </div></td>
      </tr>
    </table>
<? }elseif($pantalla==2){?>
<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="497"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000">
      <tr>
        <td height="60" bgcolor="#8C0000" class="Estilo4"><div align="center">
          <p>&nbsp;</p>
          <p class="Estilo2"><strong>!!!Hubo un problema con la inserci&oacute;n de los datos!!!!</strong></p>
          <p class="Estilo2"><strong><span class="Estilo9"><span class="Estilo2">MYSQL reporta:</span><br>
                <span class="Estilo10">
                <?=$error;?>
                </span></span></strong></p>
          <p class="Estilo2">Vuelva a intentarlo, <a href="<?=$PHP_SELF?>">click aqu&iacute;</a> </p>
          <p>&nbsp;</p>
        </div></td>
      </tr>
    </table>
<? } ?>
</body>
</html>
