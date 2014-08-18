<?php

$DB_HOST = 'amatoplmsforum.cdv75kqsz5y1.ap-southeast-1.rds.amazonaws.com';
$DB_USER = 'amatoplms';
$DB_PASS = 'KrWuTbNY';
$DB_NAME = 'amatoplms';

$url  = 'http://forum.amatop.ph/h2472';
$linkforum='http://forum.amatop.ph';
$linkportal='http://dev.lms.amatop.ph';
$linkelearning='http://elearning.tvu.topica.vn';
include('mysql.php');
$db = new sql_db($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);


// Duong dan den thu muc chua file giao dien
$dir_template = './templates/en/';
$dir_inc = './includes/';

// Thu muc chua file anh cua san pham
$dir_upload = './uploads/';

// Thu muc chua file Tai lieu download
$dir_download = './download/';

$dir_image = './images/';
// So san pham hien thi tren 1 trang man hinh 
$nPageSize = 3;

// So trang tin hien thi tren 1 trang man hinh
$nNewsSize = 3;

$data_upload = './uploads/';
?>
