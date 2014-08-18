<?php
$callback=$_GET['callback'];
$id=$_GET['id'];
 $conn=mysql_connect("localhost", "c2test", "123456");
 mysql_select_db("c2test");
 mysql_query("SET NAMES utf8");
 $sql="select shortname,fullname,id from mdl_course order by rand() limit 0,10 ";
 $data = mysql_query($sql,$conn);
 $posts = array();
 if(mysql_num_rows($data)) {
    while($post = mysql_fetch_assoc($data)) {
      $posts[] = $post;
    }
  }
  print_r($posts);
  //header('Content-type: application/json');
  //  echo $callback.'({data: '.json_encode($posts).'})';
 mysql_close($conn);
?>