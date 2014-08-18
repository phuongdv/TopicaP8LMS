<? 



$date=time();   

header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=$date.xls");
 

    if(!isset($_REQUEST['total']))

			   {

			   	$total="10000";

			   }

			   else 

			   $total=$_REQUEST['total'];



echo"<?xml version=\"1.0\"?>\n";

   echo"<?mso-application progid=\"Excel.Sheet\"?>\n";

?>

<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"

 xmlns:o="urn:schemas-microsoft-com:office:office"

 xmlns:x="urn:schemas-microsoft-com:office:excel"

 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"

 xmlns:html="http://www.w3.org/TR/REC-html40">

 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">

  <Author>Truong Huu Viet</Author>

  <LastAuthor>TRUONGHUUVIET</LastAuthor>

  <Created>2009-09-11T09:12:14Z</Created>

  <Company>Topica Edu</Company>

  <Version>12.00</Version>

 </DocumentProperties>

 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">

  <WindowHeight>8640</WindowHeight>

  <WindowWidth>18975</WindowWidth>

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

  <Style ss:ID="s62">

   <Borders>

    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>

   </Borders>

  </Style>

  <Style ss:ID="s69">

   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>

   <Borders>

    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>

   </Borders>

   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"

    ss:Bold="1"/>

  </Style>

  <Style ss:ID="s70">

   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>

   <Borders>

    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>

   </Borders>

   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"

    ss:Bold="1"/>

  </Style>

  <Style ss:ID="s71">

   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>

   <Borders>

    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>

    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>

   </Borders>

   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"

    ss:Bold="1"/>

   <Interior/>

  </Style>

  <Style ss:ID="s72">

   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"

    ss:Italic="1"/>

  </Style>

 </Styles>

 <Worksheet ss:Name="Sheet1">

  <Table ss:ExpandedColumnCount="18" ss:ExpandedRowCount="<? $total=$total+4;echo"$total"; ?>" x:FullColumns="1"

   x:FullRows="1" ss:DefaultRowHeight="15">

   <Column ss:AutoFitWidth="0" ss:Width="33.75"/>

   <Column ss:AutoFitWidth="0" ss:Width="69"/>

   <Column ss:AutoFitWidth="0" ss:Width="84" ss:Span="1"/>

   <Column ss:Index="5" ss:AutoFitWidth="0" ss:Width="107.25"/>

   <Column ss:AutoFitWidth="0" ss:Width="88.5"/>

   <Column ss:AutoFitWidth="0" ss:Width="87"/>

   <Column ss:AutoFitWidth="0" ss:Width="293.25"/>

   <Column ss:AutoFitWidth="0" ss:Width="174"/>

   <Column ss:AutoFitWidth="0" ss:Width="130.5"/>

   <Column ss:AutoFitWidth="0" ss:Width="132.75"/>

   <Column ss:AutoFitWidth="0" ss:Width="63"/>

   <Column ss:AutoFitWidth="0" ss:Width="81.75"/>

   <Column ss:AutoFitWidth="0" ss:Width="111.75"/>

   <Column ss:AutoFitWidth="0" ss:Width="78"/>

   <Column ss:AutoFitWidth="0" ss:Width="554.25"/>

   <Column ss:AutoFitWidth="0" ss:Width="99.75"/>

   <Column ss:AutoFitWidth="0" ss:Width="69.75"/>

   <Row ss:AutoFitHeight="0">

    <Cell ss:Index="5"><Data ss:Type="String">Author</Data></Cell>

    <Cell ss:StyleID="s72"><Data ss:Type="String">vietth</Data></Cell>

   </Row>

   <Row ss:AutoFitHeight="0">

    <Cell ss:Index="5"><Data ss:Type="String">Date</Data></Cell>

   </Row>

   <Row ss:AutoFitHeight="0" ss:Height="42.75">

    <Cell ss:StyleID="s69"><Data ss:Type="String">STT</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Username</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Ho</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Ten </Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Lop</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Nganh</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Nhom</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Co quan</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Chuc danh</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Chuc vu trong lop</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Chuc vu trong nhom</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Candidate</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">Trinh do</Data></Cell>

    <Cell ss:StyleID="s69"><Data ss:Type="String">doi tuong tuyen sinh</Data></Cell>

    <Cell ss:StyleID="s70"><Data ss:Type="String">trang thai</Data></Cell>

    <Cell ss:StyleID="s71"><Data ss:Type="String">Ghi chu</Data></Cell>

   </Row>



<?php 

//include('lang/report.php');







               if(!isset($_REQUEST['nganh']))

			   {

			   	$nganh="";

			   }

			   else 

			   $nganh=$_REQUEST['nganh'];



               //-------------------------------

			   

			   if(!isset($_REQUEST['lop']))

			   {

			   	$lop="";

			   }

			   else 

			   $lop=$_REQUEST['lop'];

               //----------------------------

                if(!isset($_REQUEST['nhom']))

			   {

			   	$nhom="";

			   }

			   else 

			   $nhom=$_REQUEST['nhom'];

               //--------------------------

                if(!isset($_REQUEST['chucdanh']))

			   {

			   	$chucdanh="";

			   }

			   else 

			   $chucdanh=$_REQUEST['chucdanh'];

			   //------------------------------

			   if(!isset($_REQUEST['chucvu']))

			   {

			   	$chucvu="";

			   }

			   else 

			   $chucvu=$_REQUEST['chucvu'];

			   //--------------------------------

			   if(!isset($_REQUEST['chucvutrongnhom']))

			   {

			   	$chucvutrongnhom="";

			   }

			   else 

			   $chucvutrongnhom=$_REQUEST['chucvutrongnhom'];

			   //----------------------------------------

			   if(!isset($_REQUEST['candidate']))

			   {

			   	$candidate="";

			   }

			   else 

			   $candidate=$_REQUEST['candidate'];

			   //----------------------------------

			    if(!isset($_REQUEST['trangthai']))

			   {

			   	$trangthai="";

			   }

			   else 

			   $trangthai=$_REQUEST['trangthai'];

			   //------------------------------

			   if(!isset($_REQUEST['username']))

			   {

			   	$username="";

			   }

			   else 
			   $username=$_REQUEST['username'];

			   

function connect_db()

{

$database='192.168.79.2';

$username='c5tvuel';

$password='viet123';

$dbname='c5tvuel';
/*
$database=$CFG->dbhost;
$username=$CFG->dbuser;
$password=$CFG->dbpass;
$dbname=$CFG->dbname;
*/
$con= mysql_connect($database,$username,$password);

mysql_query("SET character_set_results=utf8", $con);

mb_language('uni');

mb_internal_encoding('UTF-8');

mysql_query("set names 'utf8'",$con);

	

	if (!$con)

  	{

  		die('Loi Ket Noi: ' . mysql_error());

 	 }

    mysql_select_db("$dbname",$con);



	

}













function get_user_data($nganh_qry,

	    $lop_qry,

	    $nhom_qry,

	    $chucdanh_qry,

	    $chucvutronglop_qry,

	    $chucvutrongnhom_qry,

	    $candidate_qry,

	    $status_qry,

	    $username_qry,

	    $page,

	    $limit)

{

	

	

		$sql="SELECT

	    u.id,

		u.username,

		u.firstname,

		u.lastname,

		u.topica_lop,

		u.topica_nganh,

		u.topica_nhom,

		u.topica_coquan,

		u.topica_chucdanh,

		u.topica_chucvutronglop,

		u.topica_chucvutrongnhom,

		u.topica_candidate,

		u.topica_trinhdo,

		u.topica_doituongtuyensinh,

		u.topica_status,

		u.topica_ghichu,

		u.coursecount

		FROM

		mdl_user u

		WHERE

		u.username!='admin'

		AND

		u.username!='guest'

		$nganh_qry

	    $lop_qry

	    $nhom_qry

	    $chucdanh_qry

	    $chucvutronglop_qry

	    $chucvutrongnhom_qry

	    $candidate_qry

	    $status_qry

	    $username_qry

		

				";

	

//echo"$sql";



	

	$result = mysql_query($sql);

	$stt=0;

	while($row = mysql_fetch_array($result))

	{

	$stt ++;	

	echo" <Row ss:AutoFitHeight=\"0\">\n

	<Cell ss:Index=\"1\" ss:StyleID=\"s62\"><Data ss:Type=\"Number\">$stt</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[username]</Data></Cell>\n

	<Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[lastname]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[firstname]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_lop]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_nganh]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_nhom]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_coquan]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_chucdanh]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_chucvutronglop]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_chucvutrongnhom]</Data></Cell>\n

	<Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_candidate]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_trinhdo]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_doituongtuyensinh]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_status]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[topica_ghichu]</Data></Cell>\n

    <Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">$row[coursecount]</Data></Cell>\n

	</Row>\n

    ";

	}

     /*

	while($row = mysql_fetch_array($result))

					{   $nganh=$row[topica_nganh];

					    $chucdanh=$row[topica_chucdanh];

					    $nhom=$row[topica_nhom];

					    $chucvutronglop=$row[topica_chucvutronglop];

					    $chucvutrongnhom=$row[topica_chucvutrongnhom];

					    $trinhdo=$row[topica_trinhdo];

					    $doituong=$row[topica_doituongtuyensinh];

					    $trangthai=$row[topica_status];

					    $userlogin=get_moodle_cookie();

					    $userlogin_bs64=base64_encode($userlogin);

						$scm_bs64=$row[username];

					    $user_b64= base64_encode($scm_bs64);

						echo" <tr  id=\"tabletd\" class=\"tablecontent\"style=\"font-size:9pt\">

						        <td > $tr</td>

						        <td>&nbsp;$row[lastname]</td>

						        <td>&nbsp;$row[firstname]</td>

							    <td>$row[topica_lop]</td>

						        <td>$str_nganh[$nganh]</td>

							    <td>$str_nhom[$nhom]</td>

							    <td>$row[topica_coquan]</td>

							    <td>$str_chucdanh[$chucdanh]</td>

							    <td>$str_chucvutronglop[$chucvutronglop]</td>

							    <td>$str_chucvutrongnhom[$chucvutrongnhom]</td>

							    <td align=\"center\" >$str_candidate[$candidate]</td>

							    <td>$str_trinhdo[$trinhdo]</td>

							    <td>$str_doituong[$doituong]</td>

							    <td align=\"center\" >$str_trangthai[$trangthai]</td>

								<td><a href=\"edit_infor.php?id=$row[id]\"><img  src=\"report/images/b_edit.gif\" title=\"S&#7917;a\"></a></td>

						        <td><a href=\"http://210.245.9.197/SCMSWebPortal/StudentProfiles.aspx?tab=lylich&idhv=$user_b64&idcvht=$userlogin_bs64\" target=\"_blank\" ><img src=\"report/images/scm.gif\" ></a></td>

						      </tr>

						";

						

							 

							

						}

					

       */         

}



connect_db();









	//$page=1;

	if($nganh=="")

	{

		$nganh_qry="";

	}

	else $nganh_qry="AND u.topica_nganh='$nganh'";

	if($lop=="")

	{

		$lop_qry="";

	}

	else $lop_qry="AND u.topica_lop='$lop'";

	if($nhom=="")

	{

		$nhom_qry="";

	}

	else $nhom_qry="AND u.topica_nhom='$nhom'";

	

	if($chucdanh=="")

	{

		$chucdanh_qry="";

	}

	else $chucdanh_qry="AND u.topica_chucdanh='$chucdanh'";

	if($chucvu=="")

	{

		$chucvu_qry="";

	}

	else $chucvu_qry="AND u.topica_chucvutronglop='$chucvu'";

	if($chucvutrongnhom=="")

	{

		$chucvutrongnhom_qry="";

	}

	else $chucvutrongnhom_qry="AND u.topica_chucvutrongnhom='$chucvutrongnhom'";

	if($candidate=="")

	{

		$candidate_qry="";

	}

	else $candidate_qry="AND u.topica_candidate='$candidate'";

	if($trangthai=="")

	{

		

		$trangthai_qry="";

	}

	else $trangthai_qry="AND u.topica_status='$trangthai'";

	if($username=='')

	{

		$username_qry="";

	}

	else 

	{

	$username_qry="AND CONCAT_WS(' ',username,trim(lastname),trim(firstname),topica_lop,topica_chucdanh,topica_coquan,topica_chucvutronglop,topica_chucvutrongnhom,topica_status) LIKE '%$username%'";	

//	$username_qry="AND MATCH (username,firstname,lastname) AGAINST ('$username')";

	}

	get_user_data($nganh_qry,

	    $lop_qry,

	    $nhom_qry,

	    $chucdanh_qry,

	    $chucvu_qry,

	    $chucvutrongnhom_qry,

	    $candidate_qry,

	    $trangthai_qry,

	    $username_qry);

	

	

  

?>

</Table>

  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">

   <PageSetup>

    <Header x:Margin="0.3"/>

    <Footer x:Margin="0.3"/>

    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>

   </PageSetup>

   <Unsynced/>

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

     <ActiveRow>20</ActiveRow>

     <ActiveCol>3</ActiveCol>

    </Pane>

   </Panes>

   <ProtectObjects>False</ProtectObjects>

   <ProtectScenarios>False</ProtectScenarios>

  </WorksheetOptions>

 </Worksheet>

 <Worksheet ss:Name="Sheet2">

  <Table ss:ExpandedColumnCount="1" ss:ExpandedRowCount="1" x:FullColumns="1"

   x:FullRows="1" ss:DefaultRowHeight="15">

   <Row ss:AutoFitHeight="0"/>

  </Table>

  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">

   <PageSetup>

    <Header x:Margin="0.3"/>

    <Footer x:Margin="0.3"/>

    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>

   </PageSetup>

   <Unsynced/>

   <ProtectObjects>False</ProtectObjects>

   <ProtectScenarios>False</ProtectScenarios>

  </WorksheetOptions>

 </Worksheet>

 <Worksheet ss:Name="Sheet3">

  <Table ss:ExpandedColumnCount="1" ss:ExpandedRowCount="1" x:FullColumns="1"

   x:FullRows="1" ss:DefaultRowHeight="15">

   <Row ss:AutoFitHeight="0"/>

  </Table>

  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">

   <PageSetup>

    <Header x:Margin="0.3"/>

    <Footer x:Margin="0.3"/>

    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>

   </PageSetup>

   <Unsynced/>

   <ProtectObjects>False</ProtectObjects>

   <ProtectScenarios>False</ProtectScenarios>

  </WorksheetOptions>

 </Worksheet>

</Workbook>

