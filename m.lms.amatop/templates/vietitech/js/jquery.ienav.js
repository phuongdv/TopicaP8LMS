$(document).ready(function(){
  $("#navmenu-v li").hover(
    function() { $(this).addClass("iehover"); },
    function() { $(this).removeClass("iehover"); }
  );
});
