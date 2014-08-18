<title>Hou elearning server info</title>

<?php
$conn = mysql_connect('localhost', 'c2test', '123456');
echo 'status:'.mysql_ping($conn).' (1 : connected , 0 : disconnect)<br>';
echo 'list:<br>';
$result = mysql_list_processes($conn);
$t=0;
$q=0;
while ($row = mysql_fetch_assoc($result)){
if($row["Command"]=='Query')
{
	$q=$q+1;
}
  $t=$t+1;   
     echo $row["Id"].' | '.$row["Host"].' | '.$row["db"].' | '.$row["Command"].' | '.$row["Time"].' | '.$row["Info"].'<br>';
}
echo 'total query / connect: '.$q.'/'.$t;
$sql="SHOW SESSION STATUS";
$result=mysql_query($sql);
while ($row=mysql_fetch_assoc($result))
{
switch ($row['Variable_name']) {
	case 'Threads_connected':
		echo '<br>'.$row['Variable_name'].' :'.$row['Value'];
		break;
	
	case 'Threads_running':
		echo '<br>'.$row['Variable_name'].' :'.$row['Value'];
		break;

	default:
		break;
}
}
?>