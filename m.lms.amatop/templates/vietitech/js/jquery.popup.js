/*
 * This is a javascript library that handles calling JPOPUP.
 * Copyright (c) 2009 JPOPUP -- http://www.vietitech.com
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
jQuery.popup = {
	show: function(url, options){
		var defaults = {
				wparamet: '',
				wposition:'center',
				wtoolbar: 'no',
				wdirectories: 'no',
				wstatus: 'no',
				wscrollbars: 'yes',
				wresizable:'no',
				wmenubar: 'no',
				wlocation: 'no',
				wwidth: 800,
				wheight: 600
			};
		
		var options = jQuery.extend(defaults,options);
		var xpos, ypos;
		if(options.wposition=='center') {
			xpos = (screen.width - options.wwidth)/2;
			ypos = (screen.height - options.wheight)/2;
		}
		else if(options.wposition=='right') {
			xpos = screen.width - options.wwidth;
			ypos = screen.height - options.wheight;
		}
		else {
			xpos = 0;
			ypos = 0;
		}
		url = (options.wparamet=='')? url : url + '?' + options.wparamet;
		var nwin = window.open(url,"NVCOM","toolbar="+ options.wtoolbar +",location="+ options.wlocation +",width="+ options.wwidth +",height="+ options.wheight + ",directories="+ options.wdirectories +",status="+ options.wstatus +",scrollbars="+ options.wscrollbars +",resizable="+ options.wresizable +", menubar="+ options.wmenubar);
		nwin.moveTo(xpos,ypos);
		nwin.focus();
		
		return jQuery;
	}
};
