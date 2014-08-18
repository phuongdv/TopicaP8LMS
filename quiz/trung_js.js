var number_time = 0;
var check_time = true;
var time_conn =0;
var is_submit=false;
function genCode(id)
{
	var xmlhttp;
	xmlhttp =createXmlhttp();
	number_time =  document.getElementById("time").innerHTML;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("task").innerHTML= xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","genCode.php?id="+id,true);
	xmlhttp.send();
	TimeCountdown();
	checkOnline();
}
function getreasons(questid,flag)
{
	var xmlhttp;
	xmlhttp =createXmlhttp();
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var str=xmlhttp.responseText;
			var reason="reasons_"+questid;
			document.getElementById(reason).innerHTML=str;
		}
	  }
	xmlhttp.open("GET","getreasons.php?questid="+questid+"&flag="+flag,true);
	xmlhttp.send();
}
function checkanswer(questid,answerid){
	var option_name="choice_id_"+questid;
	var objanswer=document.getElementsByName(option_name);
	var flag=false;
	for(j=0;j<objanswer.length;j++){
		if(objanswer[j].checked==true){
			if(objanswer[j].value==answerid){
				var option_aname="status_"+objanswer[j].value;
				document.getElementById(option_aname).innerHTML="<strong style='color:#00ff00;'>Đúng</strong>";
				flag=true;
			}else{
				var option_aname="status_"+objanswer[j].value;
				document.getElementById(option_aname).innerHTML="<strong style='color:#ff0000;'>Sai</strong>";
			}
		}	
	}
	return flag;
}
function check_answer(questid,answerid){
	var option_name="choice_id_"+questid; 
	var objanswer=document.getElementsByName(option_name);
	for(j=0;j<objanswer.length;j++){
		if(objanswer[j].checked==true){
			return true;
		}	
	}
	return false;
}
function setfalse_answer(questid,answerid){
	var option_name="choice_id_"+questid; 
	var objanswer=document.getElementsByName(option_name);
	for(j=0;j<objanswer.length;j++){
		var option_aname="status_"+objanswer[j].value;
		document.getElementById(option_aname).className="status_false";
		if(objanswer[j].value==answerid){
			document.getElementById(option_aname).className="status_true";
		}
	}
}
function getMark(){
	var answer=_answer.split(",");
	var quests=_quests.split(",");
	var count=0;
	var mart=0;
	for(i=0;i<quests.length;i++){
		if(quests[i]==""){
			continue;
		}
		count++;
		if(checkanswer(quests[i],answer[i])==true){
			mart++;
			getreasons(quests[i],1);
		}else{
			getreasons(quests[i],0);
		}
	}
	document.getElementById("_result").innerHTML=mart+"/"+count;
	mart=Math.round(mart*10*100/count)/100;
	document.getElementById("mark").innerHTML=mart;
	update_mark(mart);
}
function getMark_v1(){
	var qid=document.getElementById("txt_qid").value;
	var xmlhttp;
	xmlhttp =createXmlhttp();
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var str= eval(xmlhttp.responseText);
			if(str!=0){
			alert(str);
			var answer=str.split(",");
			var objanswer=document.getElementsByName("txt_answer");
			var count=objanswer.length;
			var mart=0;
			for(i=0;i<count;i++){
				if(objanswer[i].value==answer[i]){
					mart++;
				}
			}
			mart=mart*10/count;
			document.getElementById("mark").innerHTML=mart;
			update_mark(mart);
			}else{
				document.getElementById("mark").innerHTML="Bạn đang offline, Gủi code dưới cho quản trị!";
			}
			
		}
	  }
	xmlhttp.open("GET","process_apply.php?qid="+qid,true);
	xmlhttp.send();
}
function update_mark(mark){
	var idanswer=document.getElementById("txt_ansid").value;
	var xmlhttp;
	xmlhttp =createXmlhttp();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
		}
	}
	xmlhttp.open("GET","process_update_mark.php?idanswer="+idanswer+"&mark="+mark,true);
	xmlhttp.send();
}
function checkOnline(){
	var xmlhttp;
	xmlhttp =createXmlhttp();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4)
		{
			if(xmlhttp.status==200){
			//wait for server reponse scoure
				document.getElementById('status').innerHTML="Đang kết nối internet.";
			}
			else {
				document.getElementById('status').innerHTML="Ngừng kết nối internet: đề nghị anh chị học viên vẫn tiếp tục làm bài và nộp bài bình thường!";
			}
		}
	}
	xmlhttp.open("GET","checkOnline.php",true);
	xmlhttp.send();
	setTimeout('checkOnline()',5000);
}
function createXmlhttp(){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}
function TimeCountdown(){
	var h=0,p=0,s=0,ps=0;	
	if(number_time>3600){
		ps =(Number(number_time)%3600);
		h= (number_time- ps)/3600;
		s=(Number(ps)%60);
		p= (ps - s)/60;
		document.getElementById("time").innerHTML = h + " giờ "+ p + "phút " + s +" giây ";
	}else{
		if(number_time>60){
			s=(Number(number_time)%60);
			
			p= (number_time - s)/60;
			document.getElementById("time").innerHTML = p + "phút " + s +" giây ";
		}
		else{
			document.getElementById("time").innerHTML = number_time + " giây ";
		}
	}
	number_time= number_time-1;
	if(number_time > -1)
		var t=setTimeout('TimeCountdown()',1000);
	else{
		document.getElementById("time").innerHTML = "Hết giờ";
		clearTimeout(t); 
		check_time = false;
		//submitExam();
	}
	if(is_submit==true){
		document.getElementById("time").innerHTML = "Bạn đã nộp bài";
		clearTimeout(t); 
	}
}
function getAnswer(){
	var answer=_answer.split(",");
	var quests=_quests.split(",");
	var str_answer="";
	
	for(i=0;i<quests.length-1;i++){
		setfalse_answer(quests[i],answer[i]);
		if(check_answer(quests[i],answer[i])==false){
			value="-";
					
		}else{
			value=answer[i];
		}
		str_answer+=value+",";
	}
	return str_answer;
}
function getMarkOffline(){
	var code = document.getElementById("txt_code").value;
	var xmlhttp;
	xmlhttp =createXmlhttp();
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var str= xmlhttp.responseText;
			if(str!=''){
				alert(str);
				var answer=str.split(",");
				document.getElementById("ucode").innerHTML=answer[0];
				document.getElementById("mark").innerHTML=answer[1];
			}else{
				document.getElementById("mark").innerHTML="Bạn đang offline, hãy thử lại!";
			}
		}
	  }
	xmlhttp.open("GET","process_getmark.php?code="+code,true);
	xmlhttp.send();
}
function submitExam(){
	if(check_time == true && is_submit==false){	
		if(checkinput()==false)
			return false;
		var id = document.getElementById("txt_id").value;
		var key = document.getElementById("txt_key").value;
		var user = document.getElementById("txt_user").value;
		var plaintext = getAnswer();
		document.getElementById("result_answer").value=plaintext;
		var ciphertext = Aes.Ctr.encrypt(plaintext,key, 256);
		document.getElementById("code_result_text").value= user+"*"+id+"*"+ciphertext+"#";
		getMark();
		is_submit=true;
	}else{
		if(check_time==false)
			alert("Hết giờ làm bài");
		if(is_submit==true)
			alert("Bạn đã nộp bài");
	}
}
function checkinput(){
	var answer=_answer.split(",");
	var quests=_quests.split(",");
	
	for(i=0;i<quests.length-1;i++){
		if(check_answer(quests[i],answer[i])==false){
			alert("Có câu hỏi chưa được chọn đáp án!");
			return false;
		}
	}
	return true;
}