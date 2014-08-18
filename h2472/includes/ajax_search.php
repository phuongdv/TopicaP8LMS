<?php
session_start();
include('../includes/config.inc.php');

$searchword = addslashes(trim($_GET['search']));

if($searchword){
/**Get Itemid***/
$sql="SELECT u.*, g.name as gname FROM mdl_user as u, tblgroup as g, tbleuser_group as ug  WHERE ug.user_id = u.id AND ug.group_id = g.id AND g.id NOT IN (1,2,3,8) AND (firstname LIKE '%" . $searchword . "%' OR lastname LIKE '%" . $searchword . "%') ";
$sql_resultes = $db->sql_query($sql) or die(mysql_error());
while ( $resultes_rows = $db->sql_fetchrow($sql_resultes)) {
	$final[] = $resultes_rows;
}
$check = count($final);

?>
{
<?php if($check > 0) {?>
"items":[
	<?php
	$n=0;
	for($i=0;$i<$check;$i++){
		$n++;
	?>
		<?php if($check==$n) {?>
		{"id":"<?php echo $final[$i]['id']; ?>", "name":"<?php echo $final[$i]['gname'].' - '.$final[$i]['firstname'].' '.$final[$i]['lastname']; ?>"}
		<?php }else{ ?>
		{"id":"<?php echo $final[$i]['id']; ?>", "name":"<?php echo $final[$i]['gname'].' - '.$final[$i]['firstname'].' '.$final[$i]['lastname']; ?>"},
		<?php } ?>
	<?php } ?>
	]
<?php } else { ?>
"items":[{"name":"Not Found"}]
<?php } ?> 
}
<?php } ?> 