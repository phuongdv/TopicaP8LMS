
<style>
	.grid {
	border-collapse:collapse;
	}
	
	.grid th{
	background:#810c15;
	color:#fff;
	}
	.odd{
	background:#E8F1FF;
	}
	a
	{
	color:#810c15;
	text-decoration:none;
	}
	.grid tr:hover{
background-color:#eee;
}
	
	</style>
<?php
echo "<table width='70%' border='1' cellpadding='3' cellspacing='0' align='center' class='grid'>";
	echo "<tr bgcolor='#810c15'>";
	echo "<th>STT</th>";
	echo "<th>Username</th>";
	echo "<th>Tên sinh viên</th>";
	echo "<th>Số buổi offline</th>";
	//echo "<th>Điểm BTN</th>";
	echo "<th>Course</th>";
	echo "<th>Ghi chú</th>";
	echo "<th>Kiểm tra username</th>";
	echo "<th>Ghi chú kiểm tra</th>";
	echo "</tr>";
	
		$stt=0;
		$sql = " SELECT * FROM tmp_import_offline ";
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
			$stle="";
			if($stt%2==0)
			$stle=" class = 'odd' ";
			echo "<tr ".$stle.">";
		//	echo "<tr>";
			echo "<td align='center'>".$stt."</td>";
			echo "<td>".$row['username']."</td>";
			echo "<td>".$row['ho_ten']."</td>";
			echo "<td align='right'>".$row['number_offline']."</td>";
			//echo "<td align='right'>".$row['btn']."</td>";
			echo "<td>".$row['course']."</td>";
			echo "<td>".$row['ghi_chu']."</td>";
			echo "<td align='center'>".$row['ket_qua_kiem_tra_yn']."</td>";
			echo "<td>".$row['ghi_chu_kiem_tra']."</td>";
			echo "</tr>";
		}
	}
echo "</table>";
?>
