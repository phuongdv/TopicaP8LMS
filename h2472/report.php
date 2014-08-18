<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>








<?php

include('../config.php');



include('includes/config.inc.php');



include($dir_inc.'template.php');



include($dir_inc.'function.php');



include($dir_inc.'functions.php');


global $db;

echo '
 <form name="form1" method="post" action="">
<table width="699" border="0">
  <tr>
    <td width="305">Start date: 
     
        <label>
          <input name="s_ngay" type="text" id="s_ngay" value="'.$_POST['s_ngay'].'" size="2" maxlength="2">
        </label>
        <label>
        <input name="s_thang" type="text" id="s_thang" value="'.$_POST['s_thang'].'" size="2" maxlength="2">
         </label>
          <label>
        <input name="s_nam" type="text" id="s_nam" value="'.$_POST['s_nam'].'" size="4" maxlength="4">
        </label>
     </td>
    <td width="305">End date:
      <label>
      <input name="e_ngay" type="text" id="e_ngay" value="'.$_POST['e_ngay'].'" size="4" maxlength="2" >
      </label>
       <label>
      <input name="e_thang" type="text" id="e_thang" value="'.$_POST['e_thang'].'" size="4" maxlength="2" >
       </label>
       <label>
      <input name="e_nam" type="text" id="e_nam" value="'.$_POST['e_nam'].'" size="8" maxlength="4">
      </label></td>
    <td width="67"><label>
      <input type="submit" name="button" id="button" value="Lọc">
    </label></td>
  </tr>
</table>
 </form>






<table width="80%" border="1">
<tr>
    <td>Ngày</td>
    <td>Thứ</td>
    <td>0-8</td>
    <td>8-16</td>
    <td>16-24</td>
    <td>tong</td>
  </tr>

';
if($_POST['s_ngay']=='' || $_POST['s_ngay']=='dd' || $_POST['s_thang']=='' || $_POST['s_thang']=='mm' || $_POST['s_nam']==''|| $_POST['s_nam']=='yyyy')
{
$x=1277053200;
}
else
{
$x=mktime(0,0,0,$_POST['s_thang'],$_POST['s_ngay'],$_POST['s_nam'])	;
		if($x<1277053200)
		{
			$x=1277053200;
		}
}

if($_POST['e_ngay']=='' ||  $_POST['e_thang']=='' || $_POST['e_nam']=='')
{
$y=time();
}
else
{
$y=mktime(0,0,0,$_POST['e_thang'],$_POST['e_ngay'],$_POST['e_nam'])	;
		if($y>time())
		{
			$y=time();
		}
}





$i=0;

$j=time();
$tongngay=0;
$tong=0;
$tong08=0;
$tong816=0;
$tong1624=0;
for($i=$x;$i<=$y;$i=$i+(60*60*24))


{
$a=$i+(60*60*8);
$b=$a+(60*60*8);
$c=$b+(60*60*8);
$sql="select count(*) count0_8  from tblthread where time between ".$i." and ".$a;
$sql1="select count(*) count8_16 from tblthread where time between ".$a." and ".$b;
$sql2="select count(*) count16_24 from tblthread where time between ".$b." and ".$c;


$result=$db->sql_query($sql);
$result1=$db->sql_query($sql1);
$result2=$db->sql_query($sql2);
$topic=$db->sql_fetchrow($result);
$topic1=$db->sql_fetchrow($result1);
$topic2=$db->sql_fetchrow($result2);
$tongngay=intval($topic['count0_8'])+ intval($topic1['count8_16'])+intval($topic2['count16_24']);
$tong=$tong+$tongngay;	
$tong08=$tong08+intval($topic['count0_8']);	
$tong816=$tong816+intval($topic1['count8_16']);
$tong1624=$tong1624+intval($topic2['count16_24']);						
echo '<tr>
    <td>'.date('d/m/Y ',$i).'</td>
     <td>'.date('l',$i).'</td>
    <td>'.$topic['count0_8'].'</td>
    <td>'.$topic1['count8_16'].'</td>
    <td>'.$topic2['count16_24'].'</td>
    <td>'.$tongngay.'</td>
    </tr>';


}

echo '<tr>
    <td><strong>Total</strong></td>
     <td>&nbsp;</td>
    <td><strong>'.$tong08.'</strong></td>
    <td><strong>'.$tong816.'</strong></td>
    <td><strong>'.$tong1624.'</strong></td>
    <td><strong>'.$tong.'</strong></td>
    </tr>';




echo '</table>';


?>