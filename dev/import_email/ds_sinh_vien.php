<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<?php
echo "<table width='70%' border='1' cellpadding='3' cellspacing='0' align='center' bordercolor='#810C15'>";
	echo "<tr >";
	echo "<th bgcolor='#810C15'><span class='style1'>STT</span></th>";
	echo "<th bgcolor='#810C15'><span class='style1'>Họ và tên</span></th>";
	echo "<th bgcolor='#810C15'><span class='style1'>Vai trò</span></th>";
	echo "<th bgcolor='#810C15'><span class='style1'>Email Topica</span></th>";
	echo "<th bgcolor='#810C15'><span class='style1'>Email cá nhân</strong></th>";
	echo "<th bgcolor='#810C15'><span class='style1'>Kiểm tra</strong></th>";
	echo "<th bgcolor='#810C15'><span class='style1'>Ghi chú kiểm tra</span></th>";
	echo "</tr>";
	
		$stt=0;
		$sql = " SELECT * FROM tmp_import_email_canhan ";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 0 )
		{
		echo " Chưa có dữ liệu";
		}
	else
	{
	while ($row = mysql_fetch_array($result))
		{
			$stt++;
			echo "<tr>";
			echo "<td>".$stt."</td>";
			echo "<td>".$row['ho_ten']."</td>";
			echo "<td>".$row['vai_tro']."</td>";
			echo "<td>".$row['email']."</td>";
			echo "<td>".$row['email_canhan']."</td>";
			echo "<td align='center'>".$row['ket_qua_kiem_tra_yn']."</td>";
			echo "<td>".$row['ghi_chu_kiem_tra']."</td>";
			echo "</tr>";
		}
	}
echo "</table>";
?>
