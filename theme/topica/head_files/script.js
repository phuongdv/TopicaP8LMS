/*
$JA#COPYRIGHT$
*/ 

window.addEvent ('domready', function() {
	var sfEls = $$('ul.ja-megamenu li');
	sfEls.each (function(li){
		li.addEvent('mouseenter', function(e) {
			clearTimeout(this.timer);
			jaMegaHoverOutOther (this);
			if(this.className.indexOf(" over") == -1)
				this.className+=" over";
		});
		li.addEvent('mouseleave', function(e) {
			this.timer = setTimeout(jaMegaHoverOut.bind(this, e), 1000);
		});
	});
	function jaMegaHoverOut(e) {
		clearTimeout(this.timer);
		this.className=this.className.replace(new RegExp(" over\\b"), "");
	}
	function jaMegaHoverOutOther(el) {
		sfEls.each (function(li) {
			if (li != el)
				li.className = li.className.replace(new RegExp(
								" over\\b"), "");
				});
	}
});