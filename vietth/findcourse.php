
<?php 
ini_set('display_errors','on');
$monhoc=$_REQUEST['monhoc'];
$link= mysql_connect('192.168.79.2', 'c5tvuel', 'viet123');
		 mysql_select_db("c5tvuel");
		 mysql_query("SET NAMES utf8");
		 $sql="select id, shortname from mdl_course 
			where 
			fullname not LIKE '%Diễn đàn%' 
			and fullname not like '%Mẫu%'
			and fullname not like '%h2742%'
			and id !=1
			and fullname like '%".$monhoc."%'
			order by shortname asc";
        $result=mysql_query($sql);
?>
<select name="coursemoodle" id="coursemoodle">
<?php while($row=mysql_fetch_array($result)) { ?>
<option   value="<?php echo $row['shortname'];?>"><?php echo $row['shortname']?></option>
<?php } ?>
</select>