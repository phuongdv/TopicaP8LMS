<?PHP // $Id: mnet.php,v 1.1 2012/02/16 18:48:33 koenr Exp $ 
      // mnet.php - created with Moodle 1.9.7 (Build: 20091126) (2007101570)
      // local modifications from http://localhost/moodle197


$string['RPC_HTTPS_SELF_SIGNED'] = 'HTTPS (tự kí tên)';
$string['RPC_HTTPS_VERIFIED'] = 'HTTPS (kí tên)';
$string['RPC_HTTP_PLAINTEXT'] = 'HTTP không mã hoá';
$string['RPC_HTTP_SELF_SIGNED'] = 'HTTP (tự kí tên)';
$string['RPC_HTTP_VERIFIED'] = 'HTTP (kí tên)';
$string['aboutyourhost'] = 'Về máy chủ của bạn';
$string['accesslevel'] = 'Mức độ truy cập';
$string['addhost'] = 'Thêm máy chủ';
$string['addnewhost'] = 'Thêm máy chủ mới';
$string['addtoacl'] = 'Thêm vào Bảng kiểm soát truy cập';
$string['allhosts_no_options'] = 'Không có tuỳ chọn nào khi xem ở chế độ nhiều máy chủ';
$string['allow'] = 'Cho phép';
$string['authfail_nosessionexists'] = 'Xét duyệt không thành: phiên làm việc mnet không tồn tại.';
$string['authfail_sessiontimedout'] = 'Xét duyệt không thành: phiên làm việc mnet đã quá hạn.';
$string['authfail_usermismatch'] = 'Xét duyệt không thành: thành viên không chính xác.';
$string['authmnetautoadddisabled'] = 'Chức năng <em>Tự thêm thành viên</em> trong phương thức Xác thực Mạng lưới Moodle đã bị <strong>tắt</strong>.';
$string['authmnetdisabled'] = '<em>Phương thức xác thực</em> Mạng lưới Moodle đã bị <strong>tắt</strong>.';
$string['badcert'] = 'Chứng chỉ an ninh mạng này không hợp lệ';
$string['couldnotgetcert'] = 'Không tìm thấy chứng chỉ bảo mật nào tại <br />$a cả.<br />Máy chủ có thể tạm thời không truy cập được hoặc được cấu hình sai.';
$string['couldnotmatchcert'] = 'Không khớp so với chứng chỉ hiện đang công bố trên máy chủ mạng.';
$string['courses'] = 'khoá học';
$string['courseson'] = 'khoá học trên';
$string['current_transport'] = 'Phương thức vận chuyển hiện thời';
$string['currentkey'] = 'Chìa khoá công cộng hiện thời';
$string['databaseerror'] = 'Không thể ghi chi tiết vào cơ sở dữ liệu';
$string['deleteaserver'] = 'Xoá máy chủ';
$string['deletehost'] = 'Xoá máy chủ';
$string['deletekeycheck'] = 'Bạn có chắc chắn muốn xoá hẳn chìa khoá này?';
$string['deleteoutoftime'] = 'Đã hết hạn 60 giây để xoá chìa khoá này. Xin vui lòng làm lại.';
$string['deleteuserrecord'] = 'SSO ACL: xoá dữ liệu thành viên \'$a[0]\' từ $a[1].';
$string['deny'] = 'Cấm';
$string['description'] = 'Mô tả';
$string['editenrolments'] = 'Ghi danh';
$string['enabled_for_all'] = '(Dịch vụ này đã được mở cho tất cả các máy chủ).';
$string['enrolcourses_desc'] = 'Khoá học mở cho ghi danh từ xa trên máy chủ này.';
$string['enrollingincourse'] = 'Ghi danh vào khoá học $a[0] trên máy chủ $a[1]<br />';
$string['enrolments'] = 'Ghi danh';
$string['enterausername'] = 'Xin vui lòng nhập kí danh hoặc danh sách kí danh, cách nhau bằng dấu phẩy.';
$string['error709'] = 'Hệ thống từ xa đã không lấy được chìa khoá SSL từ máy chủ của bạn.';
$string['expired'] = 'Chìa khoá này sẽ hết hạn vào ngày';
$string['expires'] = 'Có hiệu lực đến ngày';
$string['expireyourkey'] = 'Xoá chìa khoá này';
$string['failedaclwrite'] = 'Không ghi tên thành viên \'$a\' vào Bảng kiểm soát truy cập MNET được.';
$string['forbidden-function'] = 'Chức năng này không được mở cho RPC.';
$string['forbidden-transport'] = 'Phương thức vận chuyển mà bạn chọn không được phép sử dụng.';
$string['forcesavechanges'] = 'Bắt buộc lưu các thay đổi';
$string['helpnetworksettings'] = 'Cấu hình truyền thông liên-Moodle';
$string['hidelocal'] = 'Ẩn thành viên cục bộ';
$string['hideremote'] = 'Ẩn thành viên từ xa';
$string['host'] = 'Máy chủ';
$string['hostcoursenotfound'] = 'Không tìm thấy máy chủ hoặc khoá học';
$string['hostdeleted'] = 'Đã xoá máy chủ';
$string['hostname'] = 'Tên máy chủ';
$string['hostsettings'] = 'Thiết lập máy chủ';
$string['id'] = 'Số hiệu';
$string['idhelp'] = 'Giá trị này được cấp tự động và không thể sửa đổi';
$string['illegalchar-host'] = 'Tên máy chủ của bạn có chứa kí tự không hợp lệ: $a';
$string['illegalchar-moodlehome'] = 'Địa chỉ Moodle của bạn có chứa kí tự không hợp lệ';
$string['invalidaccessparam'] = 'Thông số truy cập không hợp lệ';
$string['invalidactionparam'] = 'Thông số hành động không hợp lệ';
$string['invalidhost'] = 'Bạn phải cho biết chìa khoá SSL hợp lệ';
$string['invalidpubkey'] = 'Đây không phải là chìa khoá SSL hợp lệ';
$string['invalidurl'] = 'Thông số địa chỉ mạng (URL) không hợp lệ';
$string['ipaddress'] = 'Địa chỉ IP';
$string['last_connect_time'] = 'Thời gian truy cập gần nhất';
$string['last_connect_time_help'] = 'Thời điểm truy cập vào máy chủ này gần đây nhất của bạn.';
$string['last_transport_help'] = 'Phương thức vận chuyển mà bạn dùng để truy cập vào máy chủ này lần gần đây nhất.';
$string['logs'] = 'Nhật chí';
$string['mnet'] = 'Mạng lưới Moodle';
$string['mnetenrol'] = 'Ghi danh';
$string['mnetlog'] = 'Nhật chí';
$string['mnetpeers'] = 'Ngang hàng';
$string['mnetservices'] = 'Dịch vụ';
$string['mnetsettings'] = 'Thiết lập mạng lưới Moodle';
$string['mnetthemes'] = 'Giao diện';
$string['moodleloc'] = 'Địa chỉ Moodle';
$string['net'] = 'Mạng lưới';
$string['networksettings'] = 'Thiết lập mạng lưới';
$string['never'] = 'Chưa lần nào';
$string['nosite'] = 'Không tìm thấy khoá học chính của hệ thống';
$string['nosuchfile'] = 'Tập tin/Chức năng $a không tồn tại.';
$string['off'] = 'Tắt';
$string['on'] = 'Mở';
$string['otherenrolledusers'] = 'Thành viên ghi danh khác';
$string['permittedtransports'] = 'Phương thức vận chuyển được phép dùng';
$string['publickey'] = 'Chìa khoá công cộng';
$string['publish'] = 'Công bố';
$string['registerallhosts'] = 'Đăng kí tất cả các máy chủ (<em>Chế độ Hub</em>)';
$string['remotecourses'] = 'Khoá học từ xa';
$string['remotehost'] = 'Hub từ xa';
$string['remotehosts'] = 'Máy chủ từ xa';
$string['remotemoodles'] = 'Moodle từ xa';
$string['restore'] = 'Phục hồi';
$string['reviewhostdetails'] = 'Xem lại chi tiết máy chủ';
$string['reviewhostservices'] = 'Xem lại dịch vụ máy chủ';
$string['settings'] = 'Thiết lập';
$string['showlocal'] = 'Hiển thị thành viên cục bộ';
$string['showremote'] = 'Hiển thị thành viên từ xa';
$string['ssoaccesscontrol'] = 'Kiểm soát truy cập SSO';
$string['strict'] = 'Hạn chế';
$string['subscribe'] = 'Đăng kí theo dõi';
$string['system'] = 'Hệ thống';
$string['testtrustedhosts'] = 'Kiểm tra địa chỉ';
$string['testtrustedhostsexplain'] = 'Nhập địa chỉ IP vào để xem thử đó có phải là máy chủ thật hay không.';
$string['trustedhosts'] = 'Máy chủ XML-RPC';
$string['version'] = 'phiên bản';
$string['warning'] = 'Cảnh báo';
$string['yourhost'] = 'Máy chủ của bạn';
$string['yourpeers'] = 'Máy ngang hàng với bạn';

?>
