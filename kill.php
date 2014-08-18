<?php  /// Moodle Configuration File

$conn = mysql_connect('localhost', 'lms-vietth', 'c03cu@s01cu@di');
$id=$_GET['id'];
if($id!='')
 {
 $result=mysql_query('kill $id');
 die($id.' killed');
 }

$sql="SHOW SESSION STATUS";
if(!mysql_ping($conn))
 {
include('error.php');
		die();
 
 }
$result=mysql_query($sql);
while ($row=mysql_fetch_assoc($result))
{
if($row['Variable_name']=='Threads_running') 
     {
	 // auto kill 
	 $process_id=$row["Id"];
	 if ($row["Time"] > 20) {
	 $sql="KILL $process_id";
	 mysql_query($sql);
        }
	    if(intval($row['Value'])>200  )
		 {
		 
		  die('max connection');
		 }
		
    }
}
?>