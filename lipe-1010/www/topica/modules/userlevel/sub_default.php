<?
/**
*  Default Action
*  @author		: ĐÀO VĂN TÂM (tamddao@gmail.com)
*  @date		: 08/06/2007
*  @version		: 1.0.0
*/
function default_default(){
	global $assign_list, $_SITE_ROOT, $mod, $clsButtonNav;
	
	$clsUserLevel 	= new UserLevel();
	
	//Init var
	$clsButtonNav->set("CPanel", "/icon/apps_16.gif", "?$_SITE_ROOT");
	$clsButtonNav->set("New", "/icon/add2.png", "?$_SITE_ROOT&mod=$mod&act=add");
	$clsButtonNav->set("Edit", "/icon/edit2.png", "?$_SITE_ROOT&mod=$mod&act=edit", 1,'Update');
	$clsButtonNav->set("List", "/icon/icon-16-content.png", "?$_SITE_ROOT&mod=$mod", 1);
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?$_SITE_ROOT&mod=$mod&act=del",1,'Delete');
	//$clsButtonNav->set("Import", "/icon/import2.png", "?$_SITE_ROOT&mod=$mod&act=import",0);
	//$clsButtonNav->set("Export", "/icon/export2.png", "?$_SITE_ROOT&mod=$mod&act=export",0);
	
	
	
	//Process	
	
	$cmd = 	isset($_POST["cmd"])? $_POST["cmd"] : "";
	if ($cmd=="Delete"){
		$chkItem = $_POST["chkItem"];		
		if (is_array($chkItem))
		foreach ($chkItem as $val){
			$clsUserLevel->deleteOne($val);
		}	
	}
	else if ($cmd=="Update"){
		$id = $_POST["chkItem"];			
		header("Location:?$_SITE_ROOT&mod=$mod&act=add&id=".$id[0]);
	}
	
	
	


	$recordPerPage 	= 10;
	$pageNum = 5;

	$currentPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	
	$intStart = ($currentPage*$recordPerPage);
	$intLimit = $recordPerPage;
	
	
	$r_userlevel		= $clsUserLevel->SelectAll("min_post DESC", $intStart, $intLimit);	
	
	$totalRecord 		= $clsUserLevel->Count();	
	$totalPage	 		= ceil($totalRecord / $recordPerPage);
	
 	$first = intval($currentPage/$pageNum)*$pageNum;
	$pageView = "";
	
	
	for ($i=0; $i<5; $i++)
		if ($first+$i<$totalPage){
			$page = ($first+$i == $currentPage)? "<b>".($first+$i+1)."</b>" : ($first+$i+1);
			$pageView .= "<a href='?$_SITE_ROOT&mod=$mod&page=".($first+$i)."'>".$page."</a> ";
		}
	
	
	
	//Output
	$assign_list['r_userlevel'] 		= $r_userlevel;	
	$assign_list['first']				= $first;
	$assign_list['currentPage'] 		= $currentPage;
	$assign_list['totalRecord'] 		= $totalRecord;
	$assign_list['totalPage'] 			= $totalPage;
	$assign_list['pageNum'] 			= $pageNum;
	$assign_list['pageView'] 			= $pageView;
}
/**
*  Add a new Item
*  @author		: ĐÀO VĂN TÂM (tamddao@gmail.com)
*  @date		: 08/06/2007
*  @version		: 1.0.0
*/
function default_add(){
	global $assign_list,$_CONFIG,$clsButtonNav,$_SITE_ROOT, $mod;
	
	#INIT ================================
		
	$id 				= 	isset($_REQUEST["id"])? $_REQUEST["id"] : "";
		
	$name				= 	$_POST["name"];
	$min_post			= 	$_POST["min_post"];
		
	$btnUpdate			= 	isset($_POST["btnUpdate"])? $_POST["btnUpdate"] : "";
	$btnAdd				=	isset($_POST["btnAdd"])? $_POST["btnAdd"] : "";
	
	$clsUserLevel 	= new UserLevel();	
	$lblCheck			=	"";	
	
	


	
	$clsButtonNav->set("CPanel", "/icon/apps_16.gif", "?$_SITE_ROOT");
	$clsButtonNav->set("New", "/icon/add2.png", "?$_SITE_ROOT&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "?$_SITE_ROOT&mod=$mod&act=edit", 0);
	$clsButtonNav->set("List", "/icon/icon-16-content.png", "?$_SITE_ROOT&mod=$mod", 1);
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?$_SITE_ROOT&mod=$mod&act=del",0);
	//$clsButtonNav->set("Import", "/icon/import2.png", "?$_SITE_ROOT&mod=$mod&act=import",0);
	//$clsButtonNav->set("Export", "/icon/export2.png", "?$_SITE_ROOT&mod=$mod&act=export",0);
	
	
	
	#PROCESS ==============================
	if ($id!=""){
		$r_userlevel  	=	$clsUserLevel->getOne($id);	
	}else{
		$r_userlevel 	= 	"";
	}
	
	if ($btnAdd!=""){
		#Insert		
		$fields 	= "name,min_post";
		$values  	= "'$name','$min_post'";
		$clsUserLevel->insertOne($fields, $values);	
		header("location:?$_SITE_ROOT&mod=$mod");
	}else
	if ($btnUpdate!=""){
		#Update
		$set = "name='$name', min_post='$min_post'";
		$clsUserLevel->updateOne($id, $set);	
		header("location:?$_SITE_ROOT&mod=$mod");
	}
	
	#OUTPUT==================================
	$assign_list["r_userlevel"] = $r_userlevel;
	$assign_list['id'] = $id;	
	
}

/**
*  List all Item
*  @author		: ĐÀO VĂN TÂM (tamddao@gmail.com)
*  @date		: 08/06/2007
*  @version		: 1.0.0
*/

function default_list(){
	global $assign_list;
}


/**
*  Show detail an Item
*  @author		: ĐÀO VĂN TÂM (tamddao@gmail.com)
*  @date		: 08/06/2007
*  @version		: 1.0.0
*/
function default_detail(){
	global $assign_list;
}
?>