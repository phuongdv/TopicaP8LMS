/*
 * Thanks to some ideas
 * Author  : Vu Quoc Trung (trungvq@vietitech.com)
 * Version : 1.0.0
 * Date    : 24/09/2009
 */
function dropdownMenu() {  
  $('#menu li a').click(
    function() {
	  var clink = $(this).attr("href");	
      var checkElement = $(this).next();
	  var crrid = checkElement.attr("id");
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
      	return false;
      }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {		
        $('#menu ul:visible').slideUp('normal');
		$('#menu ul:visible').each(function(){ var crindex = $(this).attr("id"); $.cookie(crindex, "collapsed", { path: "/", expires: 365 }); });
        /*checkElement.slideDown('normal');*/
		$.cookie(crrid, "expanded", { path: "/", expires: 365 });
		window.location.href = clink;
        return false;
        }
      }
    );
  $('#menu ul').each(function(){ 
	var crridex = $(this).attr("id");
	if($.cookie(crridex) == "expanded")
		{
			$('#'+crridex).slideDown("normal");
		}
	else {
		$('#'+crridex).hide();
	}						  
  });
}
$(document).ready(function() {
	dropdownMenu();
	var obj = null;
	function checkHover() {
		if (obj) {
			obj.find('div').fadeOut('fast');	
		} 
	}
	$('#menu li ul li').hover(function() {
		if (obj) {
			obj.find('div').fadeOut('fast');
			obj = null;
		} 
		
		$(this).find('div').fadeIn('fast');				   
	},function(){
		obj = $(this);
		var crdid = $(this).attr('id');
		$('div#d'+crdid).css("display","none");			
	});
	$('div.tmenu').hover(function() {			   
	},function(){
		$(this).css("display","none");			
	});
});