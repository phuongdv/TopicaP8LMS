<script type="text/javascript">
function hide_float_right() {
    var content = document.getElementById('float_content_right');
    var hide = document.getElementById('hide_float_right');
    if (content.style.display == "none")
    {content.style.display = "block"; hide.innerHTML = '<a href="javascript:hide_float_right()">Đóng [X]</a>'; }
        else { content.style.display = "none"; hide.innerHTML = '<a href="javascript:hide_float_right()" title="Click để xem chi tiết"><img src="phone.png" width="10" height="15"/>Tổng đài hỗ trợ 19006481</a>';
    }
    }
</script>
<style>
.float-ck { position: fixed; bottom: 0px; z-index: 9000}
* html .float-ck {position:absolute;bottom:auto;top:expression(eval (document.documentElement.scrollTop+document.docum entElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0))) ;}
#float_content_right {border: 1px solid #931919; background: #FFF;}
#hide_float_right {text-align:right; font-size: 14px;}
#hide_float_right a {background: #931919; padding: 2px 4px; color: #FFF;}
</style>
<div class="float-ck" style="right: 0px" >
<div id="hide_float_right">
<a href="javascript:hide_float_right()">Đóng [X]</a></div>
<div id="float_content_right" align="center">
 <img src="hotro_zps3d047ee1.png"  title="Tổng đài hỗ trợ 19006481" /><br>
 <font color="#931919" ><b>
 Tổng đài hỗ trợ giải đáp thắc mắc<br>
 &nbsp;từ 9h đến 21h các ngày trong tuần.<br>( giá cước 1000đ/phút)<br><br>
 </b>
 </font>
</div>
</div>