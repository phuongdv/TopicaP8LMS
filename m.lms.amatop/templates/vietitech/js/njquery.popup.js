function openNewImage(file)
{	 	
	picfile = new Image(); 
	picfile.src =(file);           
	width=picfile.width;
	height=picfile.height;
	
	winDef = 'status=no,resizable=no,scrollbars=no,toolbar=no,location=no,fullscreen=no,titlebar=yes,height='.concat(height).concat(',').concat('width=').concat(width).concat(',');
	winDef = winDef.concat('top=').concat((screen.height - height)/2).concat(',');
	winDef = winDef.concat('left=').concat((screen.width - width)/2);
	newwin = open('', '_blank', winDef);

	newwin.document.writeln('<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">');
	newwin.document.writeln('<a style="cursor:pointer" href="javascript:window.close()"><img src="', file, '" border=0></a>');
	newwin.document.writeln('</body>');
}