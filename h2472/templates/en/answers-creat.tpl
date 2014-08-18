		<script type="text/javascript">
			HTMLArea.init();
			HTMLArea.onload = initDocument;
		</script>
		<style type="text/css">
<!--
.style1 {
	color: #810c15;
	font-weight: bold;
	line-height:1.5;
}
.style2 {
	font-size: 10pt;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
.style3 {color: #810c15}
.style4 {
	color: #000000;
	font-weight: bold;
	line-height: 1.5;
	font-family: Arial, Helvetica, sans-serif;
}
-->
        </style>
		
        <div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span style="color:#FFFFFF">Welcome <strong class="member">{user}</strong></span></h3>
                    
					<div class="modulecontent clearfix">
						<table cellpadding="1" cellspacing="10">
							<tr>
								<td><button onClick="location.href = './'">Back to Home page</button></td>
							</tr>
						</table>
						<form method="post" name="answers" enctype="multipart/form-data">
						<table width="986" cellpadding="1" cellspacing="10">
							<!-- BEGIN NEWUSER_MSG -->
							<tr>
								<td colspan="2" class="errmsg">{NEWUSER_MSG.newuser_msg}</td>
							</tr>
							<!-- END NEWUSER_MSG -->
							<tr>
								<td width="80"><strong>Question name:</strong></td>
								<td width="330"><input type="text" name="name" value="{name}" size="55" /></td>
							<td width="634" rowspan="4" valign="top">
							
						<table border="0" cellspacing="0" cellpadding="0" width="400">
  <tr>
    <td nowrap="nowrap" colspan="2" valign="bottom"><strong>CREATING QUESTION'S RULES:</strong></td>
  </tr>
  <tr>
    <td width="2" nowrap="nowrap" valign="bottom"></td>
    <td valign="bottom">+ Questions <strong>MUST</strong> <strong>comply with the requirements</strong> below the items</td>
  </tr>
  <tr>
    <td width="2" nowrap="nowrap" valign="bottom"></td>
    <td valign="bottom">+ The question is not properly specified will be rejected reply. </td>
  </tr>
  <tr>
    <td width="2" nowrap="nowrap" valign="bottom"></td>
    <td valign="bottom">Student <strong>MUST</strong> re-create question follow the requirements to be answered</td>
  </tr>
  <tr>
    <td width="2" nowrap="nowrap" valign="bottom"></td>
    <td valign="bottom">+ Example for valid question : <a style="color:#810c15;font-weight:bold" class="modal" rel="{handler: 'iframe', size: {x: 600, y: 600}}"  href="http://eldata1.neu.topica.vn/images/H2472%20-%20Cau%20hoi%20dung.png"><em>See here</em></a></td>
  </tr>
  <tr>
    <td width="2" nowrap="nowrap" valign="bottom"></td>
    <td valign="bottom">+ Example for invalid question : <a style="color:#810c15;font-weight:bold" class="modal" rel="{handler: 'iframe', size: {x: 600, y: 600}}"  href="http://eldata1.neu.topica.vn/images/H2472%20-%20Cau%20hoi%20sai.png"><em>See here</em></a></td>
  </tr>
</table>

			
							  </td>
							</tr>
							<tr>

							<td colspan="2">
							
							
							
							<table border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="256" nowrap="nowrap" colspan="3" valign="bottom"><p>Question's name requirements:</p></td>
    <td width="122" nowrap="nowrap" valign="bottom"></td>
    <td width="124" nowrap="nowrap" valign="bottom"></td>
    <td width="124" nowrap="nowrap" valign="bottom"></td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="539" nowrap="nowrap" colspan="5" valign="bottom">+ <strong>MUST</strong> start with <strong>SM</strong> or <strong>subject ID</strong> relate to the question. Ex: ICT101, PSD101</td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="539" nowrap="nowrap" colspan="5" valign="bottom">+ <strong>MUST</strong> has at least 5 words and content to ask</td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="292" nowrap="nowrap" colspan="3" valign="bottom"><strong>Example for valid question:</strong></td>
    <td width="124" nowrap="nowrap" valign="bottom"></td>
    <td width="124" nowrap="nowrap" valign="bottom"></td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="539" nowrap="nowrap" colspan="5" valign="bottom">+ With question relate to subject:</td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="168" nowrap="nowrap" valign="bottom"></td>
    <td width="372" nowrap="nowrap" colspan="4" valign="bottom">ICT101: Lecture Lession 1 have no sound.</td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="539" nowrap="nowrap" colspan="5" valign="bottom">+ With question relate to SM</td>
  </tr>
  <tr>
    <td width="87" nowrap="nowrap" valign="bottom"></td>
    <td width="168" nowrap="nowrap" valign="bottom"></td>
    <td width="372" nowrap="nowrap" colspan="4" valign="bottom">SM: Procedures to complete profiles</td>
  </tr>
</table></td>
							<td></td>
							</tr>
							<tr>
								<td><strong>Question type: </strong></td>
								<td>
									<select name="topic">
                                    <option value="">Choose type</option>
										<!-- BEGIN TOPIC_CREATE -->
										<option value="{TOPIC_CREATE.id}"{TOPIC_CREATE.selected}>{TOPIC_CREATE.name}</option>
										<!-- END TOPIC_CREATE -->
									</select>								</td>
                            </tr>
							<tr>
								<td>Requirement: </td>
								<td>
									 + Choose the right type of questions

									</td>
                            </tr>
							<tr>
								<td><strong>Course: </strong></td>
								<td>
									<select name="course">
                                     <option value="">Choose course</option>
										<!-- BEGIN COURSE -->
										<option value="{COURSE.id}"{COURSE.selected}>{COURSE.name}</option>
										<!-- END COURSE -->
									</select>
                                    &nbsp;</td>
                            </tr>
							<tr>
								<td>Requirement: </td>
								<td>
									 + Choose the right course

									</td>
                            </tr>
                           
							<tr>
							<td style="display:none" >Send to: </td>
								<td>
									<table>
										<tr>
											<!-- BEGIN GROUP -->
											<td style="display:none"><input type="radio" name="group" value="{GROUP.id}"{GROUP.checked} /> {GROUP.name}></td>
											<!-- END GROUP -->
										</tr>
									</table>								</td>	
							</tr>
							{attact}
										<tr>
										  <td valign="top"><strong>Content</strong></td>
										  <td>&nbsp;</td>
						  </tr>
										<tr>
								<td valign="top">Requirement: </td>
								<td>
									 + MUST start with an introduction. Formal vocative.<br>
									 + SHOULD BE detail as quick to be answered<br>
									 Should have screenshot relate to the question<br>
									 + MUST end with thank to teacher.

									</td>
                            </tr>
                            <tr>
							<tr>
								<td colspan="3">
									<!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    <!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    	<textarea cols="80" id="editor_kama" name="editor_kama" rows="10">{des}</textarea>
			<script type="text/javascript">
			//<![CDATA[
				CKEDITOR.replace( 'editor_kama',
					{
						skin : 'kama',
						language : 'en'
					});
			//]]>
			</script>								</td>
            </tr>
							<tr>
								<td>Attachments: </td>
								<td><input type="file" name="attach" value="Browser"/></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" name="submit" value="Accept" onClick="ste.submit();" /><br>Note : Attachments extension : .jpg, .gif, .png, .doc, .docx, .xls </td>
                                                               
							</tr>
						</table>
					  </form>
					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>