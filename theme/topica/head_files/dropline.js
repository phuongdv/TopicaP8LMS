/*
#------------------------------------------------------------------------
  JA Purity II for Joomla 1.5
#------------------------------------------------------------------------
#Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
#@license - GNU/GPL, http://www.gnu.org/copyleft/gpl.html
#Author: J.O.O.M Solutions Co., Ltd
#Websites: http://www.joomlart.com - http://www.joomlancers.com
#------------------------------------------------------------------------
*/


var jasdl_delay = 1000
var jasdl_current = null
var jasdl_recover = null
var jasdl_timeoutid = null
var jasdl_timetorecover = null
var jasdl_timeoutid2 = 0
var pos_hover = 0;
var log2 = null;

function jasdl_initJAScriptDLMenu() {
	jasdl_current = jasdl_activemenu[0]
	log2 = document.getElementById("ja-login")
	mainlis = document.getElementById("jasdl-mainnav").getElementsByTagName("li")
	for (i=0; i<mainlis.length; ++i) {
		x = mainlis[i]
		jasdl_menuindex = x.id.substr(13)

		x._id = parseInt(jasdl_menuindex)
		x.onmouseover = jasdl_mouseOver
		
		x.onmouseout = jasdl_mouseOut;
			

		subx = document.getElementById("jasdl-subnav"+jasdl_menuindex)
		if (subx)
		{
			if (jasdl_activemenu[0] && jasdl_menuindex == jasdl_activemenu[0]) {
				subx.style.display = "block"
				subx.className = 'active';			
				
				subx = document.getElementById("jasdl-subnav"+ jasdl_menuindex)
				if (subx != null) {					
					moveSubDiv(subx , jasdl_menuindex);
				}	
				
			}else{
				subx.style.display = "none"
			}
			subx._id = jasdl_menuindex


			subx.onmouseover = jasdl_mouseOver

			subx.onmouseout = jasdl_mouseOut
		}
		
		document.getElementById("jasdl-subnav").style.display = "block";

	}

	//Set active item
	if (jasdl_activemenu[0])
	{
		
		actitem = document.getElementById("jasdl-mainnav"+jasdl_activemenu[0].toString())
		if (actitem)
		{
			if (actitem.className) actitem.className += " active"; else actitem.className = "active";
		}	
		jasdl_recover = jasdl_activemenu[0]
	}
	if (jasdl_activemenu[1]) {
		
		actitem = document.getElementById("jasdl-subnavitem"+jasdl_activemenu[1].toString())
		if (actitem)
		{
			if (actitem.className) actitem.className += " active"; else actitem.className = "active";
		}	
	}

	//Hover on sub item
	var subnav = document.getElementById ('jasdl-subnav');
	if (subnav) {
		var sublis = subnav.getElementsByTagName("li");
		for (i=0; i<sublis.length; ++i) {
			objs = sublis[i];
			var child = objs.getElementsByTagName ('ul');
			if (child && child.length) {
				objs.className += " hasChild";
				objs.onmouseover=function() {
					this.className+=" hover";
					//var log2 = document.getElementById("ja-login");
					//log2.innerHTML = pos_hover;
				}
				objs.onmouseout=function() {
					//this.className=this.className.replace(new RegExp("hover\\b"), "");
					this.timer = setTimeout(jasdl_sub_mouseOut.bind(this), 100);
				}
			}
		}
	}
}

function jasdl_sub_mouseOut () {
	this.className=this.className.replace(new RegExp("hover\\b"), "");
}

function jasdl_mouseOver () {	
	jasdl_hide()	
	jasdl_current = this._id
	jasdl_show()
	jasdl_clearTimeOut(jasdl_timeoutid)
}
function jasdl_mouseOut () {
	if (this._id != jasdl_current) return

	jasdl_timeoutid = setTimeout('jasdl_restore()', jasdl_delay)
}

function jasdl_restore () {
	jasdl_clearTimeOut(jasdl_timeoutid)
	jasdl_hide()
	if (jasdl_recover)
	{
		jasdl_current = jasdl_recover
		jasdl_show()
	}
}

function jasdl_setHover () {
	if (jasdl_current == jasdl_recover) return
	mainx = document.getElementById("jasdl-mainnav"+jasdl_current.toString())
	
	
	if (mainx)
		mainx.className += ' hover';		
	
	/*var elem;
	if(document.getElementById) {
		var elem = document.getElementById("jasdl-mainnav"+jasdl_current.toString());
	} else if (document.all){
		var elem = document.all["jasdl-mainnav"+jasdl_current.toString()];
	}
	xPos = elem.offsetLeft;
	tempEl = elem.offsetParent;
	while (tempEl != null) {
		xPos += tempEl.offsetLeft;
		tempEl = tempEl.offsetParent;
	}
	pos_hover = xPos;	*/
	
	restoreActive();
}

function jasdl_clearHover () {
	
	if (jasdl_current == jasdl_recover) return
	mainx = document.getElementById("jasdl-mainnav"+jasdl_current.toString())
	if (mainx)
		mainx.className = mainx.className.replace(/[ ]?hover/, '');
	
	removeActive();
	
}

function jasdl_hide () {
	subx = document.getElementById("jasdl-subnav"+jasdl_current.toString())
	if (subx) {
		subx.style.display = "none"			
		//var log2 = document.getElementById("ja-login");
		
		//if (subx.style.marginRight != null)
		//{
			//var jasearch = document.getElementById("ja-search");
			//jasearch.style.display = "block";
		//}
		//restoreSearch();
	}
	jasdl_clearHover ()
}

function jasdl_show () {
	subx = document.getElementById("jasdl-subnav"+jasdl_current.toString())
	
	//var log2 = document.getElementById("ja-login");
	//log2.innerHTML = pos_hover;
	var mainx = document.getElementById("jasdl-mainnav"+jasdl_current.toString())	
	if (subx != null && subx.className.indexOf("active") != 1 && subx.className.indexOf("hover") != 1) {
		//log2.innerHTML = pos_hover;
		moveSubDiv(subx , jasdl_current);		
	}
	
	
	if (subx) {
		subx.style.display = "block"
	}
	jasdl_setHover ()
}

function jasdl_clearTimeOut(timeoutid){
	clearTimeout(timeoutid)
	timeoutid = 0
}

function moveRight(subx, pos_hover) {	
	
	if (pos_hover <= 0) {
		return;	
	}
	if (pos_hover > 500 && pos_hover < 600) {
		pos_hover = 250;
	}
	
	if (pos_hover > 600 && pos_hover < 700) {
		pos_hover = 200;
	}

	if (pos_hover > 700 && pos_hover < 800) {
		pos_hover = 150;
	}
	
	if (pos_hover > 800 && pos_hover < 900) {
		pos_hover = 100;
	}
	

	if (pos_hover > 900) {
		pos_hover = 0;
	}	
	
	var subnav = document.getElementById("jasdl-subnav");	
	subnav.setStyle("float", "right");
	
	/*var jasearch = document.getElementById("ja-search");
	jasearch.style.display = "none";*/
	
	subx.style.removeProperty('margin-left');
	subx.setStyle("float", "right");
	subx.style.marginRight = pos_hover + "px";
}


function moveLeft(subx, pos_hover) {
	
	if (pos_hover < 0 || pos_hover < 100) {
		pos_hover = 0;
	}
	
	if (pos_hover > 100 && pos_hover < 200) {
		pos_hover = 0;
	}

	if (pos_hover > 200 && pos_hover < 300) {
		pos_hover = 100;
	}		
	
	if (pos_hover > 300 && pos_hover < 400) {
		pos_hover = 150;
	}
	
	if (pos_hover > 400 && pos_hover < 500) {
		pos_hover = 200;
	}
	
			
	var subnav = document.getElementById("jasdl-subnav");	
	subnav.setStyle("float", "left");
	
	var jasearch = document.getElementById("ja-search");
	jasearch.style.display = "block";
	
	subx.style.removeProperty('margin-right');
	subx.style.marginLeft = pos_hover + "px";
	subx.setStyle("float", "left");
	
	//subx.style.removeProperty('margin-right');
}


function moveSubDiv(subx , currentID) {
	//subx.style.removeProperty('margin-right');
	

	if (currentID == 396)
	{
		pos_hover = 400;			
		
	}

	if (currentID == 414)
	{
		pos_hover = 50;		
	}
	
	if (currentID == 410)
	{
		pos_hover = 170;		
	}
	
	if (currentID == 400)
	{
		pos_hover = 380;		
	}

	if (currentID == 391)
	{
		pos_hover = 220;		
	}
	if (currentID == 396)
	{
		pos_hover = 250;		
	}
	if (currentID == 371 || currentID == 457 || currentID == 419)
	{
		pos_hover = 0;		
	}


	subx.style.marginLeft = pos_hover + "px";
	/*switch(currentID) {
		case 457:
			pos_hover = 0;
			subx.style.marginLeft = pos_hover + "px";
			break;
		case 419:
			pos_hover = 0;
			subx.style.marginLeft = pos_hover + "px";
			break;
		case 414:
			pos_hover = 50;
			subx.style.marginLeft = pos_hover + "px";
			break;
		case 410:
			pos_hover = 170;
			subx.style.marginLeft = pos_hover + "px";
			break;
		case 400:
			pos_hover = 380;
			alert(pos_hover);
			subx.style.marginLeft = pos_hover + "px";
			break;
		case 396:
			
			break;
		case 391:
			pos_hover = 320;
			subx.style.marginLeft = pos_hover + "px";
			break;			
		default:
			pos_hover = 0;
			subx.style.marginLeft = pos_hover + "px";
			break;
	}*/
	

	
	//subx.setStyle("float", "left");
}


function restoreActive() {
	//Hover on sub item
	mainlis = document.getElementById("jasdl-mainnav").getElementsByTagName("li")
	for (i=0; i < mainlis.length; ++i) {
		x = mainlis[i];		
		if (x.className.indexOf('active') != -1) {
			x.className =  x.className  + " removeActive";			
		}
	}
	
}

function removeActive() {
	//Hover on sub item
	mainlis = document.getElementById("jasdl-mainnav").getElementsByTagName("li")
	for (i=0; i < mainlis.length; ++i) {
		x = mainlis[i];		
		if (x.className.indexOf('active') != -1) {
			x.className =  x.className.replace(/[ ]?removeActive/, '');
		}
	}
	
}

function restoreSearch() {
	var jasearch = document.getElementById("ja-search");

	if (pos_hover != 0 && pos_hover > 500) {	
			var subnav = document.getElementById("jasdl-subnav");	
			subnav.setStyle("float", "left");
			jasearch.style.display = "block";				
	}
	
	//var log2 = document.getElementById("ja-login");

	//log2.innerHTML = pos_hover;

	
	
}

jaAddEvent(window, 'load', jasdl_initJAScriptDLMenu)
