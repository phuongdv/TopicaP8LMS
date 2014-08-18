<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Date Helpers
 * 
 * This overrides Codeigniter's helpers/date_helper.php
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package		PyroCMS\Core\Helpers
 */


if (!function_exists('format_date'))
{

	/**
	 * Formats a timestamp into a human date format.
	 *
	 * @param int $unix The UNIX timestamp
	 * @param string $format The date format to use.
	 * @return string The formatted date.
	 */
	function format_date($unix, $format = '')
	{
		if ($unix == '' || !is_numeric($unix))
		{
			$unix = strtotime($unix);
		}

		if (!$format)
		{
			$format = Settings::get('date_format');
		}

		return strstr($format, '%') !== false ? ucfirst(utf8_encode(strftime($format, $unix))) : date($format, $unix);
	}

	if(!function_exists('formatDateVN')){

		function formatDateVN($date_time='',$int_time=false,$fmt='DATE_VN'){
			if(!$int_time)
				$date_time=strtotime($date_time);
			$formats = array(
				'DATE_ATOM'		=>	'%Y-%m-%dT%H:%i:%s%O',
				'DATE_COOKIE'	=>	'%l, %d-%M-%y %H:%i:%s UTC',
				'DATE_ISO8601'	=>	'%Y-%m-%dT%H:%i:%s%O',
				'DATE_RFC822'	=>	'%D, %d %M %y %H:%i:%s %O',
				'DATE_RFC850'	=>	'%l, %d-%M-%y %H:%i:%s UTC',
				'DATE_RFC1036'	=>	'%D, %d %M %y %H:%i:%s %O',
				'DATE_RFC1123'	=>	'%D, %d %M %Y %H:%i:%s %O',
				'DATE_RFC2822'	=>	'%D, %d %M %Y %H:%i:%s %O',
				'DATE_RSS'		=>	'%D, %d %M %Y %H:%i:%s %O',
				'DATE_W3C'		=>	'%Y-%m-%dT%H:%i:%s%O',
				'DATE_VN'		=>	'%D, ngày %d/%m/%Y %H:%i:%s'
			);
			if ( ! isset($formats[$fmt]))
			{
				return FALSE;
			}
			$date_time_new=mdate($formats[$fmt],$date_time);
			$en=array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
			$vi=array('Chủ nhật','Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7');
			return str_replace($en,$vi,$date_time_new);
		}
	}

}