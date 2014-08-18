/*
 * This is a javascript library that handles calling JTOOLTIP.
 * Copyright (c) 2008 JTOOLTIP -- http://www.vietitech.com
 * AUTHORS:
 *   Vu Quoc Trung (trungvq@vietitech.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
this.screenshotPreview = function(){	
	xOffset = 10;
	yOffset = 10;
	var ww = $(window).width();
	var wh = $(window).height();
	var xcoor;
	var ycoor;
	var bycoor;
	$("a.screenshot").hover(function(e){
		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$("body").append("<p id='screenshot'><img src='"+ this.rel +"' alt='Đang tải ảnh về ...' /></p>");								 		var objw = $('#screenshot').width();
		var objh = $('#screenshot').height();
		xcoor = objw + e.pageX;
		ycoor = e.pageY - xOffset;
		
		xoff = (xcoor>ww)? (e.pageX - objw - yOffset) : (e.pageX + yOffset);
		yoff = (ycoor>objh)? ycoor : (e.pageY - objh - xOffset);
		
		$("#screenshot")
			.css("top",yoff + "px")
			.css("left",xoff + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		$("#screenshot").remove();
    });	
	$("a.screenshot").mousemove(function(e){
		var objw = $('#screenshot').width();
		var objw = $('#screenshot').width();
		var objh = $('#screenshot').height();
		xcoor = objw + e.pageX;
		ycoor = e.pageY - xOffset;
		
		xoff = (xcoor>ww)? (e.pageX - objw - yOffset) : (e.pageX + yOffset);
		yoff = (ycoor>objh)? ycoor : (e.pageY - objh - xOffset);
		
		$("#screenshot")
			.css("top",yoff + "px")
			.css("left",xoff + "px");
	});			
};


// starting the script on page load
$(document).ready(function(){
	screenshotPreview();
});