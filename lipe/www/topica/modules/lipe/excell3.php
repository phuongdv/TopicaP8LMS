
<?php

function connect_db()
{
$cnn=mysql_connect("localhost","root","123");
mysql_query("SET character_set_results=utf8", $cnn);
mb_language('uni');
mb_internal_encoding('UTF-8');
mysql_query("set names 'utf8'",$cnn);
mysql_select_db("lipe2409",$cnn);
}

function get_forumpost($u_id,$st,$ed,$ac)
	{
	 $sql="select count(*) 
		   from mdl_forum_posts 
		   where userid = $u_id and created BETWEEN $st and $ed
				         and discussion in 
				             (select id 
				             from mdl_forum_discussions 
				             where forum = $ac )
				         ";	
	 //echo $sql;
	     $result=mysql_query($sql);
       	           		 while($row=mysql_fetch_array($result))
       	 		         {
       	 		         	echo "so bai viet".$row['count(*)'];
       	 		         }
	}
	
function get_ExamGrade()
		{
	     $sql="";
			
			
			
		}	

connect_db();		


$sql_getuserid="select * from mdl_user 
		where id in 
				(select distinct userid 
				from mdl_course_display 
				where course = 56) 
		and id not in 
				(select userid 
				from mdl_role_assignments 
				where roleid in (1,2,3,4,8) )
	    order by firstname asc  limit 0,5";
// get to user id follow courseid
    $result=mysql_query($sql_getuserid);
while($row = mysql_fetch_array($result))// get user id
 {
     //----------------------get calendar id,start date,end date  -------------------------- 	
     $userid=$row[id];  	
     //-- for user name
     $firstname=$row[firstname];
     echo $firstname."\n"; 
     $sql_getCalendar="select DISTINCT(week_name),start_date,end_date,id 
				         from huy_setting_calendar 
				         where c_id=56";
     $result_cal=mysql_query($sql_getCalendar);
     while($row_cal = mysql_fetch_array($result_cal))
     {
     	$calid=$row_cal[id];
     	$std=$row_cal[start_date];
     	$end=$row_cal[end_date];
     	//-----------------------------get active id -------------------------
     	$sql_getLipe="SELECT * from
                            huy_setting_lipe s_l 
                            where 
                            s_l.calendar_id=$calid";
     	     //echo $calid."\n";
			 //echo $sql_getLipe."\n";
			 //exit();
     	     $result_lip=mysql_query($sql_getLipe);
          while($row_lip = mysql_fetch_array($result_lip))
          {
          	$active_id=$row_lip[active_id];
          	$active_style=$row_lip[style];
          	switch ($active_style)
          	{
          		case "forum":
          	     get_forumpost($userid,$std,$end,$active_id);			
          		//echo $userid."/".$std."/".$end."/".$active_id;
          		
          		//echo $active_id;
				case "exam";
          	}
          	
          	
          	
          	
          	
          }
     	
     	
     }

       	
       	
       	
       	
       	
  //--------------------end get calendar-------------------------------------------------     	
 }


		?>
    