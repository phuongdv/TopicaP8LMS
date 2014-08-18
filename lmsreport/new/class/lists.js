function borrar(cod){
	if(confirm('Do you really want to delete the row?')){
		document.forma_orden.send.value=10;
		document.forma_orden.cod_erase.value=cod;
		document.forma_orden.submit();
	}
}
function editar(actual,edicion,codigo){
	window.location.href=edicion+"?codigo_editar="+codigo+"&ventana="+actual+"&orden="+document.forma_orden.orden.value+"&page_number="+document.forma_orden.page_number.value+"&busqueda_campo="+document.forma_orden.busqueda_campo.value;
}

function mostrar(ord){
	if(document.forma_orden.orden.value=='ORDER BY '+ord)
		document.forma_orden.orden.value='ORDER BY '+ord+' DESC';
	else
		document.forma_orden.orden.value='ORDER BY '+ord;
	if(document.forma_orden.busqueda_campo.value=='')
		document.forma_orden.busqueda.value='';
	document.forma_orden.submit();
}

function send_form(envia){
	document.forma_orden.send.value=envia;
	document.forma_orden.submit();
}

function buscar_texto(ord,buscar){
	if(ord.indexOf("(")==-1){
		document.forma_orden.busqueda.value=' AND '+ord+' = \''+buscar+'\'';
		 document.forma_orden.send.value=1;
		mostrar(ord);
	}else
		alert("This column not allow text search, please select another column.");
}

function tipo_archivo(){
	alert(document.forma_orden.exportar);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"?enviar=6'");
}
