<?php

function dateParseFromFormat($stFormat, $stData)
{
    $aDataRet = array();
    $aPieces = split('[:/.\ \-]', $stFormat);
    $aDatePart = split('[:/.\ \-]', $stData);
    foreach($aPieces as $key=>$chPiece)   
    {
        switch ($chPiece)
        {
            case 'd':
            case 'j':
                $aDataRet['day'] = $aDatePart[$key];
                break;
               
            case 'F':
            case 'M':
            case 'm':
            case 'n':
                $aDataRet['month'] = $aDatePart[$key];
                break;
               
            case 'o':
            case 'Y':
            case 'y':
                $aDataRet['year'] = $aDatePart[$key];
                break;
           
            case 'g':
            case 'G':
            case 'h':
            case 'H':
                $aDataRet['hour'] = $aDatePart[$key];
                break;   
               
            case 'i':
                $aDataRet['minute'] = $aDatePart[$key];
                break;
               
            case 's':
                $aDataRet['second'] = $aDatePart[$key];
                break;           
        }
       
    }
    return $aDataRet;
}

function chuyendoi($value)
{
	$value = str_replace("."," .", $value);
	$value = str_replace("?"," ?", $value);
	#---------------------------------a^
	$value = str_replace("ấ", "a", $value);
	$value = str_replace("ầ", "a", $value);
	$value = str_replace("ẩ", "a", $value);
	$value = str_replace("ẫ", "a", $value);
	$value = str_replace("ậ", "a", $value);
	#---------------------------------A^
	$value = str_replace("Ấ", "a", $value);
	$value = str_replace("Ầ", "a", $value);
	$value = str_replace("Ẩ", "a", $value);
	$value = str_replace("Ẫ", "a", $value);
	$value = str_replace("Ậ", "a", $value);
	#---------------------------------a(
	$value = str_replace("ắ", "a", $value);
	$value = str_replace("ằ", "a", $value);
	$value = str_replace("ẳ", "a", $value);
	$value = str_replace("ẵ", "a", $value);
	$value = str_replace("ặ", "a", $value);
	#---------------------------------A(
	$value = str_replace("Ắ", "a", $value);
	$value = str_replace("Ằ", "a", $value);
	$value = str_replace("Ẳ", "a", $value);
	$value = str_replace("Ẵ", "a", $value);
	$value = str_replace("Ặ", "a", $value);
	#---------------------------------a
	$value = str_replace("á", "a", $value);
	$value = str_replace("à", "a", $value);
	$value = str_replace("ả", "a", $value);
	$value = str_replace("ã", "a", $value);
	$value = str_replace("ạ", "a", $value);
	$value = str_replace("â", "a", $value);
	$value = str_replace("ă", "a", $value);
	#---------------------------------A
	$value = str_replace("Á", "a", $value);
	$value = str_replace("À", "a", $value);
	$value = str_replace("Ả", "a", $value);
	$value = str_replace("Ã", "a", $value);
	$value = str_replace("Ạ", "a", $value);
	$value = str_replace("Â", "a", $value);
	$value = str_replace("Ă", "a", $value);
	#---------------------------------e^
	$value = str_replace("ế", "e", $value);
	$value = str_replace("ề", "e", $value);
	$value = str_replace("ể", "e", $value);
	$value = str_replace("ễ", "e", $value);
	$value = str_replace("ệ", "e", $value);
	#---------------------------------E^
	$value = str_replace("Ế", "e", $value);
	$value = str_replace("Ề", "e", $value);
	$value = str_replace("Ể", "e", $value);
	$value = str_replace("Ễ", "e", $value);
	$value = str_replace("Ệ", "e", $value);
	#---------------------------------e
	$value = str_replace("é", "e", $value);
	$value = str_replace("è", "e", $value);
	$value = str_replace("ẻ", "e", $value);
	$value = str_replace("ẽ", "e", $value);
	$value = str_replace("ẹ", "e", $value);
	$value = str_replace("ê", "e", $value);
	#---------------------------------E
	$value = str_replace("É", "e", $value);
	$value = str_replace("È", "e", $value);
	$value = str_replace("Ẻ", "e", $value);
	$value = str_replace("Ẽ", "e", $value);
	$value = str_replace("Ẹ", "e", $value);
	$value = str_replace("Ê", "e", $value);
	#---------------------------------i
	$value = str_replace("í", "i", $value);
	$value = str_replace("ì", "i", $value);
	$value = str_replace("ỉ", "i", $value);
	$value = str_replace("ĩ", "i", $value);
	$value = str_replace("ị", "i", $value);
	#---------------------------------I
	$value = str_replace("Í", "i", $value);
	$value = str_replace("Ì", "i", $value);
	$value = str_replace("Ỉ", "i", $value);
	$value = str_replace("Ĩ", "i", $value);
	$value = str_replace("Ị", "i", $value);
	#---------------------------------o^
	$value = str_replace("ố", "o", $value);
	$value = str_replace("ồ", "o", $value);
	$value = str_replace("ổ", "o", $value);
	$value = str_replace("ỗ", "o", $value);
	$value = str_replace("ộ", "o", $value);
	#---------------------------------O^
	$value = str_replace("Ố", "o", $value);
	$value = str_replace("Ồ", "o", $value);
	$value = str_replace("Ổ", "o", $value);
	$value = str_replace("Ô", "o", $value);
	$value = str_replace("Ộ", "o", $value);
	#---------------------------------o*
	$value = str_replace("ớ", "o", $value);
	$value = str_replace("ờ", "o", $value);
	$value = str_replace("ở", "o", $value);
	$value = str_replace("ỡ", "o", $value);
	$value = str_replace("ợ", "o", $value);
	#---------------------------------O*
	$value = str_replace("Ớ", "o", $value);
	$value = str_replace("Ờ", "o", $value);
	$value = str_replace("Ở", "o", $value);
	$value = str_replace("Ỡ", "o", $value);
	$value = str_replace("Ợ", "o", $value);
	#---------------------------------u*
	$value = str_replace("ứ", "u", $value);
	$value = str_replace("ừ", "u", $value);
	$value = str_replace("ử", "u", $value);
	$value = str_replace("ữ", "u", $value);
	$value = str_replace("ự", "u", $value);
	#---------------------------------U*
	$value = str_replace("Ứ", "u", $value);
	$value = str_replace("Ừ", "u", $value);
	$value = str_replace("Ử", "u", $value);
	$value = str_replace("Ữ", "u", $value);
	$value = str_replace("Ự", "u", $value);
	#---------------------------------y
	$value = str_replace("ý", "y", $value);
	$value = str_replace("ỳ", "y", $value);
	$value = str_replace("ỷ", "y", $value);
	$value = str_replace("ỹ", "y", $value);
	$value = str_replace("ỵ", "y", $value);
	#---------------------------------Y
	$value = str_replace("Ý", "y", $value);
	$value = str_replace("Ỳ", "y", $value);
	$value = str_replace("Ỷ", "y", $value);
	$value = str_replace("Ỹ", "y", $value);
	$value = str_replace("Ỵ", "y", $value);
	#---------------------------------DD
	$value = str_replace("Đ", "d", $value);
	$value = str_replace("Đ", "d", $value);
	$value = str_replace("đ", "d", $value);
	#---------------------------------o
	$value = str_replace("ó", "o", $value);
	$value = str_replace("ò", "o", $value);
	$value = str_replace("ỏ", "o", $value);
	$value = str_replace("õ", "o", $value);
	$value = str_replace("ọ", "o", $value);
	$value = str_replace("ô", "o", $value);
	$value = str_replace("ơ", "o", $value);
	#---------------------------------O
	$value = str_replace("Ó", "o", $value);
	$value = str_replace("Ò", "o", $value);
	$value = str_replace("Ỏ", "o", $value);
	$value = str_replace("Õ", "o", $value);
	$value = str_replace("Ọ", "o", $value);
	$value = str_replace("Ô", "o", $value);
	$value = str_replace("Ơ", "o", $value);
	#---------------------------------u
	$value = str_replace("ú", "u", $value);
	$value = str_replace("ù", "u", $value);
	$value = str_replace("ủ", "u", $value);
	$value = str_replace("ũ", "u", $value);
	$value = str_replace("ụ", "u", $value);
	$value = str_replace("ư", "u", $value);
	#---------------------------------U
	$value = str_replace("Ú", "u", $value);
	$value = str_replace("Ù", "u", $value);
	$value = str_replace("Ủ", "u", $value);
	$value = str_replace("Ũ", "u", $value);
	$value = str_replace("Ụ", "u", $value);
	$value = str_replace("Ư", "u", $value);
	#---------------------------------
	return $value;
}
function generate_pagination_java($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE)
{
	if(isset($_SESSION['lang']))
	{
		if($_SESSION['lang'] == 'vn')
		{
			$pre = '<li>Trước</li>';
			$nex = '<li>Sau</li>';
		}
		else
		{
			$pre = '<li>Prev</li>';
			$nex = '<li>Next</li>';
		}
			
	}
	
	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
		
		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<li><a href="#" class="currentpage">' . $i . '</a></li>' : '<a href="#" onclick="request(\'' . $base_url . '&p=' . ( ( $i - 1 ) * $per_page ) . '\')" class="txtsearch">' . $i . '</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= ", ";
			}
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{
				$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<li><a href="#" class="currentpage">' . $i . '</a></li>' : '<a  href="#" onclick="request(\'' . $base_url . '&p=' . ( ( $i - 1 ) * $per_page )  . '\')" class="txtsearch">' . $i . '</a>';
					if ( $i <  $init_page_max + 1 )
					{
						$page_string .= ', ';
					}
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
			}
			else
			{
				$page_string .= ' ... ';
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<li><a href="#" class="currentpage">' . $i . '</a></li>'  : '<a  href="#" onclick="request(\'' . $base_url . '&p=' . ( ( $i - 1 ) * $per_page ) . '\')" class="txtsearch"><span style="text-decoration: none">' . $i . '</span></a>';
				if( $i <  $total_pages )
				{
					$page_string .= ", ";
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<li><a href="#" class="currentpage">' . $i . '</a></li>' : '<a  href="#" onclick="request(\'' . $base_url . '&p=' . ( ( $i - 1 ) * $per_page ) . '\')" class="txtsearch">' . $i . '</a>';
			if ( $i <  $total_pages )
			{
				$page_string .= ' ';
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <a  href="#" onclick="request(\'' . $base_url . '&p=' . ( ( $on_page - 2 ) * $per_page ) . '\')" class="txtsearch"><span style="text-decoration: none">'.$pre.'</span></a>&nbsp;&nbsp;' . $page_string;
		}
		
		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;&nbsp;<a  href="#" onclick="request(\'' . $base_url . '&p=' . ( $on_page * $per_page ) . '\')" class="txtsearch"><span style="text-decoration: none">'.$nex.'</span</a>';
		}

	}
	//$page_string = 'Trang: ' . $page_string;
	$page_string = $page_string;
	if($page_string != '' && $_SESSION['lang'] == 'en') $page_string = '<span class="txtsearch">Page:</span> '.$page_string;
	if($page_string != '' && $_SESSION['lang'] == 'vn') $page_string = '<span class="txtsearch">Trang:</span> '.$page_string;
	return $page_string;
}

////////////
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE, $sort_cond="")
{
	//if(isset($_SESSION['lang'])
	//{
		if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en')
		{
			$pre = 'Prev';
			$nex = 'Next';
		}
		else
		{
			$pre = 'Trước';
			$nex = 'Sau';
		}
			
	//}
	
	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
		
		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b >' . '<font size="1" face="Tahoma" color="#FF0000">'. $i .'</font>' . '</b>' : '<a href="' . $base_url .  "&amp;p=" . ( ( $i - 1 ) * $per_page ) . $sort_cond.'" >' . '<font size="1" face="Tahoma" color="#FF0000">'. $i . '</font>'. '</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= ", ";
			}
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{
				$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<b >' . '<font size="1" face="Tahoma" color="#FF0000">'. $i .'</font>'. '</b>' : '<a href="' . $base_url .  "&amp;p=" . ( ( $i - 1 ) * $per_page )  . $sort_cond.'" >' . '<font size="1" face="Tahoma" color="#FF0000">'. $i . '</font>' . '</a>';
					if ( $i <  $init_page_max + 1 )
					{
						$page_string .= ', ';
					}
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
			}
			else
			{
				$page_string .= ' ... ';
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b >' . '<span class="active">'. $i .'</span>' . '</b>'  : '<a href="' . $base_url .  "&amp;p=" . ( ( $i - 1 ) * $per_page ) . $sort_cond.'" ><span style="text-decoration: none">' . '<span>'. $i .'</span>'. '</span></a>';
				if( $i <  $total_pages )
				{
					$page_string .= ", ";
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b >' . '<span class="active">['. $i.']</span>' . '</b>' : '<a href="' . $base_url .  "&amp;p=" . ( ( $i - 1 ) * $per_page ) . $sort_cond.'" >' . '<span>'. $i .'</span>'. '</a>';
			if ( $i <  $total_pages )
			{
				$page_string .= ' ';
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <a href="' . $base_url .  "&amp;p=" . ( ( $on_page - 2 ) * $per_page ) . $sort_cond.'" ><span style="text-decoration: none">'.'<span>'. $pre.'</span>'.'</span></a>&nbsp;&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . $base_url .  "&amp;p=" . ( $on_page * $per_page ) . $sort_cond.'" ><span style="text-decoration: none">'.'<span>'. $nex.'</span>'.'</span</a>';
		}

	}
	return $page_string;
}

///////////
?>
