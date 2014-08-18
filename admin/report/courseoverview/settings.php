<?php  // $Id: settings.php,v 1.1.2.3 2008/11/29 14:30:58 skodak Exp $
//require_once('../../../config.php');
$tendangnhap=base64_encode('admin');
$matkhau=base64_encode('admin');
$ADMIN->add('reports', new admin_externalpage('reportcourseoverview', get_string('participants', 'admin'), "$CFG->wwwroot/user/danhsachlop.php?limit=30",'report/courseoverview:view'));
$ADMIN->add('reports', new admin_externalpage('reportcourseoverview', get_string('baocaotinhhinhlopquanly', 'admin'), "http://210.245.9.197/SCMSWebPortal/covanhoctapportal.aspx",'report/courseoverview:view'));
$ADMIN->add('reports', new admin_externalpage('reportcourseoverview', get_string('baocaotinhhinhhoctap', 'admin'), "http://210.245.9.197/SCMSWebPortal/BaoCao/TinhHinhHocTapTongThe3.aspx",'report/courseoverview:view'));
$ADMIN->add('reports', new admin_externalpage('reportcourseoverview', get_string('reportlipe', 'admin'), "http://210.245.9.194/lipe/?topica&mod=_login&username=$tendangnhap&password=RlIyYzR1TnU=",'report/courseoverview:view'));
$ADMIN->add('reports', new admin_externalpage('reportcourseoverview', get_string('courseoverview', 'admin'), "$CFG->wwwroot/$CFG->admin/report/courseoverview/index.php",'report/courseoverview:view'));
?>