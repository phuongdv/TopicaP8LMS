<?php
require_once("../config.php");
require_login();
global $CFG, $QTYPES;
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);


				
					
	

?>

<table border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td valign="top" width="80"><p>STT<u></u><u></u></p></td>
      <td valign="top" width="80"><p>Tháng<u></u><u></u></p></td>
      <td valign="top" width="80"><p>Số câu đúng hạn<u></u><u></u></p></td>
      <td valign="top" width="80"><p>Quá hạn<u></u><u></u></p></td>
      <td valign="top" width="80"><p>Không trả lời<u></u><u></u></p></td>
      <td valign="top" width="80"><p>% Số câu đúng hạn<u></u><u></u></p></td>
      <td valign="top" width="80"><p>% Quá hạn<u></u><u></u></p></td>
      <td valign="top" width="80"><p>%Không trả lời<u></u><u></u></p></td>
    </tr>
   <?php
   $t=1;
   $m=1;
   $tongdunghan=0;
   $tongquahan=0;
   $tongkotraloi=0;
   for ($i=1293840000;$i<=time();$i=$i+(3600*24*30))
   {
   	$startdate=$i;
   	$enddate=$i+(3600*24*30);
     $query_string = " select (select count(DISTINCT(tblreply.answerid))
						from tblanswer,tblreply
						WHERE 
						tblreply.answerid=tblanswer.id
						and
						tblreply.time - tblanswer.time <= 3600*72 
						and 
      					tblanswer.time between '".$startdate."' and '".$enddate."'
						) dunghan,
			
			(
			 select count(DISTINCT(tblreply.answerid))
						from tblanswer,tblreply
						WHERE 
						tblreply.answerid=tblanswer.id
						and
						tblreply.time - tblanswer.time > 3600*72
						and 
      					tblanswer.time between '".$startdate."' and '".$enddate."'
			
			) quahan,
			(
			 select count(DISTINCT(tblanswer.id))
						from tblanswer
						WHERE 
						tblanswer.id not in (select answerid from tblreply )
						and 
      					tblanswer.time between '".$startdate."' and '".$enddate."'
			) kotraloi";
				    
		//	echo $query_string;

			
			    $ad = $mysqli->query($query_string);
			
			   $dd = $ad->fetch_assoc();
						
							echo '<tr>
      <td valign="top" width="80"><p><u>'.$t.'</u><u></u></p></td>
      <td valign="top" width="80"><p><u></u>Tháng'.$m.' <u></u></p></td>
      <td valign="top" width="80"><p><u></u>'.$dd['dunghan'].' <u></u></p></td>
      <td valign="top" width="80"><p><u></u>'.$dd['quahan'].' <u></u></p></td>
      <td valign="top" width="80"><p><u></u>'.$dd['kotraloi'].'<u></u></p></td>
      <td valign="top" width="80"><p><u></u> <u></u></p></td>
      <td valign="top" width="80"><p><u></u> <u></u></p></td>
      <td valign="top" width="80"><p><u></u> <u></u></p></td>
    </tr>';
							
		$t=$t+1	;	
		
		if($m==12)
		{
			$m=0;
		}	
		$m=$m+1;		

		$tongdunghan=$tongdunghan + intval($dd['dunghan']);
   	    $tongquahan = $tongquahan + intval($dd['quahan']);
   	    $tongkotraloi=$tongkotraloi + intval($dd['kotraloi']);
   }
   
   
   ?> 
<table border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td valign="top" width="80"><p><u></u><u></u></p></td>
      <td valign="top" width="80"><p>Tổng<u></u><u></u></p></td>
      <td valign="top" width="80"><p><u><?php echo $tongdunghan;?></u><u></u></p></td>
      <td valign="top" width="80"><p><u><?php echo $tongquahan;?></u><u></u></p></td>
      <td valign="top" width="80"><p><u><?php echo $tongkotraloi;?></u><u></u></p></td>
      <td valign="top" width="80"><p><u></u><u></u></p></td>
      <td valign="top" width="80"><p><u></u><u></u></p></td>
      <td valign="top" width="80"><p><u></u><u></u></p></td>
    </tr>
     
  </tbody>
</table>