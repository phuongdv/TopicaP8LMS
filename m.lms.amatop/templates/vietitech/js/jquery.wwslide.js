var theInt = null;
var crobj = null;
var $navthumb;
var curclicked = 0;
var slide_interval = 3000;

function processEvent(obj) {
	//Set Variables
	var imgAlt = obj.find('img').attr("alt"); //Get Alt Tag of Image
	var imgTitle = obj.find('a').attr("href"); //Get Main Image URL
	var imgDesc = obj.find('.block').html(); 	//Get HTML of block
	var imgDescHeight = $(".main_image").find('.block').height();	//Calculate height of block	
	
	if (obj.is(".active")) {  //If it's already active, then...
		return false; // Don't click through
	} else {
		//Animate the Teaser				
		$(".main_image .block").animate({ opacity: 0, marginBottom: -imgDescHeight }, 250 , function() {
			$(".main_image .block").html(imgDesc).animate({ opacity: 0.85,	marginBottom: "0" }, 250 );
			$(".main_image img").attr({ src: imgTitle , alt: imgAlt});
		});
	}
	
	$(".image_thumb ul li").removeClass('active'); //Remove class of 'active' on all lists
	obj.addClass('active');  //add class of 'active' on this list only
	return false;
}

$(document).ready(function() {
	//Auto play
	$navthumb = $(".image_thumb ul li");	
	$navthumb.click(function() {
		var $this = $(this);
		processEvent($this);
		clearInterval(theInt);
		return false;
	});
	$navthumb.hover(function(){
		$(this).addClass('hover');
		}, function() {
		$(this).removeClass('hover');
	});
					   	
	//Show Banner
	$(".main_image .desc").show(); //Show Banner
	$(".main_image .block").animate({ opacity: 0.8 }, 1 ); //Set Opacity
	
	//Toggle Teaser
	$("a.collapse").click(function(){
		$(".main_image .block").slideToggle();
		$("a.collapse").toggleClass("show");
	});
	
	theInt = setInterval(function(){
		$navthumb.each(function() {								
			if(curclicked==$navthumb.index(this))
				crobj = $(this);
		});							  
		processEvent(crobj);	
		curclicked++;
		if( 4 == curclicked )
			curclicked = 0;
		
	}, slide_interval);
});
