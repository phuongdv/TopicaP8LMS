<?php
set_time_limit(0); 
$conn = mysql_connect('localhost', 'c2test', '123456');
$query ="use c2test";
$data = mysql_query($query);
$query = "SHOW TABLE STATUS";
$data = mysql_query($query) or die(mysql_error()); 
 while($info = mysql_fetch_array( $data ))
 {
 	echo $info['Name'] ." | ".$info['Data_free']; 
 	if(intval($info['Data_free'])>0)
 	{

        $query_otm = "OPTIMIZE TABLE ".$info['Name'];
 		$otm = mysql_query($query_otm);
 		echo "  optimized successfull <br>";
 	}
 	else
 	{
 		echo "<br>";
 	}
 	
 } 
?>