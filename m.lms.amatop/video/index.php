<meta name="viewport" content="width=device-width, user-scalable=yes">
<head>
<style type="text/css">
*{
padding:0;
margin:0;
}
.classname {
	-moz-box-shadow:inset 0px 1px 0px 0px #caefab;
	-webkit-box-shadow:inset 0px 1px 0px 0px #caefab;
	box-shadow:inset 0px 1px 0px 0px #caefab;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #77d42a), color-stop(1, #5cb811) );
	background:-moz-linear-gradient( center top, #77d42a 5%, #5cb811 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77d42a', endColorstr='#5cb811');
	background-color:#77d42a;
	-webkit-border-top-left-radius:0px;
	-moz-border-radius-topleft:0px;
	border-top-left-radius:0px;
	-webkit-border-top-right-radius:0px;
	-moz-border-radius-topright:0px;
	border-top-right-radius:0px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0;
	border:1px solid #268a16;
	display:inline-block;
	color:#306108;
	font-family:Arial;
	font-size:16px;
	font-weight:bold;
	font-style:normal;
	height:48px;
	line-height:48px;
	width:100px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #aade7c;
}
.classname:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #5cb811), color-stop(1, #77d42a) );
	background:-moz-linear-gradient( center top, #5cb811 5%, #77d42a 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5cb811', endColorstr='#77d42a');
	background-color:#5cb811;
}.classname:active {
	position:relative;
	top:1px;
}
video {
	 max-width: 100%;
	 height: auto;
	}
</style>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />

<script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>
<link href="http://vjs.zencdn.net/4.3/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.3/video.js"></script>
<style type="text/css">
  .vjs-default-skin .vjs-control-bar { font-size: 200% }
</style>

<script>


function play_video(url,order)
{
var myPlayer = videojs('my_video_1');
myPlayer.src({ type: "video/mp4", src: url });
myPlayer.play();
$(".list").find("span").html('');
$('#status_'+order).html('Đang phát');
}
</script>

</head>
<body >

<video id="my_video_1" class="video-js vjs-default-skin vjs-big-play-centered" controls
 preload="auto"   poster="my_video_poster.png"
 data-setup="{}">
 <source src="http://app2.tpe.topica.vn/data/U116/U116_L1_MPC/U116_L1_MPC_1/U116_L1_MPC_1.mp4" type='video/mp4'>
 <source src="my_video.webm" type='video/webm'>
</video>

<div style="width:auto;border-bottom:solid 1px #ccc;height:50px;">

</div>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;height:100px;padding:10px">
<img style="float:left;padding-right:20px;" height="80" src="http://dantri4.vcmedia.vn/vtfPRccccccccccccodZ/Image/2012/12/southampton-5e9a0.jpg">
<h5  onclick="play_video('http://eldata11.topica.edu.vn/HocLieu/v1.0/MAN301/Video_Mobile/MAN301_Bai1_v1.0013112220.mp4',1)">Bài 1: Phân tích abc</h3>
<span id="status_1">Đang phát</span>
</div>
<div class="list" style="width:auto;border-bottom:solid 1px #ccc;height:100px;padding:10px">
<img style="float:left;padding-right:20px;" height="80" src="http://dantri4.vcmedia.vn/vtfPRccccccccccccodZ/Image/2012/12/southampton-5e9a0.jpg">
<h5  onclick="play_video('http://eldata11.topica.edu.vn/HocLieu/v1.0/MAN301/Video_Mobile/MAN301_Bai6_v1.0013112220.mp4',2)">Bài 6: Phân tích abc</h3>
<span id="status_2"></span>
</div>



</div>
<div align="center" style="padding:20px"><a href="#" class="classname">Quay lại </a></div>
<script>
// Once the video is ready
   videojs("my_video_1").ready(function(){
  var myPlayer = this;
  var width = $(window).width();
  var height = (width/16)*9;
  myPlayer.width(width).height(height);
  myPlayer.src({ type: "video/mp4", src: 'http://eldata11.topica.edu.vn/HocLieu/v1.0/MAN301/Video_Mobile/MAN301_Bai1_v1.0013112220.mp4' });
  // EXAMPLE: Start playing the video.
  myPlayer.play();

});

</script>
</body>
