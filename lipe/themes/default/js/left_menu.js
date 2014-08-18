//document.GetElementById("").className=on
	function change(obj) {
		//alert(obj);
		if(obj.className == "on"){
			obj.className = "off";
			document.frmTemp.objdrop.value = "";
			document.cookie = "DROPMENU="+document.frmTemp.objdrop.value+";";
		}
		else{
			obj.className = "on";
			if(document.frmTemp.objdrop.value != ""){
				identity=document.getElementById(document.frmTemp.objdrop.value);
				if (identity != null) {
					identity.className = "off";
				}
			}
			document.frmTemp.objdrop.value = obj.id;
			document.cookie = "DROPMENU="+document.frmTemp.objdrop.value+";";
		}
	}