<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>TOPICA</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link title="ATHK Style" href="assets/css/style.css" type="text/css" rel="stylesheet" />
<link title="ATHK Style" href="assets/css/calendar.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/mootools.js"></script>

<script type="text/javascript" src="assets/js/search.js"></script>

<script language="JavaScript" src="assets/js/functions.js"></script>
<script type="text/javascript"src="assets/js/zxml.js"></script>

<script type="text/javascript"src="assets/js/modal.js"></script>
<link href="assets/css/modal.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
	window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
	window.addEvent('domready', function() {
		SqueezeBox.initialize({});

		$$('a.modal').each(function(el) {
			el.addEvent('click', function(e) {
				new Event(e).stop();
				SqueezeBox.fromElement(el);
			});
		});
	});
</script>
</head>
<body>
	<div id="asign">
		<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
		<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
			<div class="module clearfix">
				<form method="post" name="answers" enctype="multipart/form-data">
                    
                <h3><span>Assign và Chuyển tiếp câu hỏi <input type="submit" name="submit" value="Chấp nhận" style="float:right"/></span> </h3>
				<div class="modulecontent clearfix">
					
					<table cellpadding="1" cellspacing="10" style="width:100%;">
						<!-- BEGIN NEWUSER_MSG -->
						<tr>
							<td colspan="2" style="text-align:center;">{NEWUSER_MSG.newuser_msg}</td>
						</tr>
						<!-- END NEWUSER_MSG -->
						<!-- BEGIN ASSIGNFORM -->
						<tr>
							<td width="26%" height="15">Câu hỏi: </td>
						  <td width="74%"><strong>{ASSIGNFORM.name}</strong></td>
					  <tr>
                        <tr>
							<td height="15">Người đặt: </td>
							<td><strong>{ASSIGNFORM.author}</strong></td>
						<tr>
						<tr>
							<td height="15">Khóa học: </td>
							<td><strong>{ASSIGNFORM.fullname}</strong></td>
						<tr>
                        <tr>
							<td height="15">Độ trễ: </td>
							<td><strong>{ASSIGNFORM.delay}</strong></td>
						<tr>
						<tr>
							<td>Nội dung: </td>
							<td>{ASSIGNFORM.answerdes}</td>
						<tr>
                        {ASSIGNFORM.unassign}
						<tr>
							<td>Assign cho: </td>
							<td>
								<select id="assign" name="assign" size="10" style="width:400px;">
									<!-- BEGIN ASSIGN -->
									<option value="{ASSIGNFORM.ASSIGN.id}"{ASSIGNFORM.ASSIGN.selected}>--&nbsp;({ASSIGNFORM.ASSIGN.role})&nbsp;{ASSIGNFORM.ASSIGN.name}</option>
									<!-- END ASSIGN -->
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input style="visibility:hidden" type="text" name="keyword" value="" id="keyword" onkeyup="showHint(this.value)" onblur="if(this.value=='') this.value='';" onfocus="if(this.value=='') this.value='';" />
								<div id="search_vm"></div>
								<div id="search_results">
								<div align="left"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" name="submit" value="Chấp nhận" /></td>
						</tr>
						<!-- END ASSIGNFORM -->
					</table>
					</form>
				</div>
			</div>
		</div></div></div>
		<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
	</div>
</body>
</html>