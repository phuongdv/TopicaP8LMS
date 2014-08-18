<?php
if (!defined("MIN_YEAR")){
	define("MIN_YEAR", date('Y')-5);
	define("MAX_YEAR", date('Y'));
}
function getDateHtmlJs( $form , $month , $day , $year ,	$defM = null , $defD = null , $defY = null )
{
	$js = 'function changeDate'."$year$month$day".'(){'.getCtrlDateJsOptionFromArr( $form , $month , $day  , $year ).'}';

	$html = addSelectTag(getYearOpti('1' ,'1' ,$defY ),$year , 'class="inputfield" onChange="changeDate'."$year$month$day".'()"' ).''.
			addSelectTag(getMonOpti($defM), $month, 'class="inputfield" onChange="changeDate'."$year$month$day".'()"' ).''.
			addSelectTag(getDayOpti($defM, $defD ), $day,'class="inputfield"').'';

	return array( $js , $html );
}

function getYearOpti( $start , $end , $def = null )
{
	if ( $def )  $defY = $def;
	//else 				 $defY = date('Y');
	
	if ( ereg( "[^(0-9)]" , $start.$end ) ) return false;

	$options = '';
	
	$startYear =MIN_YEAR ; 
	$endYear= MAX_YEAR;
	$list=array();
	$list[$startYear-1]=".....";
	
	for  ( $i = $startYear; $i <= $endYear; ++$i ) 
	{
		$list[$i]=$i;
	}
	
	for  ( $i = $startYear-1; $i <= $endYear; ++$i ) 
	{
		$k = ($i==$startYear-1)? 0 : $i;
		if ( $i == $defY ) $options .= "<option value=\"$k\" selected>$list[$i]</option>";
		else 
		$options	.= "<option value=\"$k\">$list[$i]</option>";
	}
	//var_dump($list);
	return $options;
}



function getMonOpti( $def = null )
{
	if ( $def ) $defM = $def;
	//else 				$defM = date('n');
	$list=array();
	$list[0]=".....";
	
	for  ( $i = 1; $i <= 12; ++$i ) 
	{
		if ( strlen( $i ) == 1 ) $list[$i] = "0$i";
		else $list[$i]=$i; 
		
	}
	
	for ( $i = 0; $i <= 12; ++$i ) 
	{
		if ( strlen($i) == 1 ) 
			$i2 = "0$i";
		else 
			$i2 = $i;

		if ( $i == $defM || $i2 == $defM ) 
		{
			$options .= "<option value=\"$i2\" selected>$list[$i]</option>";
		}
		else
		{
			$options .= "<option value=\"$i2\">$list[$i]</option>";
		}
	}

	return $options;
}


function getDayOpti( $mon = null , $def = null )
{
	//if ( $mon == null ) $mon = date('n');
	if ( $def )	$defD = $def;		
	//else			  $defD = date('j');

	$options = '';
	
	$list=array();
	$list[0]=".....";
	
	if($defD==0) $options .= "<option value=\"0\">$list[0]</option>";
	//$options .= "<option value=\"0\">$list[0]</option>";

	if ( $mon == '4' || $mon == '6' || $mon == '9' || $mon == '11' ) $endDay = 30;
	elseif ( $mon == '2' ) $endDay = 29;
	else $endDay = 31;
	
	for ( $i = 1; $i <= $endDay; ++$i )
	{
		if ( strlen( $i ) == 1  ) 
			$list[$i] = "0$i";
		else  
			$list[$i] = $i;
		//echo $list[$i];

	}
	
	for ( $i = 1; $i <= $endDay; ++$i )
	{
		if ( strlen( $i ) == 1 && $i>=1 ) 
			$i2 = "0$i";
		else
			$i2 = $i;
		
		if ( $i == $defD || $i2 == $defD ) 
		{	
			$options .= "<option value=\"$i2\" selected>$list[$i]</option>";
		}
		else
		{
			$options .= "<option value=\"$i2\">$list[$i]</option>";
		}
	}
	
	return $options;
	
}


function getHierarchyJsOption( & $arr , $form , $paSelName , $selName , $extension = 'setAgain' , $def = null , $defOption = null)
{
	$funcName = $paSelName.md5( uniqid( rand() , 1 ) );

	$js = "	d=document.$form.$paSelName.value;
			function $funcName(n,k,v)".
			'{'."document.$form.$selName.options[n]=new Option(v,k);".'}';
	
	$js2 = "\n var len = document.$form.elements['$selName'].options.length;";
	

	if ( $def != null ) $js2 .= "
		for ( var i = 0 ; i < len ; ++i )
		{
			if ( document.$form.elements['$selName'].options[i].value == $def )
					 document.$form.elements['$selName'].options[i].selected = true;
		}";

	if ( is_array( $arr ) ) 
	{
		foreach ( $arr as $keyunq => $valunq ) 
		{
			$i = 0;
			$keys = null;
			$vals = null;
			$js .= "\n if(d=='$keyunq')".'{'." \n document.$form.$selName.length=0;";

			foreach ( $arr[$keyunq] as $key => $val ) 
			{
				if( $val && $key ) 
				{
					$keys[] = "'".addslashes($key)."'";
					$vals[] = "'".addslashes($val)."'";
					$i++;
				}
			}
			if ( is_array( $keys ) )
			{

				if ( is_array( $defOption ) )
				{
					$i++;

					$js .= "\n k=new Array('0','{$defOption[0]}',".implode( $keys , ',' ).");
							\n v=new Array('.....','{$defOption[1]}',".implode( $vals , ',' ).");";
					$js .= "\n for(j=0;j<".($i + 1).";j++)".'{'."$funcName(j,k[j],v[j])".'}';
				}
				else
				{
					$js .= "\n k=new Array('0',".implode( $keys , ',' ).");
							\n v=new Array('.....',".implode( $vals , ',' ).");";
					$js .= "\n for(j=0;j<".($i + 1).";j++)".'{'."$funcName(j,k[j],v[j])".'}';
				}
			}
			$js .= "\n } \n";
		}
	}

	if ( $extension == 'setAgain' )
	{
		$js = "ind = document.$form.$selName.selectedIndex;
								 $js\n document.$form.$selName.selectedIndex=ind;\n";
	}
	elseif ( $extension == 'setTimeAgain' )
	{
		$js = "dayInd = document.$form.$selName.selectedIndex;\n$js\n
					if ( dayInd >= document.$form.$selName.length ) document.$form.$selName.selectedIndex = 0;									  							\n else document.$form.$selName.selectedIndex = dayInd;\n";
	}

	return array( $js , $js2 );
}

function getCtrlDateJsOptionFromArr( $form , $paSelName , $selName ,$selYear = null )
{
	$dates = array();

	for ( $i = 1 ; $i <= 12 ; ++$i )
	{
		if ( $i == '4' || $i == '6' || $i == '9' || $i == '11' ) $endDay = 30;
		elseif ( $i == '2' ) $endDay = 29;
		else $endDay = 31;

		if ( strlen( $i ) == 1 ) $i2 = "0$i";
		else $i2 = $i;

		for ( $j = 1 ; $j <= $endDay; ++$j )
		{
			if ( strlen( $j ) == 1 ) $j2 = "0$j";
			else $j2 = $j;

			$dates[$i2][$j2] = $j2;
		}
	}

	if ( $selYear ) 
	{
		$leapYearTra = 
		"selYear = document.$form.$selYear.value;
		 selMon = document.$form.$paSelName.value;
		 if (selYear==0){
		 	document.$form.$selName.selectedIndex=0;
			document.$form.$paSelName.selectedIndex=0;
		 }
		if ( ( selMon == 2 ) && (   (   ( ( selYear % 4 ) == 0 ) && ( ( selYear % 100 ) != 0 )   )   ||  ( ( selYear % 400 ) == 0 )   )   )
		{
			 document.$form.$selName.length = 30; 
		}
		else if ( selMon == 2 )
		{
			document.$form.$selName.length = 29; 
		}
		";
	}
	list( $js1 , $js2 ) =getHierarchyJsOption( $dates , $form , $paSelName , $selName , 'setTimeAgain' );
	return $getDayIndex.$js1.$leapYearTra.$setDayIndex;		
}


function addSelectTag( $option , $name , $type = null , $size = null )
{
	if ( $size ) $size = "size = '$size'";
	return "<select name = '$name' $type $size> $option </select>";
}
 
?>
