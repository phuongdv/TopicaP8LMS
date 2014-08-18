<?php
$template -> set_filenames(array(
	'search'	=> $dir_template . 'search.tpl')
);

$act = '';
if(isset($HTTP_GET_VARS['act']))
	$act = $HTTP_GET_VARS['act'];

if ($act == 'logout')
{
	unset($_SESSION['login']);
	session_destroy();
	header('location: ./');
	exit();
}
if ( !isset($_SESSION['security']) || $_SESSION['security'] != 'athkfamily' )
{
	header('location: ./login.php');
	exit('Login failed');
}

$cmd = '';

if(isset($HTTP_GET_VARS['cmd']))
	$cmd = $HTTP_GET_VARS['cmd'];

$p = !empty($HTTP_GET_VARS['p']) ? (int)$HTTP_GET_VARS['p'] : 1;

if ( $cmd == 'Search' )
{
	$template -> assign_vars(array(
		'display'			=> "",
	));

	$tentau			= $HTTP_GET_VARS['name'];
	$matau			= $HTTP_GET_VARS['code'];
	$trongtai		= $HTTP_GET_VARS['dwt'];
	$cang			= $HTTP_GET_VARS['port'];
	$country		= $HTTP_GET_VARS['country'];
	$laycan			= $HTTP_GET_VARS['laycan'];
	$laycanto		= $HTTP_GET_VARS['laycan_to'];
	$tinhtrang		= $HTTP_GET_VARS['status'];

	$sql_trongtai = "SELECT * FROM tbltrongtai ORDER BY id ASC";
	$sql_trongtai = $db->sql_query($sql_trongtai) or die(mysql_error());
	if ( $db->sql_numrows($sql_trongtai) != 1)
	{
		while ($trongtai_rows = $db->sql_fetchrow($sql_trongtai))
		{
			$template -> assign_block_vars('TRONGTAI', array(
					'id'		=> $trongtai_rows['id'],
					'name'		=> $trongtai_rows['name'],
					'selected'	=> ($trongtai_rows['id'] == $trongtai) ? ' selected="selected"' : '',
			));
		}
	}
	$sql_country = "SELECT * FROM tblcountry ORDER BY country_id ASC";
	$sql_country = $db->sql_query($sql_country) or die(mysql_error());
	if ( $db->sql_numrows($sql_country) != 1)
	{
		while ($country_rows = $db->sql_fetchrow($sql_country))
		{
			$template -> assign_block_vars('COUNTRY', array(
					'id'		=> $country_rows['country_id'],
					'name'		=> $country_rows['country_name'],
					'selected'	=> ($country_rows['country_id'] == $country) ? ' selected="selected"' : '',
			));
		}
	}

	$template -> assign_vars(array(
		'matau'			=> $matau,
		'tentau'		=> $tentau,
		'cang'			=> $cang,
		'laycanfrom'	=> $laycanfrom,
		'laycan'		=> $laycan,
		'laycanto'		=> $laycanto,
		'open'			=>	( $tinhtrang && ($tinhtrang == 1) ) ? ' checked' : '',
		'notopen'		=>	( $tinhtrang && ($tinhtrang == 2) ) ? ' checked' : '',
	));


	$extra = "";
	if($tentau != "")
		$extra .= " AND tbltau.tentau LIKE '%".$tentau."%'";
	if($matau != "")
		$extra .= " AND tbltau.matau = '".$matau."'";
	if($trongtai)
		$extra .= " AND tbltau.trongtai = '".$trongtai."'";
	if($tinhtrang)
		$extra .= " AND tbltau.tinhtrang = '".$tinhtrang."'";
	if($cang)
		$extra .= " AND tbltau.cang LIKE '%".$cang."%'";
	if($country)
		$extra .= " AND tbltau.country = '".$country."'";

	if(!$laycan && !$laycanto)
		$extra .= "";
	elseif(!$laycan)
		$extra .= " AND ( tbltau.laycanfrom  <= DATE '".$laycanto."' OR tbltau.laycanfrom <= DATE '".$laycanto."' )";
	elseif(!$laycanto)
		$extra .= " AND ( tbltau.laycanfrom  >= DATE '".$laycan."' OR tbltau.laycanfrom >= DATE '".$laycan."' )";


	$sql_tau = "SELECT tbltau.*, tbltrongtai.code as code, tbltrongtai.name as trongtai, tblcountry.country_name as country 
				FROM tbltau, tbltrongtai, tblcountry 
				WHERE tbltau.trongtai = tbltrongtai.id AND tbltau.country = tblcountry.country_id AND tbltau.matau != '' "
				. $extra . "
				ORDER BY id DESC";

	$sql_tau = $db->sql_query($sql_tau) or die(mysql_error());

	$nRows = $db->sql_numrows($sql_tau);

	$i = 0;
	$stt = 1;
	$page = 1;
	$between = 0;
	$final = '';
	$show_page = '';
	while ( $tau_rows = $db->sql_fetchrow($sql_tau))
	{
		if($laycan && $laycan != "" && $laycanto && $laycanto != "") {
			$laycan_date = dateParseFromFormat("Y-m-d",$laycan);
			$laycanto_date = dateParseFromFormat("Y-m-d",$laycanto);

			$laycan_search = mktime(0, 0, 0, $laycan_date['month'], $laycan_date['day'], $laycan_date['year']);
			$laycanto_search = mktime(0, 0, 0, $laycanto_date['month'], $laycanto_date['day'], $laycanto_date['year']);

			if($laycan_search > $laycanto_search) {
				$between = $laycan_search;
				$laycan_search = $laycanto_search;
				$laycanto_search = $between;
			}

			$laycan_date_tau = dateParseFromFormat("Y-m-d",$tau_rows['laycanfrom']);
			$laycanto_date_tau = dateParseFromFormat("Y-m-d",$tau_rows['laycanto']);

			$laycan_tau = mktime(0, 0, 0, $laycan_date_tau['month'], $laycan_date_tau['day'], $laycan_date_tau['year']);
			$laycanto_tau = mktime(0, 0, 0, $laycanto_date_tau['month'], $laycanto_date_tau['day'], $laycanto_date_tau['year']);

			if($laycan_tau > $laycanto_tau) {
				$between = $laycan_tau;
				$laycan_tau = $laycanto_tau;
				$laycanto_tau = $between;
			}

			$show = false;

			if( (($laycan_search <= $laycan_tau) && ( $laycan_tau <= $laycanto_search)) || (($laycan_search <= $laycanto_tau) && ( $laycanto_tau <= $laycanto_search)) )
				$show = true;
			elseif( ($laycan_tau <= $laycan_search) && ($laycanto_search <= $laycanto_tau) )
				$show = true;
			

			if($show == true) {
				$final[] = $tau_rows;
			}
		} else {
			$final[] = $tau_rows;
		}
	}

	$item_counter = 0;
	if( (int)( (count($final))/10 ) == 0 && count($final) != 0)
		$item_counter = 1;
	else
		$item_counter = (int)(count($final)/10);


	for ($i = 0; $i < count($final); $i++) {
		if($i == 0 || (($i%10) == 0) ) {
			$template -> assign_block_vars('PAGE', array(
				'page' 		=> $page,
				'display'	=> ($page == $p) ? '' :  'none',
			));
			$show_page .= (($page) == $p) ? '<strong>[ <span style="color:#000;">'.($page).'</span> ]</strong> ' : '[ <a href="?code='.$matau.'&dwt='.$trongtai.'&name='.$tentau.'&port='.$cang.'&country='.$country.'&laycan='.$laycan.'&laycan_to='.$laycanto.'&status='.$tinhtrang.'&cmd=Search&p='.($page).'">'.($page).'</a> ] ';
			$page++;
		}
		if($final[$i]['matau'] != '') {
			$template -> assign_block_vars('PAGE.RESULT', array(
				'stt'				=> $stt,
				'class'				=> ( ($class%2) == 0) ? ' class="odd"' : '',
				'matau'				=> $final[$i]['matau'],
				'tentau'			=> $final[$i]['tentau'],
				'trongtai'			=> $final[$i]['trongtaithuc'],
				'captau'			=> ($final[$i]['level'] == 1) ? "International" : "Viet Nam",
				'cang'				=> displayData_Textbox($final[$i]['cang']),
				'nuoc'				=> displayData_Textbox($final[$i]['country']),
				'laycanfrom'		=> displayData_Textbox($final[$i]['laycanfrom']),
				'laycanto'			=> displayData_Textbox($final[$i]['laycanto']),
				'tinhtrang'			=> ($final[$i]['tinhtrang'] == 1) ? 'Open' : '<span style="color:#858585;">Not Open</span>',
				'chutau'			=> str_replace("\n","<br />",displayData_Textbox(base64_decode(base64_decode($final[$i]['chutau'])))),
				'ghichu'			=> str_replace("\n","<br />",displayData_Textbox($final[$i]['ghichu'])),
			));
			$class++;
			$stt++;
		}

	}

	$template -> assign_vars(array(
		'linkpage'			=> $show_page,
	));

	$template -> assign_vars(array(
		'total'			=> $stt - 1,
	));

} else {


	$sql_trongtai = "SELECT * FROM tbltrongtai ORDER BY id ASC";
	$sql_trongtai = $db->sql_query($sql_trongtai) or die(mysql_error());
	if ( $db->sql_numrows($sql_trongtai) != 1)
	{
		while ($trongtai_rows = $db->sql_fetchrow($sql_trongtai))
		{
			$template -> assign_block_vars('TRONGTAI', array(
					'id'		=> $trongtai_rows['id'],
					'name'		=> $trongtai_rows['name'],
			));
		}
	}
	$sql_country = "SELECT * FROM tblcountry ORDER BY country_id ASC";
	$sql_country = $db->sql_query($sql_country) or die(mysql_error());
	if ( $db->sql_numrows($sql_country) != 1)
	{
		while ($country_rows = $db->sql_fetchrow($sql_country))
		{
			$template -> assign_block_vars('COUNTRY', array(
					'id'		=> $country_rows['country_id'],
					'name'		=> $country_rows['country_name'],
			));
		}
	}


	$sql_tau = "SELECT tbltau.*, tbltrongtai.code as code, tbltrongtai.name as trongtai, tblcountry.country_name as country 
				FROM tbltau, tbltrongtai, tblcountry 
				WHERE tbltau.trongtai = tbltrongtai.id AND tbltau.country = tblcountry.country_id AND tbltau.matau != '' "
				. $extra . "
				ORDER BY id DESC";

	$sql_tau = $db->sql_query($sql_tau) or die(mysql_error());

	$nRows = $db->sql_numrows($sql_tau);

	$i = 0;
	$stt = 1;
	$page = 1;
	$between = 0;
	$final = '';
	$show_page = '';

	$laycan = date('Y-m-d');
	$laycanto = date('Y-m-d',strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " +2 week"));

	$template -> assign_vars(array(
		'page2'			=> 'From '.$laycan. ' To ' . $laycanto,
	));

	while ( $tau_rows = $db->sql_fetchrow($sql_tau))
	{
		if($laycan && $laycan != "" && $laycanto && $laycanto != "") {
			$laycan_date = dateParseFromFormat("Y-m-d",$laycan);
			$laycanto_date = dateParseFromFormat("Y-m-d",$laycanto);

			$laycan_search = mktime(0, 0, 0, $laycan_date['month'], $laycan_date['day'], $laycan_date['year']);
			$laycanto_search = mktime(0, 0, 0, $laycanto_date['month'], $laycanto_date['day'], $laycanto_date['year']);

			if($laycan_search > $laycanto_search) {
				$between = $laycan_search;
				$laycan_search = $laycanto_search;
				$laycanto_search = $between;
			}

			$laycan_date_tau = dateParseFromFormat("Y-m-d",$tau_rows['laycanfrom']);
			$laycanto_date_tau = dateParseFromFormat("Y-m-d",$tau_rows['laycanto']);

			$laycan_tau = mktime(0, 0, 0, $laycan_date_tau['month'], $laycan_date_tau['day'], $laycan_date_tau['year']);
			$laycanto_tau = mktime(0, 0, 0, $laycanto_date_tau['month'], $laycanto_date_tau['day'], $laycanto_date_tau['year']);

			if($laycan_tau > $laycanto_tau) {
				$between = $laycan_tau;
				$laycan_tau = $laycanto_tau;
				$laycanto_tau = $between;
			}

			$show = false;

			if( (($laycan_search <= $laycan_tau) && ( $laycan_tau <= $laycanto_search)) || (($laycan_search <= $laycanto_tau) && ( $laycanto_tau <= $laycanto_search)) )
				$show = true;
			elseif( ($laycan_tau <= $laycan_search) && ($laycanto_search <= $laycanto_tau) )
				$show = true;
			

			if($show == true) {
				$final[] = $tau_rows;
			}
		} else {
			$final[] = $tau_rows;
		}
	}

	for ($i = 0; $i < count($final); $i++) {
		if($i == 0 || (($i%10) == 0) ) {
			$template -> assign_block_vars('PAGE', array(
				'page' 		=> $page,
				'display'	=> ($page == $p) ? '' :  'none',
			));
			$show_page .= (($page+1) == $p) ? '<strong>[ <span style="color:#000;">'.($page).'</span> ]</strong> ' : '[ <a href="?p='.($page).'">'.($page).'</a> ] ';
			$page++;
		}
		if($final[$i]['matau'] != '') {
			$template -> assign_block_vars('PAGE.RESULT', array(
				'stt'				=> $stt,
				'class'				=> ( ($class%2) == 0) ? ' class="odd"' : '',
				'matau'				=> $final[$i]['matau'],
				'tentau'			=> $final[$i]['tentau'],
				'trongtai'			=> $final[$i]['trongtaithuc'],
				'captau'			=> ($final[$i]['level'] == 1) ? "International" : "Viet Nam",
				'cang'				=> displayData_Textbox($final[$i]['cang']),
				'nuoc'				=> displayData_Textbox($final[$i]['country']),
				'laycanfrom'		=> displayData_Textbox($final[$i]['laycanfrom']),
				'laycanto'			=> displayData_Textbox($final[$i]['laycanto']),
				'tinhtrang'			=> ($final[$i]['tinhtrang'] == 1) ? 'Open' : '<span style="color:#858585;">Not Open</span>',
				'chutau'			=> str_replace("\n","<br />",displayData_Textbox(base64_decode(base64_decode($final[$i]['chutau'])))),
				'ghichu'			=> str_replace("\n","<br />",displayData_Textbox($final[$i]['ghichu'])),
			));
			$class++;
			$stt++;
		}

	}
	
	$template -> assign_vars(array(
		'linkpage'			=> $show_page,
	));

	$template -> assign_vars(array(
		'display'	=> (count($final) != 0) ? "" : "none",
	));
	
	$template -> assign_vars(array(
		'total'			=> $stt - 1,
	));

}

$template -> pparse('search');
?>
