<?php

require_once("global.php");
require_once("www/root/core.php");
$clsMdlCourse = new MdlCourse();
	//$link = $_REQUEST['url'];
$c_id = isset($_GET["id"])? $_GET["id"] : "";
$weekid = isset($_GET["week"])? $_GET["week"] : "";
$OneCourse = $clsMdlCourse->getOne($c_id);
$NameCourse = $OneCourse['fullname'];
preg_match("/^(.*?)\./",$NameCourse,$arr);
$NameCourseS=$arr[1];
$table_name='course_'.strtolower($NameCourseS);
$sql_video = "select * from $table_name where `id` = $weekid ";
$arrListVideo = $dbconn->getAll($sql_video);

?>











<head>




</head>
<body  >

<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_1'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_1'];?>">
<h5 >Phần 1</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>



<?php 
if($arrListVideo[0]['video_2']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_2'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_2'];?>">
<h5 >Phần 2</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_3']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_3'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_3'];?>">
<h5 >Phần 3</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_4']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_4'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_4'];?>">
<h5 >Phần 4</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_5']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_5'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_5'];?>">
<h5 >Phần 5</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_6']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_6'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_6'];?>">
<h5 >Phần 6</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_7']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_7'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_7'];?>">
<h5 >Phần 7</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_8']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_8'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_8'];?>">
<h5 >Phần 8</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_9']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_9'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_9'];?>">
<h5 >Phần 9</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<?php 
if($arrListVideo[0]['video_10']!='')
{
?>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;padding:10px">
<a href="<?php echo $arrListVideo[0]['video_1'];?>">
<img style="float:left;padding-right:20px;" width="100" src="http://m.tvu.topica.vn/templates/vietitech/images/video-logo.jpg">
</a>
<a href="<?php echo $arrListVideo[0]['video_1'];?>">
<h5 >Phần 1</h3>
</a>
<span id="status_1"></span>
<div style="clear:both"></div>
</div>
<?php } ?>
</div>
<script>
/*
   videojs("my_video_1").ready(function(){
  var myPlayer = this;
  var width = $(window).width();
  var height = (width/16)*9;
  myPlayer.width(width).height(height);
 
  // EXAMPLE: Start playing the video.
  myPlayer.play();
*/
});

</script>
</body>
