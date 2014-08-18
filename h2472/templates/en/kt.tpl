<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
}
-->
</style>
		<div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span>Technician <strong class="member">{user}</strong> <a href="./?act=logout" title="" style="padding-left:400px;">Return to classroom</a></span></h3>
				  <div class="modulecontent clearfix">

						<table cellpadding="1" cellspacing="10">
							<tr>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
						  </tr>
							<tr>
							  <td>Search for
							  <td><select name="course" id="course" class="dropdown" style="width:150px">
										<option value="0">All subject</option>
										<!-- BEGIN SUBJECT -->
										<option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>
										<!-- END SUBJECT -->
									</select>   							  </td>
							  <td>Delay</td>
							  <td><select name="delay" id="delay" class="dropdown" style="width:150px"
                                 
                                    >
                                <!-- BEGIN DELAY -->
                                <option value="0">All</option>
                                <option value="1" {DELAY.selected1}>0-24h</option>
                                <option value="2" {DELAY.selected2}>24h-48h</option>
                                <option value="3" {DELAY.selected3}>48h-72h</option>
                                <option value="4" {DELAY.selected4}> &gt; 72h</option>
                                <!-- END DELAY -->
                              </select></td>
						  </tr>
							<tr>
							  <td>Status
							  <td>
                                
							      <select name="lstStatus" id="lstStatus" class="dropdown" style="width:150px">
                                    <!-- BEGIN STATUS -->
							        <option value="0">All status</option>
							        <option value="1" {STATUS.select1}>Recently opened</option>
							        <option value="2" {STATUS.select2} >Awaiting reply</option>
                                    <option value="5" {STATUS.select5}>Recently opened or awaiting reply</option>
							        <option value="3" {STATUS.select3}>Answered</option>
							        <option value="4" {STATUS.select4}>Closed</option>
                                    <option value="6" {STATUS.select6}>Answered or closed</option>

                                    <!-- END STATUS -->
				                    </select>							  </td>
							  <td>Search keyword</td>
							  <td>
							      <input type="text" name="txtFulltext" id="txtFulltext" style="width:145px" value="{searchtext}" />							  </td>
						  </tr>
							<tr>
							  <td>Attachments<td>
							    
							        <select name="select" id="lstAttach" class="dropdown" style="width:150px">
							          <option value="0">All</option>
                                      <!-- BEGIN FILEATTACH -->
							          <option value="1" {FILEATTACH.select1}>Yes</option>
							          <option value="2" {FILEATTACH.select2}>No</option>
                                       <!-- END FILEATTACH -->
						            </select>
						         
							  </td>
							  <td>Find by individual</td>
							  <td>
							    
							    <select name="do" id="do" class="dropdown" style="width:150px">
							      <option value="0" {selected_1}> Display all questions </option>
							      <option value="myanswer" {selected_2}>Display my question(s)</option>
                                                                </select>						      						  </td>
						  </tr>
							<tr>
							  <td>                            
							  <td> <div align="right">
							    <input type="button" style="width:150px"  name="btnTim" id="btnTim" value="         Search(Filter)        " onclick="window.open('?subject='+document.getElementById('course').value+'&gv='+document.getElementById('gv').value+'&topic='+document.getElementById('lstTopic').value+'&delay='+document.getElementById('delay').value+'&status='+document.getElementById('lstStatus').value+'&searchtext='+document.getElementById('txtFulltext').value+'&attach='+document.getElementById('lstAttach').value+'&do='+document.getElementById('do').value,'_self'); " />							  </td>
							 	
						      </td>
					      <td><input type="button"  style="width:120px" name="btnClear" id="btnClear" value="         Show all        " onclick="window.open('?','_self'); " />						  </tr>
						</table>

				    <table class="list" cellpadding="1" cellspacing="1" width="100%">
			  <thead>
								<tr>
									<th>ID</th>
									<th>Topics</th>
                                    <th>Course</th>
								  <th>Number of question</th>
									<th>Question Owner</th>
									<th>Time</th>
									<th>Delay</th>
									<th>Answer</th>
									
									<th>Status</th>
								</tr>
						</thead>
							<tbody>
								<!-- BEGIN L_ANWSER -->
								<tr>
									<td>{L_ANWSER.id}</td>
									<td><a href="./?act=answers&do=detail&id={L_ANWSER.id}" title="">{L_ANWSER.name}</a></td>	
									<td>{L_ANWSER.cname}</td>
                                  <td>{L_ANWSER.rate}</td>
									<td nowrap="nowrap">{L_ANWSER.author}</td>
									<td nowrap="nowrap">{L_ANWSER.time}</td>
									<td style="white-space:nowrap;">
										{L_ANWSER.delay}									</td>
									<td nowrap="nowrap">{L_ANWSER.answer}</td>
									
									<td nowrap="nowrap"><strong>{L_ANWSER.status}</strong></td>
								</tr>
                                <!-- END L_ANWSER -->
								
							</tbody>
					</table>
                        <div align="right" >{linkpage}</div>
						<div align="center" style=" display:{empty};"> No question yet</div>
						
                     <br />
                        
                          <tr>
                            <td width="145" bgcolor="#CCCCCC">&nbsp;</td>
                            <td width="75" bgcolor="#CCCCCC">Topic</td>
                            <td width="162" bgcolor="#CCCCCC">Question</td>
                          </tr>
                          <tr>
                            <td>After filering:</td>
                            <td>{total_filter}</td>
                            <td>{filter_question}</td>
                          </tr>
                          <tr>
                            <td bgcolor="#CCCCCC">Total</td>
                            <td bgcolor="#CCCCCC">{total}</td>
                            <td bgcolor="#CCCCCC">{total_question}</td>
                          </tr>
                        </table>						<p>&nbsp;</p>
					  
					    </p>
				  </div>
				</div>
			</div></div></div>
			<div class="frame-bot">
			  <div class="frame-bl"></div>
		  <div class="frame-br">&nbsp;</div></div>
		</div>
