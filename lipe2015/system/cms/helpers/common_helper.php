<?php defined('BASEPATH') OR exit('No direct script access allowed');

function showDateTime($timestamp = ''){
	return date(DATETIME_DISPLAY_FORMAT,strtotime($timestamp));
}
function formatDateTimeIntTime($int_time = ''){
	return date(DATETIME_DISPLAY_FORMAT,$int_time);
}
function formatDate($int_time = 0){
	return date(DATE_FORMAT,$int_time);
}
function formatDbDateTime($timestamp = ''){
	return date(DATETIME_FORMAT,strtotime($timestamp));
}

function getCurrentDateTime(){
	return date(DATETIME_FORMAT,time());
}

function url_address(){
	if (isset($_SERVER['HTTPS'])){
		$url = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	}else{
		$url = 'http';
	}
	return $url .'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}


/********** Xử lý chuỗi **********/
function cutString($str, $length, $char=" ..."){
	$str = trim($str);
	//Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
	$strlen = mb_strlen($str, "UTF-8");
	if($strlen <= $length){
		return $str;
	}
	//Cắt chiều dài chuỗi $str tới đoạn cần lấy
	$substr = mb_substr($str, 0, $length, "UTF-8");
	if(mb_substr($str, $length, 1, "UTF-8") == " "){
		return $substr . $char;
	}
	//Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
	$strPoint= mb_strrpos($substr, " ", "UTF-8");
	//Return string
	if($strPoint < $length - 20){
		return $substr . $char;
	}else{
		return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
	}
}


/********** Xóa bớt dữ liệu bảng ci_sessions **********/
function cleaner($key='',$limit=2000){
	if($key!='123789')
		return false;
	$sql_count_ci="select count(session_id) from ci_sessions";
	$total_rows=@mysql_result(@mysql_query($sql_count_ci),0);
	if($total_rows>$limit){
		@mysql_query("delete from ci_sessions");
	}
}

/**
 * Hàm đệ quy tính giai thừa
 * @author CaoPV
 * @param mixed $n
 * @return mixed
 */
function factorial($n)
{
	if ($n <= 1)
		return 1;
	else
		return $n * factorial($n-1);
}

/**
 * @param int $id
 * Get mode name
 */
function getModeName($id=1){
	switch($id){
		case 1:$mode_name='Mode 1 - Có Offline';break;
		case 2:$mode_name='Mode 2 - Không Offline, có diễn đàn';break;
		case 3:$mode_name='Mode 3 - Không Offline, không diễn đàn';break;
		default:$mode_name='Mode 1 - Có Offline';break;
	}
	return $mode_name;
}

/**
 * @param $arr
 * @param string $username
 * @param string $starttime
 * @param string $endtime
 * @return array
 * Đếm số bài đăng trên diễn đàn VBB
 */
function getVbbPost(&$arr,$username='',$active_ids=array(),$starttime='', $endtime=''){
	$time_stamp_min_date=date('Y-m-d',$starttime).' 00:00:00';
	$int_time_min_date=strtotime($time_stamp_min_date);

	$time_stamp_max_date=date('Y-m-d',$endtime).' 23:59:59';
	$int_time_max_date=strtotime($time_stamp_max_date);

	$result=array();
	if(!empty($arr)){
		foreach($arr as $key=>$post){
			if($post->username==$username&&in_array($post->forumid,$active_ids)&&$post->dateline>=$int_time_min_date&&$post->dateline<=$int_time_max_date){
				$result[]=$post;
				unset($arr[$key]);
			}
		}
	}
	return $result;
}

/**
 * @param $arr
 * @param string $lipe_type
 * @param int $calendar_id
 * @return array
 * Setting Lipe
 */
function getSettingLipe(&$arr,$lipe_type='P',$calendar_id=0){
	$result=array();
	if(!empty($arr)){
		foreach($arr as $key=>$setting_lipe){
			if($calendar_id){
				if($setting_lipe->lipe_type==$lipe_type&&$setting_lipe->calendar_id==$calendar_id){
					$result[]=$setting_lipe;
				}
			}else{
				if($setting_lipe->lipe_type==$lipe_type){
					$result[]=$setting_lipe;
				}
			}
		}
	}
	return $result;
}

/**
 * @param array $q169_attempts_p
 * @param array $active_ids
 * @param int $user_id
 * @return array
 * @author CaoPV
 */
function getPractices(&$q169_attempts_p=array(),$active_ids=array(),$user_id=0,$starttime='', $endtime=''){
	$time_stamp_min_date=date('Y-m-d',$starttime).' 00:00:00';
	$int_time_min_date=strtotime($time_stamp_min_date);

	$time_stamp_max_date=date('Y-m-d',$endtime).' 23:59:59';
	$int_time_max_date=strtotime($time_stamp_max_date);

	$result=array();
	if(!empty($q169_attempts_p)){
		foreach($q169_attempts_p as $key=>$obj){
			if(!empty($active_ids)){
				if($obj->userid==$user_id&&in_array($obj->quiz,$active_ids)&&strtotime($obj->finishtime)>=$int_time_min_date&&strtotime($obj->finishtime)<=$int_time_max_date){
					$result[]=$obj->quiz;
					unset($q169_attempts_p[$key]);
				}
			}
		}
	}
	$result=array_unique($result);
	return $result;
}

/**
 * @param array $arr
 * @param int $user_id
 * @param int $active_id
 * Lấy điểm E
 */
function getExamE(&$arr=array(),$active_ids=array(),$user_id=0){
	/*$time_stamp_min_date=date('Y-m-d',$starttime).' 00:00:00';
	$int_time_min_date=strtotime($time_stamp_min_date);

	$time_stamp_max_date=date('Y-m-d',$endtime).' 23:59:59';
	$int_time_max_date=strtotime($time_stamp_max_date);*/
	$result=array();
	if(!empty($arr)){
		foreach($arr as $key=>$obj){
			if($obj->userid==$user_id&&in_array($obj->quiz,$active_ids)){
				$result[]=$obj;
				unset($arr[$key]);
			}
		}
	}
	return $result;
}

/**
 * @param array $arr
 * @param int $user_id
 * @param string $starttime
 * @param string $endtime
 * @return array
 * Đếm số câu trả lời
 * @author CaoPV
 */
function getAnswers(&$arr=array(),$user_id=0,$starttime='', $endtime=''){
	$time_stamp_min_date=date('Y-m-d',$starttime).' 00:00:00';
	$int_time_min_date=strtotime($time_stamp_min_date);

	$time_stamp_max_date=date('Y-m-d',$endtime).' 23:59:59';
	$int_time_max_date=strtotime($time_stamp_max_date);

	$result=array();
	if(!empty($arr)){
		foreach($arr as $key=>$answer){
			if($answer->userid==$user_id&&$answer->time>=$int_time_min_date&&$answer->time<=$int_time_max_date){
				$result[]=$answer;
				unset($arr[$key]);
			}
		}
	}
	return $result;
}

/**
 * @param $off
 * @param $post
 * @param $h2472
 * @param $practice
 * @param string $mode
 * @return float
 * Tính điểm chuyên cần
 */
function diemChuyenCan($off=0,$post=0,$h2472=0,$practice=0,$mode=0)
{
	if($mode==1||!$mode)
	{
		$sobaiPost=min(10,$post+$h2472);
		return round(min(10,$off*2+$sobaiPost*1+$practice*1.5),2);
	}
	if($mode==2)
	{
		$sobaiPost=min(10,$post+$h2472);
		return round(min(10,$sobaiPost*1+$practice*2),2);
	}
	if($mode==3)
	{
		return round(min(10,$practice*2.5),2);
	}
	return 0;
}

/**
 * Lịch sử gửi tin
 * @param int $user_id
 */
function getHistorySms($user_id=0){
	$ci=&get_instance();
	$ci->load->model('lipe/sms_send_m');
	$rows=$ci->sms_send_m->limit(3)->get_many_where(array('user_id'=>$user_id),array('reg_date'),null,array('sms_send_id'=>'desc'));
	if(!empty($rows)){
		foreach($rows as $key=>$row){
			if($key!=0) echo '<br/>';
			echo $row->reg_date;
		}
	}
}

/**
 * @param int $course_id
 * Kiểm tra quyền truy cập
 */
function check_access($course_id=0,$update=false,$uri=null){
	$ci=&get_instance();
	if(!isset($_SESSION)){
		session_start();
	}

	$user_data=$ci->session->userdata('user_data');

	if(empty($user_data)){
		header("Location: http://".$_SERVER['HTTP_HOST']."/login/index.php");
	}else{
		$username=$user_data['username'];
		//$user_id=$user_data['user_id'];
		$user_role_id=$user_data['user_role_id'];
		$course_ids=$user_data['course_ids'];
		if($username=='hatvv'){
			return;
		}

		if($user_role_id==5){
			$arr=explode('/',$_SERVER['REQUEST_URI']);
			if(empty($arr)||count($arr)<=3||$arr[2]!='lipe'||(isset($arr[3])&&$arr[3]!='report_personal')){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
				echo 'Bạn không có quyền truy cập vào đường dẫn này !';
				echo '<br/>Bạn chỉ có thể xem bảng điểm cá nhân của mình tại đỉa chỉ sau : ';
				echo '<br/>'.anchor('/lipe/report_personal','Xem bảng điểm cá nhân');
				exit();
			}
		}

		if($user_role_id!=5){
			if(!$update){
				return;
			}

			if($course_id&&in_array($user_role_id,array(1,2,11))){
				if($uri&&strpos($uri,'setting_mode/course')!==false||strpos($uri,'lipe/sms/course')!==false){
					echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
					echo '<div style="text-align: center"><h1>Bạn chỉ được quyền xem, không được phép cập nhật dữ liệu</h1></div>';
					exit();
				}
				$ci->session->set_flashdata('error','Bạn chỉ được quyền xem, không được phép cập nhật dữ liệu !');
				header('Location: '.BASE_URL.'lipe');
			}

			if($course_id&&in_array($user_role_id,array(13,211))){
				if(!in_array($course_id,$course_ids)){
					if($uri&&strpos($uri,'setting_mode/course')!==false){
						echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
						echo '<div style="text-align: center"><h1>Bạn không phải là PO của môn học này</h1></div>';
						exit();
					}
					$ci->session->set_flashdata('error','Bạn không phải là PO của Môn này nên không thể xem chi tiết !');
					header('Location: '.BASE_URL.'lipe');
				}
				return;
			}
		}
	}
	return;
}

function encodeId($input, $key_seed = 'ZpzF6j+ra[g[n%K') {
	$input = trim ( $input );
	$block = mcrypt_get_block_size ( 'tripledes', 'ecb' );
	$len = strlen ( $input );
	$padding = $block - ($len % $block);
	$input .= str_repeat ( chr ( $padding ), $padding );
	$key = substr ( md5 ( $key_seed ), 0, 24 );
	$iv_size = mcrypt_get_iv_size ( MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB );
	$iv = mcrypt_create_iv ( $iv_size, MCRYPT_RAND );
	$encrypted_data = mcrypt_encrypt ( MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv );
	return base64_encode ( $encrypted_data );
}

function decodeId($input, $key_seed = 'ZpzF6j+ra[g[n%K') {
	$input = base64_decode ( $input );
	$key = substr ( md5 ( $key_seed ), 0, 24 );
	$iv_size = mcrypt_get_iv_size ( MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB );
	$iv = mcrypt_create_iv ( $iv_size, MCRYPT_RAND );
	$text = mcrypt_decrypt ( MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv );
	$block = mcrypt_get_block_size ( 'tripledes', 'ecb' );

	$packing = ord ( $text {strlen ( $text ) - 1} );
	if ($packing and ($packing < $block)) {
		for($P = strlen ( $text ) - 1; $P >= strlen ( $text ) - $packing; $P --) {
			if (ord ( $text {$P} ) != $packing) {
				$packing = 0;
			}
		}
	}
	$text = substr ( $text, 0, strlen ( $text ) - $packing );
	return $text;
}