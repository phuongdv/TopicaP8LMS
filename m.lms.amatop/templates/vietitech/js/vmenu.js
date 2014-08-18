/*
 * Thanks to some ideas
 * Author  : Vu Quoc Trung (trungvq@vietitech.com)
 * Version : 1.0.0
 * Date    : 24/09/2009
 */
function dropdownMenu() {  
  $('#menu li a').mouseover(
    function() {
      var checkElement = $(this).next();
	  var crrid = checkElement.attr("id");
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
      	return false;
      }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {		
        $('#menu ul:visible').slideUp('normal');
		$('#menu ul:visible').each(function(){ var crindex = $(this).attr("id"); $.cookie(crindex, "collapsed", { path: "/", expires: 365 }); });
        checkElement.slideDown('normal');
		$.cookie(crrid, "expanded", { path: "/", expires: 365 });
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
$(document).ready(function() {dropdownMenu();});

$(document).ready(function() {
	$('a.tnav').hover(function() {
								   	
		alert("aaaaaaaaaaaaaaaaaaaaaaaaaa");							   
	});
});