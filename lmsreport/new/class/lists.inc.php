<script type="text/javascript" src="class/lists.js"></script>
<script type="text/javascript" src="class/datetimepicker_css.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/links.css" rel="stylesheet" type="text/css">
<?
// ========================================================================================================================================
	//  Author:      				Camilo Alzate (camialza@hotmail.com, cami_lo@yahoo.com)
	//	Name: 	     				lists.inc.php
	// 	Description:   				An easy way to show SQL query.
	//	License:    	  			GNU General Public License (GPL)
	//  Release Date:               April 13th / 2007
	//  Last Update date: 			
	//  Version:                    1
	//	
	//  
	//	Features: 
	//					* Easy way to show SQL queries. (join or simple queries)
	//					* Search and order option by column.
	//					* Show the query by page.
	//					* Add links at any column or outside the grid, like an additional column.
	//					* Replace any field by another Sql query.
	//					* Add currency symbol at any column.
	//					* Delete any row of the query.
	//					* Add link to edit page.
	//
	//  Tested on:	Did it in Xampp 1.5.1
	//				* Server Side:
	//					* php 4.4.2
	//					* php 5.1.1
	//
	//				* Client Side:
	//					* Internet Explorer 6.0 and 7.0
	//					
	//
	//  
	// 	
	//  If you make any modifications making it better, please let me know to camialza@hotmail.com
// ========================================================================================================================================
	


/*	Variables:
	
	***********************************************************************************************************
	LINKS: 	You can add links in any column (0,1,...N_COL) of the grid or outside the grid like an additional column. 
			Just setting the N value equal to the desire column or equal to N_COL+1 if you want it outside the grid.
	***********************************************************************************************************
		$links['position']['window']['width']['height']['link_name']['link_variable']['distinct']['others']  [N] 
		
		N = The column position that contain the link  (number between 0 and N_COL+1)
		
		$links['position'][N] 		=If $links['distinct'] is 0, this variable contain the column position that takes the value to the link. Ex. i want to send the value of the second (1) column in a link that is on the first (0) column :$links['position'][0]=1;
		$links['window'][N]			=The name of the file to open with the link Ex. The file that will open with the link in the first column: $links['window'][0]='edit_list.php';
		$links['witdh'][N]			=Width of the emergent window.
		$links['height'][N]			=Height of the emergent window.
		$links['link_name'][N]		=If the link is positioned outside the columns of the table
		$links['target'][N]			=The target of the popup window (_self,_blank, etc)
		$links['link_variable'][N]	=Contains the name of the variable that will be send to the $link['window']
		$links['distinct'][N]		=1: If the link value must to be the distinctrow (Primary key) of the query.
									 0: If not
		$links['others'][N]			=Aditional variables of the link. Ex: from=$from&to=$to
	***********************************************************************************************************
	DELETE SENTENCE: 	You can add delete sentence to the grid. Adding the table name and the key of that table. This table and key will be
						used in a SQL QUERY to delete the referenced row.
	***********************************************************************************************************
		$delete_sentence['table']	=The name of the table that will be delete the row.
		$delete_sentence['key']		=The key (primary or unique) that will be used to find the row to delete in that table.
	
	***********************************************************************************************************
	REPLACE_FIELDS: 	You can replace a column value, for other from a sql query with this variable.
	***********************************************************************************************************
		$replace_fields['position'] = 	Sql query to replace the value Ex. SELECT code,name FROM cars. The first fields of the query will
										be used to compare with the actual value of the column on the grid. The second value will be the 
										replace value.
										'position' is the column position that will be replace.
	
	******************************************  CLASS LISTS ***********************************************************
	*/
	class lists{
		var $sqldebug= false ;
		var $sql="";
		var $from="";
		var $fields="";
		var $group="";
		var $distinctrow="";
		var $page_title="Listado";
		var $name_excel="";
		var $links=array();	
		var $delete_sentence=array();
		var $erase=1;
		var $replace_sentence=array();
		var $replace_fields=array();
		var $currency_symbol;
		var $edit_page="";
		var $actual_page="";
		var $total_rows=0;
		var $fields_names=array();
		var $sql_type="SIMPLE";
		var $bd_ID;
		var $key_position=array();
		
//*********************************************************************************************************************************
		//				CLASS CONSTRUCTOR
//*********************************************************************************************************************************
		
		function lists($sql="",$group="",$distinct="",$page_title="",$name_excel="",$links=NULL,$nombre_campos=NULL,$delete_sentence=NULL,$currency_symbol="",$actual_page="",$edit_page="",$erase=1,$reemplazo=NULL){
			if($sql!=""){
				if($reemplazo!=NULL)
					$this->replace_sentence=$reemplazo;
				$this->erase=$erase;
				$this->actual_page=$actual_page;
				$this->edit_page=$edit_page;
				$this->sql=str_replace("\\","",$sql);
				$this->group=$group;
				//********************************************** 
				//				PAGE TITLE
				//***********************************************
				if($page_title!=""){
					$this->page_title=$page_title;
					$this->name_excel=$page_title."_".date("Y_m_d");?>
					
<head>
						<meta http-equiv="content-type" content="text/html; charset=utf-8" />
						<title><?=$this->page_title?></title>
</head><?
				}
				//********************************************** 
				//			LINKS, FIELDS NAMES AND DELETE SENTENCE
				//***********************************************
				$this->links=$links;
				if($nombre_campos!=NULL)
					$this->fields_names=$nombre_campos;
				$this->delete_sentence=$delete_sentence;
				
				//*********************************************** 
				//	WHAT KIND OF QUERY IT IS (SIMPLE OR JOIN)
				//***********************************************
				
				$first=strpos($this->sql,"FROM")+5;
				$final=strpos($this->sql,"WHERE")-1;
				if($final<0)
					$longitud=strlen($this->sql);
				else
					$longitud=(strpos($this->sql,"WHERE")-1)-$first;
				$this->from=substr($sql,$first,$longitud);
				//echo "from $this->from";
				$first-=12;
				$this->fields=ltrim(substr($this->sql,6,$first));
				$this->distinctrow=$distinct;
				if(strstr($this->from,",") || strstr($this->from,"JOIN")){
					$this->sql_type="JOIN";
				}
				//***********************************************
				//		EXCEL NAME FILE
				//***********************************************
				if($name_excel!=""){
					if(stristr($name_excel,".xls")){
						$nombre_ex=split(".xls",$name_excel);
						$name_excel=$nombre_ex[0];
					}
					$this->name_excel=$name_excel;
					$this->ruta=str_replace("\\","/",realpath($PHP_SELF));
				}
				//***********************************************
				//		CONNECTION WITH THE DB
				//***********************************************
				include_once ("db/ut_para.php");
				include_once ("db/ut_con.php");
				$this->bd_ID = new BD;
				$this->bd_ID->con($bd_Nombre,$bd_Servidor,$bd_Usuario,$bd_Clave);
				//***********************************************
				//		KEY POSITION
				//***********************************************
				$this->key_position=$this->search_key_position();
				$this->currency_symbol=$currency_symbol;
			}else
				echo "YOU MUST WRITE A SQL QUERY: $sql";
		}
		
		
//*********************************************************************************************************************************
		//			TOTAL ROWS OF THE SQL QUERY
//*********************************************************************************************************************************

		function calculate_total_rows($bd){
			$from_num_reg=substr($this->sql,strpos($this->sql,"FROM"),strlen($this->sql));
			if($this->distinctrow=="")
				$sql_cont="SELECT COUNT(*) $from_num_reg";
			else
				$sql_cont="SELECT COUNT(DISTINCTROW($this->distinctrow)) $from_num_reg";
			$id=$this->bd_ID->sql($sql_cont);
			if(!$id){
				if($this->sql_type=="SIMPLE")
					echo "<font face=verdana size=2 color=#ff0000>Posible problem with the SQL QUERY: <strong>($this->sql)</strong><br>MySql reports:<br>";
				else
					echo "<font face=verdana size=2 color=#ff0000>Posible problem with <strong>(DISTINCTROW = $this->distinctrow)</strong>,<br>Mysql reports:<br>";
				echo "<strong>".mysql_error()."</strong></font>";
				return 0;
			}else
				if($row=mysql_fetch_array($id)){
					return $this->total_rows=$row[0];
				}
		}
		
		
//*********************************************************************************************************************************
		//		SEARCH FOR THE KEY POSITION IN THE FROM STATEMENT, IF NOT EXIST, PUT THE KEY AT THE END OF THE FROM WITHOUT SHOWING IT ON THE GRID
//*********************************************************************************************************************************
		function search_key_position(){
			$separate_fields=split(",",$this->fields);
			$n_fields=count($separate_fields);
			if($this->sql_type=="SIMPLE"){
				if(stristr($this->from," as ")){
					$as="";
					$from_split=split(" as",$this->from);
					$tabla=$from_split[0];
					$as=$from_split[1].".";
				}else
					$tabla=$this->from;
				if(count($this->delete_sentence['table'])==0)
					$this->delete_sentence['table'][0]=$tabla;
				$result=mysql_list_fields($this->bd_ID->BaseDatos,$tabla);
				$n_col=mysql_num_fields($result);
				for($i=0;$i<$n_col;$i++){
					if(strstr(mysql_field_flags($result,$i),"primary_key")){
						$llave[]="$as".$this->delete_sentence['key'][]=mysql_field_name($result,$i);
						$key_position[]=$i;
					}
				}
				for($i=0;$i<count($llave);$i++){
					if(stristr($this->fields,"*"))
						return $key_position;
					elseif(stristr($this->fields,$llave[$i].",") || stristr($this->fields,",".$llave[$i]." ")){
						for($j=0;$j<$n_fields;$j++)
							if(strcmp($separate_fields[$j],$llave[$i])==0)
								$key_position[$i]=$j;
					}else{
						$key_position[$i]=$n_fields+$i;
						$this->sql=str_replace(" FROM",",$llave[0] FROM",$this->sql);
					}
				}
			}elseif(count($this->delete_sentence)>0 || count($this->links['window'])>0){//fin if SENCILLO -----Si es JOIN
				$as="";
				$from_join=split(",",$this->from);
				if(stristr($from_join[0]," as ")){
					$from_split=split(" as",$from_join[0]);
					$tabla=$from_split[0];
					$as=$from_split[1].".";
				}else
					$tabla=$from_join[0];
				
				if(stristr($this->fields,".*") || stristr($this->fields," * ") ){
					$result=mysql_list_fields($this->bd_ID->BaseDatos,$tabla);
					$n_col=mysql_num_fields($result);
					for($i=0;$i<$n_col;$i++){
						if(strstr(mysql_field_flags($result,$i),"primary_key")){
							$key_position[0]=$i;
						}
					}
				}elseif(stristr($this->fields,$this->distinctrow)){
					for($j=-1;$j<$n_fields;$j++)
						if(strcmp($separate_fields[$j],$this->distinctrow)==0)
							$key_position[0]=$j;
				}else{
					$key_position[0]=$n_fields+$i;
					$this->sql=str_replace(" FROM",",$this->distinctrow FROM",$this->sql);
				}
					
				
			}//fin if
			return $key_position;
		}
		
		
//*********************************************************************************************************************************
		//		DELETE(S) ROW(S) WITH THE DELETE_SENTENCE
//*********************************************************************************************************************************
		function delete_row($cod_erase){
			for($i=0;$i<count($this->delete_sentence['table']);$i++){//BY NOW, ONLY DELETE ROWS FROM TABLES WITH A SINGLE PRIMARY KEY
				$sql="DELETE FROM ".$this->delete_sentence['table'][$i]." WHERE ".$this->delete_sentence['key'][$i]."='$cod_erase'";
				$id=$this->bd_ID->sql($sql);
			}
			
		}
		
		
//*********************************************************************************************************************************
		//		SHOW THE QUERY AND ALL ITS CARACTERISTICS
//*********************************************************************************************************************************
		function show($bd,$orden,$row_start,$num_rows,$page_number,$headers,$send,$ordenado,$busqueda_campo,$search,$cod_erase){
			//***********************************************
			// DELETE ROWS
			//***********************************************
			if($send==10){
				$this->delete_row($cod_erase);
			}
			
			//***********************************************
			// FIND THE FIELDS NAMES OF THE QUERY
			//***********************************************
			$search_fields_order=split(",",$this->fields);
			for($j=0;$j<count($search_fields_order);$j++){
				if(strstr($search_fields_order[$j]," as ")){
					$campos_sin_as=split(" as ",$search_fields_order[$j]);
					$search_fields_order[$j]=$campos_sin_as[1];
				}				
			}
			
			//***********************************************
			// IF EXISTS REPLACE_SENTENCE, FIND THE NEW VALUES FROM THE DB
			//***********************************************
				for($i=0;$i<count($search_fields_order);$i++){
					if($this->replace_sentence[$i]!=""){
						$sql_r=$this->replace_sentence[$i];
						$id=$this->bd_ID->sql($sql_r);
						while($r=mysql_fetch_array($id))
							$this->replace_fields[$i][$r[0]]=$r[1];
					}
				}
			//***********************************************
			// CONFIGURE TEXT SEARCH
			//***********************************************
			if($search!=""){
				$search=str_replace("\\","",$search);
				if(!stristr($this->sql,"WHERE"))
					$search=str_replace("AND","WHERE",$search);
				$this->sql.=" $search"; 
			}
			//***********************************************
			//VARIABLES INICIALIZATION
			//***********************************************
			if($num_rows=="")
				$num_rows=50;
			if($row_start=="")
				$row_start=1;
			if($page_number=="")
				$page_number=1;
			if($headers=="")
				$headers=50;
				
			//NUMBER OF ACTUAL PAGE
			$pagina_actual=($page_number-1)*$num_rows;
			//CALCULATE TOTAL ROWS
			$this->calculate_total_rows($bd);
			//CALCULATE PAGE NUMBER
			if($send==1){
				if($row_start>=1){
					if($num_rows==1)
						$page_number=$row_start;
					else
						$page_number=floor($row_start/$num_rows)+1;
				}
				$pagina_actual=$row_start-1;
			}
			
			$total_paginas=ceil($this->total_rows/$num_rows); 
			
			//BOTONS << < > >>
			switch($send){
				case 2: $pagina_actual=0;
						$page_number=1;
						break;
				case 3: if($pagina_actual>$num_rows){
							$pagina_actual=$pagina_actual-$num_rows;
							$page_number--;
						}else{
							$pagina_actual=0;
							$page_number=1;
						}
						break;
				case 4: $pagina_actual=$pagina_actual+$num_rows;
						$page_number++;
						break;
				case 5: if($num_rows==1)
							$pagina_actual=$this->total_rows-($this->total_rows%$num_rows)-1;
						else
							$pagina_actual=$this->total_rows-($this->total_rows%$num_rows);
						$page_number=$total_paginas;
						break;
			}
			
			$sql_todo="$this->sql $this->group $orden";
			$sql_actual="$sql_todo LIMIT $pagina_actual,$num_rows ";
			$id=$this->bd_ID->sql($sql_actual);
			if($this->sqldebug)
			{
			echo $sql_actual;
			}
			if(!$id){
				echo "<font face=verdana size=2 color=#ff0000>Sql Query error :<br><strong>($sql_actual)</strong><br><br>MYSQL reports:<br><strong>".mysql_error()."</strong></font>";
			}else{
				$n_columnas=mysql_num_fields($id);
				
				if(!stristr($this->fields,".*") && !stristr($this->fields," * ") ){
					$separate_fields=split(",",$this->fields);
					$n_fields=count($separate_fields);
					$posicion_codigo_oculto=abs($n_fields-$n_columnas);
				}
				
				$nombre_campos_excel="";
				for($i=0;$i<$n_columnas;$i++){
					$nombre_campos_excel.=$orden_campos[]=ucfirst(mysql_field_name($id,$i));
					$nombre_campos_excel.=";";
					$tipo_campos[]=mysql_field_type($id,$i);
					if(strstr(mysql_field_flags($id,$i),"primary_key"))
						$posicion_borrado=$i;
				}
				if(count($this->fields_names)==0)
					$this->fields_names=$orden_campos;
				//*******************************************************************************
				// MAKE THE QUERY
				//*******************************************************************************
				$cont=0;
				while($row=mysql_fetch_array($id)){
					for($i=0;$i<$n_columnas;$i++)
						if($row[$i]=="")
							$arreglo[$cont][$i]="&nbsp;";
						else
							$arreglo[$cont][$i]=$row[$i];
					
					$cont++;
				}
			}//Fin if Error SQL
			//***********************************************************************************
			//	SHOW THE GRID
			//************************************************************************************?>
			
			<div align="center" class="titulo1"><strong>&nbsp;<?=strtoupper($this->page_title)?></strong>&nbsp; <a href="#"  onClick="print()"><img src="images/impresora.gif" alt="Imprimir pagina" width="31" height="25" border="0"></a><br>
		   <div class="Estilo1" align="center"><strong> Đang hiện từ <?=$pagina_actual+1?> đến <?=$pagina_actual+$cont?> ( Trên tổng số <?=$this->total_rows?> ) </strong></div>
			   <hr noshade color="#000000" size="1">
			</div>
			 <form action="<?=$PHP_SELF?>" method="post" name="forma_orden" class="Estilo1">
			   <table width="100%"  border="0" align="center">
			  <tr>
				<td width="330">        <div align="left">
					  <input type="button" name="Submit" value="Hiện:" onClick="send_form(1)">
					  <input name="num_filas" type="text" id="num_filas" value="<?=$num_rows?>" size="4" maxlength="4">
					  bản ghi bắt đầu từ bản ghi số #
					  <input name="inicio_filas" type="text" id="inicio_filas" value="<?=$row_start?>" size="4" maxlength="4">
				  </div></td>
				<td width="90"><input type="submit" name="Submit2" value="Xếp theo:" onClick="mostrar(ordenado.value)"></td>
				<td width="528"><select name="ordenado" id="select2">
				  <? for($np=0;$np<$n_columnas-$posicion_codigo_oculto;$np++){?>
				  <option value="<?=$search_fields_order[$np]?>" <? if(strstr($orden,$search_fields_order[$np])) echo "selected";?>>
				  <?=$this->fields_names[$np]?>
				  </option>
				  <? 		}?>
				</select>
				  <label></label>			      
				  <br>		        </td>
			  </tr>
			  <tr>
				<td>Lặp lại dòng tiêu đề mỗi
				  <input name="encabezados" type="text" id="encabezados2" value="<?=$headers?>" size="4" maxlength="4"> dòng
			  </td>
				<td width="90">Tìm theo từ:</td>
				<td><input name="busqueda_campo" type="text" id="busqueda_campo" value="<?=$busqueda_campo?>">
			Trong trường được chọn ở ô <strong>Xếp theo</strong> </td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>Từ ngày:(YYYY-MM-DD)</td>
			    <td><label>
        <input type="text" name="startdate" id="startdate"   value="<?php echo $startdate;?>" />
		 <img src="images/cal.gif" onclick="javascript:NewCssCal('startdate','yyyyMMdd')" style="cursor:pointer"/>
      </label></td>
			    </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>Đến ngày :(YYYY-MM-DD)</td>
			    <td> <label>
        <input type="text" name="enddate" id="enddate" width="10"   value="<?php echo $enddate;?>"  />
		<img src="images/cal.gif" onclick="javascript:NewCssCal('enddate','yyyyMMdd')" style="cursor:pointer"/>
      </label></td>
			    </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><input name="boton_busqueda" type="button" id="boton_busqueda" onClick="buscar_texto(ordenado.value,busqueda_campo.value)" value="Tìm kiếm: "></td>
			    <td>&nbsp;</td>
			    </tr>
			  <tr>
				<td colspan="3">
					<div align="center">
					  <input name="atras_inicio" type="button" id="atras_inicio" value="&lt;&lt;"  onClick="send_form(2)"<? if($pagina_actual==0) echo "disabled";?>>
			  
					<input name="atras" type="button" id="atras" value=" &lt; "  onClick="send_form(3)" <? if($pagina_actual<$num_rows) echo "disabled";?>>      
					  <input name="adelante" type="button" id="adelante3" value=" &gt; "  onClick="send_form(4)" <? if($page_number>=$total_paginas) echo "disabled";?>>      
					  <input name="adelante_final" type="button" id="adelante_final2" value="&gt;&gt;"  onClick="send_form(5)" <? if($pagina_actual>=$this->total_rows-$num_rows) echo "disabled";?>>      
					  <? if($total_paginas>0){?>
			&nbsp;&nbsp;&nbsp;&nbsp;Đi đến trang số :
			  <select name="page_number" id="select" onChange="send_form(6)">
						<? 		for($np=1;$np<=$total_paginas;$np++){?>
						<option value="<?=$np?>" <? if($page_number==$np) echo "selected"?>>
						<?=$np?>
						</option>
						<? 		}?>
					  </select>
					<? } ?>
				  </div></td>
				</tr>
			</table>
			 <div align="center" class="Estilo1">
			   <hr  noshade color="#000000" size="1"> 
		       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Xuất ra <strong>EXCEL</strong>
			   : 
			   
		       <input type="button" name="Submit22" value="Trang này thôi" onClick="window.open('excel.php?sql=<?=str_replace("'%","@*",str_replace("'","@@",str_replace("%'","*@",$sql_actual)))?>&nombre=actual_<?=$this->name_excel?>&ruta=<?=$this->ruta?>&nombre_campos=<?=$nombre_campos_excel?>&colocar_nombres='+colocar_nombres_campos.checked,'','');">
				  <input type="button" name="Submit4" value="Tất cả các trang"  onClick="window.open('excel.php?sql=<?=str_replace("'","",str_replace("'%","@*",str_replace("%'","*@",$sql_todo)))?>&nombre=todo_<?=$this->name_excel?>&ruta=<?=$this->ruta?>&nombre_campos=<?=$nombre_campos_excel?>&colocar_nombres='+colocar_nombres_campos.checked,'','');">
  				   <br>
  				  <input name="colocar_nombres_campos" type="checkbox" id="colocar_nombres_campos" value="1">
			 Put fields names at first row<br>
				  <hr  noshade color="#000000" size="1">
			 </div>
			  <table border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#7B858E" bgcolor="#000000">
			<? 
				$cont_fondo=1;
				for($j=0;$j<$cont;$j++){
					$codigo_borrado=$arreglo[$j][$this->key_position[0]];
					$cont_fondo++;
					if(($j%$headers)==0){?>
						<tr>
						  <? if($this->edit_page!="" && $this->actual_page!=""){?><td width="17" background="images/tbl_th.png"></td><? } ?>
						  <? if(count($this->delete_sentence)>0 && $this->erase==1){?><td width="17" background="images/tbl_th.png">&nbsp;</td><? } ?>
						  <td width="17" background="images/tbl_th.png"><div align="center"><strong>#</strong></div></td>
							<? for($ii=0;$ii<$n_columnas-$posicion_codigo_oculto;$ii++){ ?>
								  <td  height="25" background="images/tbl_th.png"><div align="center"><strong><a href="#" onClick="mostrar('<?=$search_fields_order[$ii]?>')">
								  <? echo $this->fields_names[$ii];?></a><?  if(strstr($orden,$search_fields_order[$ii])) if(strstr($orden,"DESC")) echo "&nbsp;<img src='images/s_desc.png' width='11' height='9'>"; else echo "&nbsp;<img src='images/s_asc.png' width='11' height='9'>";?></strong></div></td>
							<? }//fin for 
								//***********************************************************
								//			IF EXIST LINKS OUTSIDE THE GRID
								//***********************************************************
								$n_ope=$n_columnas-$posicion_codigo_oculto;
								if($this->links['window'][$n_ope]!=""){?>
									<td  background="images/tbl_error.png"><div align="center">Operations</div></td>
							<?	}	?>	
						</tr>
				<? }//fin if ?>
			  <tr <? if($cont_fondo%2==0){ echo "bgcolor='#CCCCCC'"; }else{ echo "bgcolor='#E9E9E9'";}?>>
			    <? if($this->edit_page!="" && $this->actual_page!=""){?><td>
                  <a href="#" onClick="editar('<?=$this->actual_page?>','<?=$this->edit_page?>','<?=$codigo_borrado?>')"><img src="images/b_edit.png" alt="Modificar Fila" width="16" height="16" border="0"></a>
                  </td><? }?>
			    <? if(count($this->delete_sentence)>0 && $this->erase==1){?><td><div align="center">
			        <a href="#" onClick="borrar('<?=$codigo_borrado?>')"><img src="images/b_drop.png" alt="Eliminar Fila" width="16" height="16" border="0"></a>
                 
                </div></td> <? }?>
				<td><div align="center">
			      <?=$j+1?>
			    </div></td>
			    <? 	
					for($i=0;$i<$n_columnas-$posicion_codigo_oculto;$i++){ 
						$dato=$arreglo[$j][$i];
						if($tipo_campos[$i]=="real" or $tipo_campos[$i]=="int")		
							$dato=number_format($arreglo[$j][$i]);
						if($this->currency_symbol[$i]==1)
							$dato="U$".$dato;
							?>
				<td width="150" height="20"><div align="center" class="Estilo1">
<? 	
	//*****************************************************************************************************************************
	//				REPLACE CONFIGURATION
	//*****************************************************************************************************************************
					if($this->replace_sentence[$i]!="")
						$dato=$this->replace_fields[$i][$arreglo[$j][$i]];
	//*****************************************************************************************************************************
	//				LINKS CONFIGURATION
	//*****************************************************************************************************************************
					if($this->links['window'][$i]!=""){ 
						if($this->links['distinct'][$i]==1){ 
							$valor_link=$codigo_borrado; 
						}else{//Coloco el valor del link, como el valor dado en la posicion.
						 	$valor_link=$arreglo[$j][$this->links['position'][$i]];
						}
						if($this->links['width'][$i]!="" && $this->links['height'][$i]!="")//Si se ha definido el tama�o de la ventana emergente, si no, se abre en la misma ventana
							echo "<a href=\"#\" onClick=window.open('".$this->links['window'][$i]."?".$this->links['link_variable'][$i]."=".$valor_link."".$this->links['others'][$i]."','','width=".$this->links['width'][$i].",height=".$this->links['height'][$i].",scrollbars=yes')>".$dato."</a>"; 
						else
							echo "<a href=".$this->links['window'][$i]."?".$this->links['link_variable'][$i]."=".$valor_link."".$this->links['others'][$i]." target=".$this->links['target'].">".$dato."</a>"; 
					}else 
						echo $dato;
				?></div></td>
			<? }//fin for 
				//***********************************************************
				//			IF EXIST LINKS OUTSIDE THE GRID
				//***********************************************************
				if($this->links['window'][$n_ope]!=""){
					if($this->links['distinct'][$i]==1){ 
						$valor_link=$codigo_borrado;
					}else{
					 	$valor_link=$arreglo[$j][$this->links['position'][$n_ope]];
					}
					
					?>
					<td bgcolor=#BDBCD6><div align="center"><? if($this->links['width'][$n_ope]!="" && $this->links['height'][$n_ope]!="")//Si se ha definido el tama�o de la ventana emergente, si no, se abre en la misma ventana
							echo "<a href=\"#\" onClick=window.open('".$this->links['window'][$n_ope]."?".$this->links['link_variable'][$n_ope]."=".$valor_link."".$this->links['others'][$n_ope]."','','width=".$this->links['width'][$n_ope].",height=".$this->links['height'][$n_ope].",scrollbars=yes,resizable=1')>".$this->links['link_name'][$n_ope]."</a>"; 
						else
							echo "<a href=".$this->links['window'][$n_ope]."?".$this->links['link_variable'][$n_ope]."=".$valor_link."".$this->links['others'][$n_ope]." target=".$this->links['target'][$n_ope].">".$this->links['link_name'][$n_ope]."</a>"; ?></div></td>
			<?	//************************************************************
				}	?>
				
				</tr>
			<? }//fin for inicial ?>
			</table>
			  <hr  noshade color="#000000" size="1">
			  <div align="center">Export to <strong>EXCEL</strong> :
                <input type="button" name="Submit22" value="This page" onClick="window.open('excel.php?sql=<?=str_replace("'","",str_replace("'%","@*",str_replace("%'","*@",$sql_actual)))?>&nombre=actual_<?=$this->name_excel?>&ruta=<?=$this->ruta?>&nombre_campos=<?=$nombre_campos_excel?>&colocar_nombres='+colocar_nombres_campos.checked,'','');">
                <input type="button" name="Submit4" value="All"  onClick="window.open('excel.php?sql=<?=str_replace("'","",str_replace("'%","@*",str_replace("%'","*@",$sql_todo)))?>&nombre=todo_<?=$this->name_excel?>&ruta=<?=$this->ruta?>&nombre_campos=<?=$nombre_campos_excel?>&colocar_nombres='+colocar_nombres_campos.checked,'','');">
                <br>
                <br>
                <span class="titulo1"><a href="#"  onClick="print()"><img src="images/impresora.gif" alt="Imprimir pagina" width="31" height="25" border="0"></a></span>                <br>
                <input name="orden" type="hidden" id="orden" value="<?=$orden?>">
			  <input name="total_registros" type="hidden" id="total_registros" value="<?=$total_registros?>">
			  <input name="send" type="hidden" id="send" value="0">  
			  <input name="cod_erase" type="hidden" id="cod_erase" value="<?=$cod_erase?>">
			  <input name="busqueda" type="hidden" id="cod_cliente" value="<?=$search?>">
			  </div>
			  <hr  noshade color="#000000" size="1">
			 </form>
			
			<? //***********************************************************************************
			
			
		}
	}
?>



