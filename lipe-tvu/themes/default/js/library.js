function ShowContent(sContent) {
	var i, s, e;
	
		e=document.all[sContent];
		s=e.style.display;
		
		if (s=='none') {
			e.style.display='';
		} else {
			e.style.display='none';
		}
		
}

function openImage(sLink, vHeight, vWidth)
{
	winDef = 'status=no,resizable=no,scrollbars=no,toolbar=no,location=no,fullscreen=no,titlebar=yes,height='.concat(vHeight).concat(',').concat('width=').concat(vWidth).concat(',');
	winDef = winDef.concat('top=').concat((screen.height - vHeight)/2).concat(',');
	winDef = winDef.concat('left=').concat((screen.width - vWidth)/2);
	newwin = window.open('', 'image', winDef);
	
	newwin.document.writeln('<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">');
	newwin.document.writeln('<a href="" onClick="window.close(); return false;"><img src="', sLink, '" alt="', 'Dong lai', '" border=0></a>');
	newwin.document.writeln('</body>');

	return false;
}