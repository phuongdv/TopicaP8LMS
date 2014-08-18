<style type="text/css">
<!--
.style3 {font-weight: bold; font-size: 9pt;}
.style4 {font-size: 9pt}
.style5 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 9pt;
}
-->
</style>

<div id="content" style="font-family:Arial, Helvetica, sans-serif; font-size:10pt">
			
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<div class="modulecontent clearfix">
					  <form method="post" name="answers" action="?act=send" enctype="multipart/form-data">
						<table cellpadding="1" cellspacing="10">
							<!-- BEGIN QUESTION -->
							<tr>
								<td colspan="2" class="errmsg">&nbsp;</td>
						  </tr>
						
							<tr>
								<td class="style3">Question's name: </td>
								<td><span class="style4">{QUESTION.name}</span><input type="hidden" id="name" name="name" value="{QUESTION.name}" /></td>
						  </tr>
							<tr>
							  <td><span class="style4"><strong>Question Owner</strong></span></td>
							  <td><label class="style4">{QUESTION.author} - (<em>{QUESTION.username}</em>)</label><input type="hidden" id="acc" name="acc" value="{QUESTION.author}" /></td>
						  </tr>
							<tr>
							  <td><span class="style4"><strong>Class</strong></span></td>
							  <td><span class="style4">{QUESTION.course}</span></td>
						  </tr>
							<tr>
							  <td><span class="style4"><strong>Question time/strong></span></td>
							  <td><span class="style4" id="time" name="time">{QUESTION.time}</span><input type="hidden" id="time" name="time" value="{QUESTION.time}" /></td>
						  </tr>
							<tr>
							  <td><span class="style4"><strong>Delay</strong></span></td>
							  <td><span class="style4">{QUESTION.delay}<input type="hidden" id="delay" name="delay" value="{QUESTION.delay}" /></span></td>
						  </tr>
							<tr>
								<td><span class="style4"><strong>Question ID</strong></span></td>
								<td><span class="style4">{QUESTION.id}<input type="hidden" id="answerid" name="answerid" value="{QUESTION.id}" /></span></td>
						  </tr>
							<tr>
								<td><span class="style4"><strong>Topic ID</strong></span></td>
								<td><span  class="style4">&nbsp;{QUESTION.thread}<input type="hidden" id="thread" name="thread" value="{QUESTION.thread}" />
                                
                                </span></td>
						  </tr>
                            <tr>
                              <td colspan="2"><span class="style4"><strong>Question content:<div ><input type="hidden" id="link" name="link" value="{QUESTION.link}" /></div></strong></span></td>
                            </tr>
                            <tr>
                            <td colspan="2" style="border:solid 1px #810c15; padding:10px"><label id="noidung" name="noi dung" class="style4" >{QUESTION.des}</label>
                              <input type="hidden" id="noidung" name="noidung" value="{QUESTION.des}" />                              </td>
                            </tr>
							<tr>
							<td ><span class="style4"><strong>Answerer's Email</strong></span></td>
								<td><span class="style4">
								  <label>
								  <input type="text" name="answer" id="answer" />
								  </label>
								</span></td>	
						  </tr>
							<tr>
							  <td ><span class="style4"><strong>Email cc</strong></span></td>
							  <td><label>
							    <input type="text" name="mailcc" id="mailcc" />
							  </label></td>
						  </tr>
							{attact}
							<tr>
								<td colspan="2">                                    	</td>
							</tr>
							<tr>
								<td colspan="2"><p class="style5">Message (&lt;=140 words):  </p>
								  <label>
							      <textarea name="message" id="message" cols="45" rows="5"></textarea>
							      </label>
						        <p>&nbsp;</p></td>
						    </tr>
							<tr>
								<td colspan="2"><input type="hidden" id="from" name="from" value="{QUESTION.from}" />
 <input type="submit" name="submit" value="   G?i di   " onclick="ste.submit();" /></td>
							</tr>
						</table>
					  </form>
	<!-- END QUESTION -->
					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>