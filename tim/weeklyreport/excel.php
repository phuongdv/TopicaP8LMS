<?php
include('php-excel.class.php');

$excell= new Excel_XML();
$excell->setEncoding('UTF-8');
$excell->setWorksheetTitle('Firs excel class');
$excell->addArray($columtitle);
$excell->addArray($ex_data);
$excell->generateXML('tim_report_excel.xls');
?>