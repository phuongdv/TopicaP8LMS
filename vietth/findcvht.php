<?php
#### Roshan's Ajax dropdown code with php
#### Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
#### if you have any problem contact me at http://roshanbh.com.np
#### fell free to visit my blog http://php-ajax-guru.blogspot.com
?>

<?php $monhoc=$_REQUEST['monhoc'];
$link= mysql_connect('192.168.79.2', 'c5tvuel', 'viet123');
		 mysql_select_db("c5tvuel");
		 mysql_query("SET NAMES utf8");
		$sql="SELECT u.username,u.lastname,u.firstname
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id='211'
        and c.shortname='$monhoc'";

		
$result=mysql_query($sql);

?>
<select name="povhlm" id="povhlm">
<?php while($row=mysql_fetch_array($result)) { ?>

<option   value="<?php echo $row['username'];?>"><?php echo $row['lastname'].' '.$row['firstname'];?></option>
<?php } ?>
</select>

