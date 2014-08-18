//
// CONFIGURATION
// png_overlay is the png 'frame' that will be loaded over the images with a class name of "frame"
// suffix is the identifier for the rollover image; image.jpg -> image_suffix.jpg
//
//	var png_overlay = 'rounded_frame.png';
//	var suffix = '_over';

//
//	addEvent()
//	Allows attachment of events to elements
//
function addEvent( obj, type, fn ) {
	if (obj.addEventListener) {
		obj.addEventListener( type, fn, false );
		EventCache.add(obj, type, fn);
	}
	else if (obj.attachEvent) {
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
		obj.attachEvent( "on"+type, obj[type+fn] );
		EventCache.add(obj, type, fn);
	}
	else {
		obj["on"+type] = obj["e"+type+fn];
	}
}
var EventCache = function(){
	var listEvents = [];
	return {
		listEvents : listEvents,
		add : function(node, sEventName, fHandler){
			listEvents.push(arguments);
		},
		flush : function(){
			var i, item;
			for(i = listEvents.length - 1; i >= 0; i = i - 1){
				item = listEvents[i];
				if(item[0].removeEventListener){
					item[0].removeEventListener(item[1], item[2], item[3]);
				};
				if(item[1].substring(0, 2) != "on"){
					item[1] = "on" + item[1];
				};
				if(item[0].detachEvent){
					item[0].detachEvent(item[1], item[2]);
				};
				item[0][item[1]] = null;
			};
		}
	};
}();

addEvent(window,'unload',EventCache.flush);

//
//	correctPNG()
//	Allows transparent PNG images to be display correctly in IE
//	Not sure who wrote it, but thanks
//
function correctPNG() {
	for(var i=0; i<document.images.length; i++) {
		var img = document.images[i]
		var imgName = img.src.toUpperCase()
		if (imgName.substring(imgName.length-3, imgName.length) == "PNG") {
			var imgID = (img.id) ? "id='" + img.id + "' " : ""
			var imgClass = (img.className) ? "class='" + img.className + "' " : ""
			var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
			var imgStyle = "display:inline-block;" + img.style.cssText 
			if (img.align == "left") imgStyle = "float:left;" + imgStyle
			if (img.align == "right") imgStyle = "float:right;" + imgStyle
			if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle		
			var strNewHTML = "<span " + imgID + imgTitle
			+ " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
			+ "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"			
			+ "(src=\'" + img.src + "\', sizingMethod='image');\""+ imgClass +"></span>" 
			img.outerHTML = strNewHTML
			i = i-1
		}
	}
}

//
//	rollovers()
//	Displays a rollover for any image with a class name of "rollover". Includes IE friendly function for transparent PNG fix.
//
var rollovers = {
	obj : Object,
	init : function() {
		for( var i = 0, over; over = document.getElementsByTagName('img')[i]; i++ ){
			if( over.className.indexOf('rollover') >= 0 ) {
				rollovers.preload(over);
				addEvent(over,'mouseover',rollovers.show);
				addEvent(over,'mouseout',rollovers.hide);
			}
		}
	},
	preload : function(e) {
		var img = new Image;
		var ext = e.src.substring(e.src.length - 4, e.src.length);
		var name = e.src.substring(0, e.src.length - 4);
		img.src = name + suffix + ext;
	},
	show : function(e) {
		var ext = this.src.substring(this.src.length - 4, this.src.length);
		var name = this.src.substring(0, this.src.length - 4);
		this.src = name + suffix + ext;
	},
	hide : function(e) {
		this.src = this.src.replace(suffix,'');
	}
}
var rollovers_ie = {
	obj : Object,
	init : function() {
		if( document.getElementsByTagName('span').length < 1 )
			setTimeout('rollovers_ie.init()',500);
		for( var i = 0, span; span = document.getElementsByTagName('span')[i]; i++ ){
			if( span.className.indexOf('rollover') >= 0 ) {
				rollovers_ie.preload(span);
				addEvent(span,'mouseover',rollovers_ie.show);
				addEvent(span,'mouseout',rollovers_ie.hide);
			}
		}
	},
	preload : function(e) {
		var img = new Image;
		var filter = e.style.filter;
		var src = filter.substring( filter.indexOf("src='") + 5, filter.indexOf("',"));
		var ext = src.substring(src.length - 4, src.length);
		var name = src.substring(0, src.length - 4);
		img.src = name + suffix + ext;
	},
	show : function(e) {
		var filter = this.style.filter;
		var src = filter.substring( filter.indexOf("src='") + 5, filter.indexOf("',"));
		var ext = src.substring(src.length - 4, src.length);
		var name = src.substring(0, src.length - 4);
		this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader" + "(src=\'" + name + suffix + ext + "\', sizingMethod='image')";
	},
	hide : function(e) {
		var filter = this.style.filter;
		var src = filter.substring( filter.indexOf("src='") + 5, filter.indexOf("',"));
		this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader" + "(src=\'" + src.replace(suffix,'') + "\', sizingMethod='image')";
	}
}

//
//	pngFrame()
//	Replaces images with class name of "frame" with png_overlay file.
//
function pngFrame() {
	var imgs = document.images;
	for( var i = 0, img; img = imgs[i]; i++ ) {
		if( img.className.indexOf('frame') >= 0 ) {
			var bgSrc = img.src;
			img.style.background = "url(" + bgSrc + ")";
			img.src = png_overlay;
		}
	}
}

//
// Load the Functions
//
if( navigator.userAgent.indexOf('MSIE') >= 0 )
	addEvent(window,'load',correctPNG);
addEvent(window,'load',pngFrame);
if( navigator.userAgent.indexOf('MSIE') >= 0 )
	addEvent(window,'load',rollovers_ie.init);
addEvent(window,'load',rollovers.init);
