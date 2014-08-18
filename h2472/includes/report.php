<?php
//error_reporting(E_ALL);
setcookie("URLCookie", curPageURL(), time()+3600);
include('header.php');
$template -> set_filenames(array(
'report'	=> $dir_template . 'report.tpl')
);
$template -> assign_vars(array(
'user'	=>	$pro_author
));
// collect data
$startdate = $_POST['startdate'];
$enddate   = $_POST['enddate'];
$course    = $_POST['course'];
$cvht      = $_POST['cvht'];
$po      = $_POST['po'];
$gv      = $_POST['gv'];

// test show data collected
//echo $startdate.",".$enddate.",".$course.",".$cvht.",".$po.",".$gv;
// get course to select
getAllCourse($course);
// get delay list
//get_delay_list($delay);
//get cvht list
getAllCvht($cvht);
//get po list
getAllPo($po);
// get gv list
getAllGv($gv);
// sql filter
// 22-11-2011 : fix do tre theo thoi gian hien tai
$time=time();
 if($course!='0')
 {$sql_course =" and id ='".$course."'";}
 
 
$sql="select c.id cid,c.shortname mamon,c.fullname tenmon,
 (
 select count(id) as 'So cau hoi tuan' from tblanswer WHERE time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') and courseid=cid 
 )
 tongsocauhoi,
	(
			select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
		from tblanswer,tblreply
		WHERE 
		tblreply.answerid=tblanswer.id
		and
		tblreply.time - tblanswer.time <= 3600*72
		and 
    tblanswer.courseid=cid
    and
		tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
	)    
 traloidunghan,
  (
					select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time <= 3600*72
			and 
			tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id in (3)
              and c.id=cid
              )
			and
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
  )
  cvhtdunghan,
    (
    select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time <= 3600*72
			and 
			tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id in (13)
              and c.id=cid
              )
			and
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
  podunghan,
   (
     select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time <= 3600*72
			and 
			tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id in (4,14)and c.id=cid)
			and
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
   gvdunghan,
    (
     select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time <= 3600*72
			and 
			(
         tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id not in (3,13,4,14,5)and c.id=cid)
        or tblanswer.assignid = 0  
      )
			and
      
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
    dunghankhac,
    (
    select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
		from tblanswer,tblreply
		WHERE 
		tblreply.answerid=tblanswer.id
		and
    tblanswer.courseid=cid
    and
		tblreply.time - tblanswer.time > 3600*72
		and 
		tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
    quahan,
    (
					select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time >= 3600*72
			and 
			tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id in (3)
              and c.id=cid
              )
			and
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
  )
  cvhtquahan,
    (
    select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time >= 3600*72
			and 
			tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id in (13)
              and c.id=cid
              )
			and
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
  poquahan,
   (
     select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time >= 3600*72
			and 
			tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id in (4,14)and c.id=cid)
			and
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
   gvqua,
    (
     select count(tblanswer.id) as 'So cau hoi tuan da tra loi' 
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time >= 3600*72
			and 
			(
         tblanswer.assignid in 
							(SELECT DISTINCT u.id
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							WHERE r.id not in (3,13,4,14,5)and c.id=cid)
        or tblanswer.assignid = 0  
      )
			and
      
      tblanswer.courseid=cid
      and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
    )
    quahankhac,
    (
     select count(id)
			from tblanswer
			WHERE 
			tblanswer.id not in (select tblreply.answerid from tblreply)
			and
			tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
			and thread in (SELECT id from tblthread where `status` != 1)
      and tblanswer.courseid=cid
    )
    chuatraloi,
    (
    select count(id)
from tblanswer
WHERE 
tblanswer.id not in (select tblreply.answerid from tblreply)
and
(".$time." - tblanswer.time) <= (3600*24)
and
tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
and thread in (SELECT id from tblthread where `status` != 1)
and tblanswer.courseid=cid
     )
   tre014,
         (
    select count(id)
from tblanswer
WHERE 
tblanswer.id not in (select tblreply.answerid from tblreply)
and
(".$time." - tblanswer.time) >= (3600*24)
and
(".$time." - tblanswer.time) <= (3600*48)
and
tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
and thread in (SELECT id from tblthread where `status` != 1)
and tblanswer.courseid=cid
     )
  tre2448,
    (
    select count(id)
from tblanswer
WHERE 
tblanswer.id not in (select tblreply.answerid from tblreply)
and
(".$time." - tblanswer.time) >= (3600*48)
and
(".$time." - tblanswer.time) <= (3600*72)
and
tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
and thread in (SELECT id from tblthread where `status` != 1)
and tblanswer.courseid=cid
     )
    tre4872,
    (
    select count(id)
from tblanswer
WHERE 
tblanswer.id not in (select tblreply.answerid from tblreply)
and
(".$time." - tblanswer.time) >= (3600*72)
and
tblanswer.time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."') 
and thread in (SELECT id from tblthread where `status` != 1)
and tblanswer.courseid=cid
     )
tre72
from mdl_course  c
WHERE
id in (select courseid from tblanswer WHERE time between UNIX_TIMESTAMP('".$startdate."') AND UNIX_TIMESTAMP('".$enddate."'))".$sql_course;
$result = $db->sql_query($sql);
while ( $data = $db->sql_fetchrow($result))  {
$rows[]=$data;
}
// chuan bi bien cho tinh tong
$tongsocauhoi=0;
$traloidunghan=0;
$cvhtdunghan=0;
$podunghan=0;
$gvdunghan=0;
$dunghankhac=0;
$quahan=0;
$cvhtquahan=0;
$poquahan=0;
$gvquahan=0;
$quahankhac=0;
$chuatraloi=0;
$tre024=0;
$tre2448=0;
$tre4872=0;
$tre72=0;

for($i=0;$i<count($rows);$i++)
{ 
$template -> assign_block_vars('DATA', array(
'stt'		        => $i,
'mamon'		        => $rows[$i]['mamon'],
'tenmon'		    => $rows[$i]['tenmon'],
'tongsocauhoi'		=> $rows[$i]['tongsocauhoi'],
'traloidunghan'		=> $rows[$i]['traloidunghan'],
'cvhtdunghan'		=> $rows[$i]['cvhtdunghan'],
'podunghan'		    => $rows[$i]['podunghan'],
'gvdunghan'	    	=> $rows[$i]['gvdunghan'],
'dunghankhac'		=> $rows[$i]['dunghankhac'],
'quahan'		    => $rows[$i]['quahan'],
'cvhtquahan'		=> $rows[$i]['cvhtquahan'],
'poquahan'		    => $rows[$i]['poquahan'],
'gvquahan'  		=> $rows[$i]['gvqua'],
'quahankhac'		=> $rows[$i]['quahankhac'],
'chuatraloi'		=> $rows[$i]['chuatraloi'],
'tre024'		    => $rows[$i]['tre014'],
'tre2448'		    => $rows[$i]['tre2448'],
'tre4872'		    => $rows[$i]['tre4872'],
'tre72'		        => $rows[$i]['tre72'],
));		

// cong de tinh tong
$tongsocauhoi = $tongsocauhoi + intval($rows[$i]['tongsocauhoi']);
$traloidunghan=$traloidunghan+intval($rows[$i]['traloidunghan']);
$cvhtdunghan=$cvhtdunghan+intval($rows[$i]['cvhtdunghan']);
$podunghan=$podunghan + intval($rows[$i]['podunghan']);
$gvdunghan=$gvdunghan+intval($rows[$i]['gvdunghan']);
$dunghankhac=$dunghankhac+intval($rows[$i]['dunghankhac']);
$quahan=$quahan+intval($rows[$i]['quahan']);
$cvhtquahan=$cvhtquahan+intval($rows[$i]['cvhtquahan']);
$poquahan=$poquahan+intval($rows[$i]['poquahan']);
$gvquahan=$gvquahan+intval($rows[$i]['gvqua']);
$quahankhac=$quahankhac+intval($rows[$i]['quahankhac']);
$chuatraloi=$chuatraloi+intval($rows[$i]['chuatraloi']);
$tre024=$tre024+intval($rows[$i]['tre024']);
$tre2448=$tre2448+intval($rows[$i]['tre2448']);
$tre4872=$tre4872+intval($rows[$i]['tre4872']);
$tre72=$tre72+intval($rows[$i]['tre72']);
}


// hien dong tong 

$template->assign_vars(array(
'tongsocauhoi'		=>$tongsocauhoi,
'traloidunghan'		=>$traloidunghan,
'cvhtdunghan'       =>$cvhtdunghan,
'podunghan'         =>$podunghan,
'gvdunghan'         =>$gvdunghan,
'dunghankhac'       =>$dunghankhac,
'quahan'            =>$quahan,
'cvhtquahan'        =>$cvhtquahan,
'poquahan'          =>$poquahan,
'gvquahan'          =>$gvquahan,
'quahankhac'        =>$quahankhac,
'chuatraloi'        =>$chuatraloi,
'tre024'            =>$tre024,
'tre2448'           =>$tre2448,
'tre4872'           =>$tre4872,
'tre72'             =>$tre72
 ));	

// truyen bien vao form element
$template->assign_vars(array(
'startdate'		=>$startdate,
'enddate'		=>$enddate,

 ));	


$template -> pparse('report');
?>