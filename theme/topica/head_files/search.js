function getposOffset(overlay, offsettype)
{
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null)
	{
	totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
	parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function overlayclose(subobj)
{
	document.getElementById(subobj).style.display="none"
}

var addItem = function(items) {
	items.each(function(item) {
		var el = '<option value="'+item.id+'">'+item.name+'</option>';
		el.inject($("search_results"));
	});
	if ($("assign").innerHTML) $("search_results").setStyle('display','block');
};

function showHint(word) 
{ 	
	if(word==""){
		return;
	}else{
		document.getElementById('search_vm').innerHTML = '<div class="smatt"><img src="assets/images/loader_icon.gif" /></div>';
		var url="includes/ajax_search.php?search="+word;
	}

	var request = new Json.Remote(url, {
		onComplete: function(obj) {

			if (obj.items[0].name.indexOf('Not Found') != -1) {
				return;
			} else {
				$("assign").innerHTML = '';
				obj.items.each(function(item) {
					var el = '<option value="'+item.id+'">'+item.name+'</option>';
					$("assign").innerHTML += el;
				});
				document.getElementById('search_vm').innerHTML = '';
			}
		}
	}).send();	
}