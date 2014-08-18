<?php
echo " chuc nang nay dang duoc xay dung";
exit();
 if(!isset($_REQUEST['courserid']))

			   {

			   	$courseid="4";

			   }

			   else 

			   $courseid=$_REQUEST['courserid'];

$date=time();   
header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=baocaomonhoc$date.xls");
  
    echo"<?xml version=\"1.0\"?>\n";
    echo"<?mso-application progid=\"Excel.Sheet\"?>\n";

    
 function get_time($unix_time)   
 {
 
$read_in = date("j/m/Y", $unix_time);	
return $read_in; 	
 }
    
    ?>

<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>TRUONGHUUVIET</Author>
  <LastAuthor>TRUONGHUUVIET</LastAuthor>
  <Created>2009-09-18T02:48:45Z</Created>
  <Company>TOPICA EDUCATION</Company>
  <Version>12.00</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>5325</WindowHeight>
  <WindowWidth>14175</WindowWidth>
  <WindowTopX>120</WindowTopX>
  <WindowTopY>30</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s73">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s74">
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s75">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s76">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s77">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s78">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s79">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s80">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
  <Table ss:ExpandedColumnCount="400" ss:ExpandedRowCount="500" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:Index="5" ss:AutoFitWidth="0" ss:Width="95.25"/>
   <Column ss:Index="8" ss:AutoFitWidth="0" ss:Width="55.5"/>
   <Row ss:Index="4">
    <Cell ss:StyleID="s74"><Data ss:Type="String">STT</Data></Cell>
    <Cell ss:StyleID="s74"><Data ss:Type="String">H�?</Data></Cell>
    <Cell ss:StyleID="s74"><Data ss:Type="String">Tên</Data></Cell>
    <Cell ss:StyleID="s74"><Data ss:Type="String">Nhóm</Data></Cell>
    <Cell ss:StyleID="s74"><Data ss:Type="String">Truy nhap gan nhat</Data></Cell>
<?php
$cnn=mysql_connect("localhost","root","123");
mysql_query("SET character_set_results=utf8", $cnn);
mb_language('uni');
mb_internal_encoding('UTF-8');
mysql_query("set names 'utf8'",$cnn);
mysql_select_db("lipenew",$cnn);
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
?>
</Row>

<?php
$sql_example="
         select * from mdl_quiz_grades userid = 188 and timemodified BETWEEN 1230710400 and 1237014000
";
$stt=1;
$result_1=mysql_query($sql_userid);
       while($row_1 = mysql_fetch_array($result_1))
       {
       
//echo $read_in;
       echo"<Row>\n";
       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"Number\">$stt</Data></Cell>\n";
       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">$row_1[firstname]</Data></Cell>\n";
       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">$row_1[lastname]</Data></Cell>\n";
       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">$row_1[topica_nhom]</Data></Cell>\n";
       echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\">".get_time($row_1[lastlogin])."</Data></Cell>\n";
	$sql_date="
         select week_name,start_date,end_date 
         from huy_setting_calendar 
         where c_id=$courseid
         ";
       	$result_2=mysql_query($sql_date);
       	 while($row_2=mysql_fetch_array($result_2))
       	 {
       	   //echo $row_2[week_name];
       	    $sql_forumpost="
         select count(*) 
         from mdl_forum_posts 
         where userid = $row_1[id] and created BETWEEN $row_2[start_date] and $row_2[end_date]
         ";
       	 $result_3=mysql_query($sql_forumpost);
       	 while($row_3=mysql_fetch_array($result_3))
       	 		{
       	 		//echo "so bai viet".$row_3['count(*)'];	
       echo "<Cell ss:StyleID=\"s73\"><Data ss:Type=\"Number\">".$row_3['count(*)']."</Data></Cell>\n";
       	 		}
       	 		 $sql_lecture="
         select max(grade) as grade from mdl_assignment_submissions 
         where userid=$row_1[id] and timemodified BETWEEN $row_2[start_date] and $row_2[end_date]
         ";	
       	 		 echo $sql_lecture;
       	 		 $result_4=mysql_query($sql_lecture);
       	 		while($row_4=mysql_fetch_array($result_4))
       	 		{
			if($row_4[grade]==0)
			{
		echo "<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\"></Data></Cell>\n";		
				}
			else{
       	echo "<Cell ss:StyleID=\"s73\"><Data ss:Type=\"Number\">$row_4[grade]</Data></Cell>\n";
			    }
				
				}
       	  $sql_example="
         select max(grade) as grade from mdl_quiz_grades where userid = $row_1[id] and timemodified BETWEEN $row_2[start_date] and $row_2[end_date]"; 			
       	  $result_5=mysql_query($sql_example);
      echo $sql_example;
       	  while($row_5=mysql_fetch_array($result_5))
       	 		{
				if($row_5[grade]==0)
				{
			echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"String\"></Data></Cell>\n";		
				}
				else
				{
       	 	echo"<Cell ss:StyleID=\"s73\"><Data ss:Type=\"Number\">$row_5[grade]</Data></Cell>\n";
				}
				}
             	}
       	 	$stt++;
       	 	echo"</Row>\n";
       	 }
?>
     </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>300</HorizontalResolution>
    <VerticalResolution>300</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>24</ActiveRow>
     <ActiveCol>13</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet2">
  <Table ss:ExpandedColumnCount="1" ss:ExpandedRowCount="1" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet3">
  <Table ss:ExpandedColumnCount="1" ss:ExpandedRowCount="1" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
