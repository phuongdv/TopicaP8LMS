function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
   window.open(delUrl,'_blank','left=0,width=10,height=10,top=0,resizable=no,scrollbars=no,fullscreen');
	
  }
}
function multidelete()
{

if (confirm("Are you sure you want to delete")) {
var c_value="";
    for(i=0;i<document.getElementsByName('checkbox').length;i++)
    {
     if(document.getElementsByName('checkbox')[i].checked)
     {
      c_value+=(c_value?',':'')+document.getElementsByName('checkbox')[i].value;
     }
    }
	if(c_value=="")
	 {
	 alert("Please chose least one !");
	 return;
	 }
	document.getElementById('chk').value=c_value;
	}
	
}