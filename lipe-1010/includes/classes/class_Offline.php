<?php
class Offline extends DbBasic{
function Setting_Calendar(){
		$this->pkey = "offline_id";
		$this->tbl = "offline";	
	}		
function getOffline($u_id,$c_id){
	global $dbconn;
	$sql="Select number from offline where u_id = '$u_id' and c_id='".$c_id."'";
	$res = $dbconn->getAll($sql);
		//die($res);
	return $res[0]['number'];
	}
function getBt($u_id,$c_id){
	global $dbconn;
	$sql="Select btvn from offline where u_id = $u_id and c_id=$c_id";
	$res = $dbconn->getAll($sql);
		//die($res);
	return $res[0]['btvn'];
	}
 function getCc($off,$post,$h2472,$practice,$mode="")
   {
   if($mode==1 || $mode=="") // default
	   {
	   $sobaiPost=min(10,$post+$h2472);
	   return round(min(10,$off*2+$sobaiPost*1+$practice*1.5),2);
       }
   if($mode==2)
       {
	    $sobaiPost=min(10,$post+$h2472);
	   return round(min(10,$sobaiPost*1+$practice*2),2);
	   }
	if($mode==3)
	   {
        return round(min(10,$practice*2.5),2);
	   }   
   }
 function showGetCc($off,$post,$h2472,$practice)
   {
   $string="O:$off,P:$post+$h2472,Pr:$practice";
   return $string;
   }

function GetClass($c_id)
	{
    global $dbconn;
	$sqlClass="SELECT DISTINCT u.topica_lop
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
order by firstname asc  limit 0,500";
	$res = $dbconn->GetAll($sqlClass);
     return $res;
	}
}
?>