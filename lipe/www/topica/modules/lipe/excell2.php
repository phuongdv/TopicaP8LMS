
<?php
$cnn=mysql_connect("localhost","root","123");
mysql_query("SET character_set_results=utf8", $cnn);
mb_language('uni');
mb_internal_encoding('UTF-8');
mysql_query("set names 'utf8'",$cnn);
mysql_select_db("lipe2409",$cnn);
$sql_userid="
		select * from mdl_user 
		where id in 
				(select distinct userid 
				from mdl_course_display 
				where course = $courseid) 
		and id not in 
				(select userid 
				from mdl_role_assignments 
				where roleid in (1,2,3,4,8) )
	    order by firstname asc  limit 0,500";
$sql_getweek_title="
         select * from huy_setting_calendar
		 where c_id=$courseid
";
$result_weektitle=mysql_query($sql_getweek_title); 
   while($row_wtitle = mysql_fetch_array($result_weektitle))
   							{
				echo"  <Cell ss:StyleID=\"s75\"/>\n";
				echo"  <Cell ss:StyleID=\"s76\"><Data ss:Type=\"String\">".$row_wtitle[week_name]."</Data></Cell>\n";
				echo"  <Cell ss:StyleID=\"s77\"/>\n";
  				 		} 

$sql_example="
         select * from mdl_quiz_grades userid = 188 and timemodified BETWEEN 1230710400 and 1237014000
";
$stt=1;
$result_1=mysql_query($sql_userid);
  while($row_1 = mysql_fetch_array($result_1))// Lay ra user id theo course id
   {
       
						//echo $read_in;
				       echo"<Row>\n";
				       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"Number\">$stt</Data></Cell>\n";
				       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">$row_1[firstname]</Data></Cell>\n";
				       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">$row_1[lastname]</Data></Cell>\n";
				       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">$row_1[topica_nhom]</Data></Cell>\n";
				       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">".get_time($row_1[lastlogin])."</Data></Cell>\n";
						$sql_date="
				         select DISTINCT(week_name),start_date,end_date,id 
				         from huy_setting_calendar 
				         where c_id=4
         ";
       	$result_2=mysql_query($sql_date);
       	 while($row_2=mysql_fetch_array($result_2))// Lay rA cal_id,star,end
           {
       	   $sqlGetActiveid="SELECT * from
                            huy_setting_lipe s_l 
                            where 
                            s_l.calendar_id=$row_2[id]";
       	  $result_active=mysql_query($sqlGetActiveid);
       	           while($row_active=mysql_fetch_array($result_active))
       	           {
       	           	switch ($row_active[style])
       	           	{
       	           	case "forum":
       	           		$sql_forumpost="
                        select count(*) 
				         from mdl_forum_posts 
				         where userid = $row_1[id] and created BETWEEN $row_2[start_date] and $row_2[end_date]
				         and discussion in (select id from mdl_forum_discussions where forum = $row_active[active_id] 
				         ";
       	           		 $result_3=mysql_query($sql_forumpost);
       	           		 while($row_3=mysql_fetch_array($result_3))
       	 		         {
       	 		         	echo "so bai viet".$row_3['count(*)'];
       	 		         }
       	           	
       	           		
       	           	
       	           	
       	           	}
       	           	
       	           	
       	           }
       	                     	
       }  	

?>    