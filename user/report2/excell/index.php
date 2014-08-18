<?

//--------------------add author info --------------
$author="Truong Huu Viet";
$company="Topica Edu";
//--------------------- title config--------------
$title=array('STT','H&#7885;','T&#234;n','L&#7899;p','Ng&#224;nh','Nh&#243;m','C&#417; quan','CH&#7913;c danh','Ch&#7913;c v&#7909; trong l&#7899;p','Ch&#7913;c v&#7909; trong nh&#243;m','Candidate','Tr&#236;nh &#273;&#7897;','&#272;&#7889;i t&#432;&#7907;ng tuy&#7875;n sinh','Tr&#7841;ng th&#225;i');







echo"<?xml version=\"1.0\"?>";
echo"<?mso-application progid=\"Excel.Sheet\"?>";
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
 </Styles>


  <Worksheet ss:Name="Sheet1">
   <Table ss:ExpandedColumnCount="17" ss:ExpandedRowCount="17" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:Index="11" ss:AutoFitWidth="0" ss:Width="63"/>
   <Column ss:AutoFitWidth="0" ss:Width="81.75"/>
   <Column ss:AutoFitWidth="0" ss:Width="72"/>
   <Column ss:Index="16" ss:AutoFitWidth="0" ss:Width="81.75"/>
   <Column ss:AutoFitWidth="0" ss:Width="65.25"/>
   <Row ss:AutoFitHeight="0"/>
   <Row ss:Index="5" ss:AutoFitHeight="0">
    <Cell ss:Index="4"><Data ss:Type="String">Author</Data></Cell>
    <Cell><Data ss:Type="String">viet</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="4"><Data ss:Type="String">Date</Data></Cell>
   </Row>
<Row ss:Index="8" ss:AutoFitHeight="0">

<?php
    
   foreach ($title as $field)
   {
   	echo"<Cell ss:StyleID=\"s62\"><Data ss:Type=\"String\">".$field."</Data></Cell>\n";
   	
   }
   
  ?>
   </Row>

   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="4" ss:StyleID="s62"><Data ss:Type="String">a2</Data></Cell>
    <Cell ss:StyleID="s62"><Data ss:Type="String">b2</Data></Cell>
    <Cell ss:StyleID="s62"><Data ss:Type="String">c2</Data></Cell>
    <Cell ss:StyleID="s62"><Data ss:Type="String">d2</Data></Cell>
    <Cell ss:StyleID="s62"><Data ss:Type="String">e2</Data></Cell>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
    <Cell ss:StyleID="s62"/>
   </Row>

   </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <Selected/>
   <TopRowVisible>2</TopRowVisible>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>21</ActiveRow>
     <ActiveCol>7</ActiveCol>
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
