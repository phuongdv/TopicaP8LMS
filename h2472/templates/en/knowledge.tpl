
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Knowledge base setting page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link title="ATHK Style" href="assets/css/style.css" type="text/css" rel="stylesheet" />
<link title="ATHK Style" href="assets/css/calendar.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/mootools.js"></script>

<script type="text/javascript" src="assets/js/search.js"></script>

<script language="JavaScript" src="assets/js/functions.js"></script>
<script type="text/javascript"src="assets/js/zxml.js"></script>

<script type="text/javascript"src="assets/js/modal.js"></script>
<link href="assets/css/modal.css" type="text/css" rel="stylesheet" />

<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
}
.bg_color1
        {
		background-color:#CCCCCC;
		}
-->
</style>
   {refresh}
		<div id="content_knowledge">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span style="float:left;color:#ffffff; margin-top:8px;"><strong class="member" style="color:#FFF">{user}</strong></span><span style="float:right;color:#ffffff; margin-top:8px;" > <a href="./?act=logout" title="" style="color:#FFF" >Quay v? l?p h?c</a> |  <a href="javascript: window.close()" title="" style="color:#FFF">Ðóng c?a s?</a></span></h3>
					<div class="modulecontent clearfix">

						<table width="391" cellpadding="1" cellspacing="10">
							<tr>
								<td width="101"> 
                                  Search for
								<td width="250"><select name="course" id="course" style="width:250px;">
                                  <option value="0">All subject</option>
                                  <!-- BEGIN SUBJECT -->
                                  <option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>
                                  <!-- END SUBJECT -->
                                </select>
							  <label></label></td>
							</tr>
							<tr>
							  <td>Search keyword
							  <td><input type="text" name="txtFulltext" id="txtFulltext" style="width:245px" width="150" value="{searchtext}" /></td>
						  </tr>
							<tr>
							  <td>
							  <td><input type="button" name="btnTim" id="btnTim" value="      Search(filter)     " style="" onclick="window.open('?do=knowledge&subject='+document.getElementById('course').value+'&searchtext='+document.getElementById('txtFulltext').value,'_self'); " />
						      <input type="button" name="btnClear" id="btnClear" style="" value="     Show all     " onclick="window.open('?do=knowledge','_self'); " /></td>
						  </tr>
						</table>
                      <form id="knowledge" method="post" action="">
					  <table class="list" cellpadding="1" cellspacing="1" width="100%">
			  <thead>
								<tr>
									<th>ID</th>
									<th>Topic</th>
                                    <th>Course</th>
								  <th>Number of question</th>
									<th>Question Owner</th>
									<th>Time</th>
								  <th>Answerer</th>
								  <th><label>
								   
								  </label></th>
								</tr>
							</thead>
							<tbody>
								<!-- BEGIN L_ANWSER -->
								<tr  style="{L_ANWSER.tr_class}">
									<td>{L_ANWSER.id}</td>
									<td><a href="./?act=answers&do=detail&id={L_ANWSER.id}" title="">{L_ANWSER.name}</a></td>	
									<td>{L_ANWSER.cname}</td>
                                  <td>{L_ANWSER.rate}</td>
									<td nowrap="nowrap">{L_ANWSER.author}</td>
									<td nowrap="nowrap">{L_ANWSER.time}</td>
									<td nowrap="nowrap">{L_ANWSER.answer}</td>
								    <td nowrap="nowrap">{L_ANWSER.knowledge}</td>
								</tr>
                                <!-- END L_ANWSER -->
							</tbody>
						</table>
                        
                      <div align="right" >{linkpage}</div>
						<div align="center" style=" display:{empty};"> No question yet</div>
						
                     <br />
                        <table width="268" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="145" bgcolor="#CCCCCC">Number of topic:</td>
                            <td width="75" bgcolor="#CCCCCC">{total} </td>
                          </tr>
                          <tr>
                            <td>Number of topic in knowledge base</td>
                            <td>{total_filter}</td>
                          </tr>
                        </table>
                        
						<div align="right" style="margin-top:-20px">
						<input type="submit" name="button" id="button" value=" Luu " />
					    </div>
                      </form>
					  
					    </p>
				  </div>
				</div>
			</div></div></div>
			<div class="frame-bot">
			  <div class="frame-bl"></div>
		  <div class="frame-br">&nbsp;</div></div>
		</div>
