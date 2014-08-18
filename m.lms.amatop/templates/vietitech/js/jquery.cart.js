/*
 * This is a javascript library that handles calling JCART.
 * Copyright (c) 2008 JCART -- http://www.vietitech.com
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
$(function() {
	var _fspeed      = 1200;	
		
	var _your_cart_x = false;
	var _your_cart_y = false;
		
	var _current_x   = false;
	var _current_y   = false;

	function _getAbsoluteTop(objID) {		
		var _obj = $("#"+objID);
		var _top = _obj.offset().top;
		
		return _top;
	}
	
	function _getAbsoluteLeft(objID) {
		var _obj = $("#"+objID);
		var _left = _obj.offset().left;
				
		return _left;
	}
	
	function _addToYourCart(product_id) {
		var _current_cpcontent = $('#slide_item' + product_id).clone(true);
		var _fdiv = false;
		
		if(!_fdiv) {
				$("body").append("<div id='_fdiv' style='position:absolute'></div>");
				_fdiv = $('#_fdiv');
		}
		_your_cart_x = _getAbsoluteLeft('shopping_cart'); 
		_your_cart_y = _getAbsoluteTop('shopping_cart');
		
		_current_x = _getAbsoluteLeft('slide_item' + product_id);
		_current_y = _getAbsoluteTop('slide_item' + product_id);
				
		_fdiv.append(_current_cpcontent).css({left:_current_x + 'px', top:_current_y + 'px'}).animate({opacity: "0.4", left: _your_cart_x + 'px',top: _your_cart_y + 'px'}, _fspeed, "linear", function(){$(this).fadeOut("slow");$(this).remove();_showCart(product_id);});
	}
	
	function _showCart(product_id) {
		$('#shopping_cart').html("").addClass("cls_loading");
		$.ajax({
			   type: "GET",
			   url: root_path + "/addcart.php",
			   data: "product_id=" + product_id,
			   success: function(html){
				 $('#shopping_cart').removeClass("cls_loading").slideDown("slow",function(){$(this).html(html)});			 
			   }
		 });
	}
	
	$("a.add_to_cart").click(function(){
		var _tab_index = $(this).attr("tabindex");
		_addToYourCart(_tab_index);
	});
	_showCart(0);
});

