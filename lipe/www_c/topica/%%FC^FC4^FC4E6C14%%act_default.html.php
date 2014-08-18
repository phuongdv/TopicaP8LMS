<?php /* Smarty version 2.6.18, created on 2013-10-11 07:00:43
         compiled from default/act_default.html */ ?>
<?php echo '
<script language="javascript">
function changeSection(tbl_id, img_id){
	contract(tbl_id);
	obj_img_id = getObj(img_id);
	var str = obj_img_id.obj.src.toString();
	if (str.indexOf("minus", 0)>-1){
		createCookie(tbl_id, 2, 1);//collapsed
		obj_img_id.obj.src = str.replace(/minus/gi, "plus");
	}else{
		createCookie(tbl_id, 1, 1);//expanded
		obj_img_id.obj.src = str.replace(/plus/gi, "minus");
	}
	//alert(obj_img_id.obj.src);	
}
function collapseSection(tbl_id, img_id){

	var ctbl = readCookie(tbl_id);

	if (ctbl==null){
		createCookie(tbl_id, 2, 1);//collapsed
		contract(tbl_id);
		obj_img_id = getObj(img_id);
		var str = obj_img_id.obj.src.toString();
		obj_img_id.obj.src = str.replace(/minus/gi, "plus");
	}else{
		storeSection(tbl_id, img_id);
	}	
}

function expandSection(tbl_id, img_id){
	var ctbl = readCookie(tbl_id);
	if (ctbl==null){
		createCookie(tbl_id, 1, 1);//expanded
		contract(tbl_id);
		obj_img_id = getObj(img_id);
		var str = obj_img_id.obj.src.toString();
		obj_img_id.obj.src = str.replace(/plus/gi, "minus");
	}else{
		storeSection(tbl_id, img_id);
	}
}

function storeSection(tbl_id, img_id){
	var ctbl = readCookie(tbl_id);
	if (ctbl!=""){
		if (ctbl==2){
			obj_tbl_img = getObj(tbl_id);
			obj_tbl_img.style.display = "none";
			obj_img_id = getObj(img_id);
			var str = obj_img_id.obj.src.toString();
			obj_img_id.obj.src = str.replace(/minus/gi, "plus");		
		}else{
			obj_tbl_img = getObj(tbl_id);
			obj_tbl_img.obj.display = "";
			obj_img_id = getObj(img_id);
			var str = obj_img_id.obj.src.toString();
			obj_img_id.obj.src = str.replace(/plus/gi, "minus");				
		}
	}
}
</script>
'; ?>

<?php echo $this->_tpl_vars['clsCP']->showAllSection(); ?>

<?php echo $this->_tpl_vars['clsCP']->showOnLoadFunc(); ?>