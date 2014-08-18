function replyactive() {

	$('replyform').setStyle('display','block');

	$('reply_button').setStyle('display','none');

	HTMLArea.init();

	HTMLArea.onload = initDocument;	 

}

function questionactive()

 	 {

	$('questionform').setStyle('display','block');

	$('reply_ask').setStyle('display','none');

	HTMLArea.init();

	HTMLArea.onload = initDocument;	 	 

	}

function creatanswer() {

	var select_course = document.getElementById('course').value;

	if(1==0) {

		alert('Mời bạn chọn một khóa học!');

		return false;

	} else {

		window.open('?act=answers&do=creat&course='+document.getElementById('course').value+'&topic='+document.getElementById('lstTopic').value,'_self');

		return true;

		

			

	}

}



function showElapsedTime(target,o_year,o_month,o_day,o_hour,o_min,o_second,r_year,r_month,r_day,r_hour,r_min,r_second) {



	var oldYear = o_year;

	var oldMonth = o_month; // must be between 0 - 11

	var oldDay = o_day; // must be between 1 - 31

	var oldHour = o_hour; // must be between 0 - 23

	var oldMinute = o_min; // must be between 0 - 59

	var oldSecond = o_second; // must be between 0 - 59



	//alert(oldYear+'-'+oldMonth+'-'+oldDay+'-'+oldHour+'-'+oldMinute+'-'+oldSecond);



	var startYear = r_year;

	var startMonth = r_month; // must be between 0 - 11

	var startDay = r_day; // must be between 1 - 31

	var startHour = r_hour; // must be between 0 - 23

	var startMinute = r_min; // must be between 0 - 59

	var startSecond = r_second; // must be between 0 - 59



	var startDate = new Date();

	startDate.setFullYear(startYear);

	startDate.setMonth(startMonth);

	startDate.setDate(startDay);

	startDate.setHours(startHour);

	startDate.setMinutes(startMinute);

	startDate.setSeconds(startSecond);



	var oldDate = new Date();

	oldDate.setFullYear(oldYear);

	oldDate.setMonth(oldMonth);

	oldDate.setDate(oldDay);

	oldDate.setHours(oldHour);

	oldDate.setMinutes(oldMinute);

	oldDate.setSeconds(oldSecond);

	//Get elapsed time.



	var newsecond = startDate.getTime() + 1000;



	var newDate = new Date();

	newDate.setTime(newsecond);



	var elapsedTime = newsecond - oldDate.getTime();



	//alert(oldDate.getTime());

	//Get 1 day in milliseconds

	var one_day=1000*60*60*24;

	var elapsedDays = Math.floor( elapsedTime / one_day );

	var milliSecondsRemaining = elapsedTime % one_day; //Milliseconds still unaccounted for - less than a day’s worth.

	//Get 1 hour in milliseconds

	var one_hour = 1000*60*60;

	var elapsedHours = Math.floor(milliSecondsRemaining / one_hour );

	milliSecondsRemaining = milliSecondsRemaining % one_hour; //Milliseconds still unaccounted for - less than an hour’s worth.

	//Get 1 minute in milliseconds

	var one_minute = 1000*60;

	var elapsedMinutes = Math.floor(milliSecondsRemaining / one_minute );

	milliSecondsRemaining = milliSecondsRemaining % one_minute; //Milliseconds still unaccounted for - less than a minute’s worth.

	//Get 1 second in milliseconds

	var one_second = 1000;

	var elapsedHours_final = (elapsedDays*24) + elapsedHours;

	var elapsedSeconds = Math.round(milliSecondsRemaining / one_second);



	startDate.setMilliseconds(startDate.getMilliseconds()+1000);



	$(target).innerHTML = elapsedHours_final + "h:" + elapsedMinutes + "m:" + elapsedSeconds + "s";

	

	//alert(oldYear+','+oldMonth+','+oldDay+','+oldHour+','+oldMinute+','+oldSecond+','+startDate.getFullYear()+','+startDate.getMonth()+','+startDate.getDay()+','+startDate.getHours()+','+startDate.getMinutes()+','+startDate.getSeconds() );



	setTimeout('showElapsedTime("'+target+'",'+oldYear+','+oldMonth+','+oldDay+','+oldHour+','+oldMinute+','+oldSecond+','+newDate.getFullYear()+','+newDate.getMonth()+','+newDate.getDay()+','+newDate.getHours()+','+newDate.getMinutes()+','+newDate.getSeconds()+')',1000);

}