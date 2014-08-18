<?php 
include('../config.php');
$username=$_REQUEST['username'];
$link= mysql_connect($CFG->dbhost, $CFG->dbuser ,$CFG->dbpass );
		 mysql_select_db($CFG->dbname);
		 mysql_query("SET NAMES utf8");
		 $sql="select * from vietth_masv";
			
        $result=mysql_query($sql);
		$count_ok=0;
		$count_not_ok = 0;
		while($row = mysql_fetch_array($result))
		{

			$sql_update = "update mdl_user
						set topica_msv = '".$row["masv"]."' where username = '".$row["username"]."'";
			$result_update = mysql_query($sql_update);
			if($result_update){ 
				echo $sql_update." ---> Update OK <br/>";
				$count_ok+=1;
			}
			else {
				echo $sql_update." ---> Update not OK <br/>";
				$count_not_ok+=1;
			}
		} 
		
		mysql_close($link);
		$count = $count_ok + $count_not_ok;	
        echo 'Import thanh cong '.$count_ok.'/'.$count.' tong so ban ghi';
?>
