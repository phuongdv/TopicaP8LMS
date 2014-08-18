<?
#### Roshan's Ajax dropdown code with php
#### Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
#### if you have any problem contact me at http://roshanbh.com.np
#### fell free to visit my blog http://php-ajax-guru.blogspot.com
?>

<? $monhoc=$_REQUEST['monhoc'];
$link= mysql_connect('localhost', 'c2test', '123456');


		 mysql_select_db("c2test");
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
<? while($row=mysql_fetch_array($result)) { ?>
<option  value="<?php echo $row['shortname'];?>"><?php echo $row['shortname']?></option>
<? } ?>
</select>