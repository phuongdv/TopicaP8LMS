<style type="text/css">

<!--

.style2 {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 12pt;

	color: #810c15;

	font-weight: bold;

}

-->

</style>

		<div id="content">

			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>

			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">

				<div class="module clearfix">

					<h3><span style="float:left;color:#ffffff; margin-top:8px;">PO Class-Subject <strong class="member" style="color:#ffffff">{user}</strong></span><span style="float:right;color:#ffffff;margin-top:8px;"><a style="color:#ffffff" target="_blank" href="{linkportal}" title="">Amatop Home page</a> &nbsp;|&nbsp; <a style="color:#ffffff" target="_blank" href="{linkforum}" title="">Forum</a> 

                    &nbsp;|&nbsp; <a style="color:#ffffff" target="_blank" href="./?do=knowledge" title="">Knowledge base management</a>&nbsp;|&nbsp; <a style="color:#ffffff" target="_blank" href="./?do=view_kkt" title="">Knowledge base</a> &nbsp;|&nbsp;  <a style="color:#ffffff" href="./?act=logout" title="">Return to classroom</a></span></h3>

					

					<div class="modulecontent clearfix">

                  <table width="692" cellpadding="1" cellspacing="10">

							<tr>

							  <td>Find by individual</td>                           

							  <td><select style="width:150px" name="do" id="do" class="dropdown">

							      <option value="0" {selected_1}> Display all questions </option>

							      <option value="myanswer" {selected_2}>Display my question(s)</option>

                                                                </select></td>

							  <td>&nbsp;</td>

							  <td><a href="/faq/faq.html" class="modal style1 style2 style3" rel="{handler: 'iframe', size: {x: 900, y: 600}}">FAQ !</a></td>

				    </tr>

							<tr>

								<td width="86"> 

                                  Search for

								<td width="157">

									<select name="course" id="course" style="width:150px;">

										<option value="0">All subject</option>

										<!-- BEGIN SUBJECT -->

										<option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>

										<!-- END SUBJECT -->

									</select>

									<label></label></td>

								<td width="168">Assign to:</td>

								<td width="201">

									<select name="gv" id="gv" style="width:150px">

										<option value="0">All</option>

										<!-- BEGIN GVHD -->

										<option value="{GVHD.id}"{GVHD.selected}>{GVHD.name}</option>

										<!-- END GVHD -->

									</select>

									<label></label>									</td>

						    </tr>

							<tr>

							  <td>Topic<td>

							      <select name="lstTopic" id="lstTopic" style="width:150px">

							        <option value="0">All topics</option>

                                    <!-- BEGIN LSTTOPIC -->

                                    <option value="{LSTTOPIC.id}" {LSTTOPIC.select}>{LSTTOPIC.name}</option>

                                    <!-- END LSTTOPIC -->

						            </select>							  </td>

							  <td>Delay</td>

							  <td><select name="delay" id="delay" style="width:150px;"

                                 

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

                                

							      <select name="lstStatus" id="lstStatus" style="width:150px">

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

							      <input type="text" name="txtFulltext" id="txtFulltext" style="width:145px"  value="{searchtext}" />							  </td>

					      </tr>

							<tr>

							  <td>Attachments<td>

							    

							        <select name="select" id="lstAttach" style="width:150px">

							          <option value="0">All</option>

                                      <!-- BEGIN FILEATTACH -->

							          <option value="1" {FILEATTACH.select1}>Yes</option>

							          <option value="2" {FILEATTACH.select2}>No</option>

                                       <!-- END FILEATTACH -->

						            </select>

						         

							  </td>

							  <td>Topic ID</td>

						    <td><input type="text" style="width:145px" name="thr_id" id="thr_id" value="{thr_id}" /></td>

					      </tr>

							<tr>

							  <td colspan="2"><input type="button" style="width:250px"  name="btnTim" id="btnTim" value="         Search(Filter)       " onclick="window.open('?subject='+document.getElementById('course').value+'&gv='+document.getElementById('gv').value+'&topic='+document.getElementById('lstTopic').value+'&delay='+document.getElementById('delay').value+'&status='+document.getElementById('lstStatus').value+'&searchtext='+document.getElementById('txtFulltext').value+'&attach='+document.getElementById('lstAttach').value+'&thr_id='+document.getElementById('thr_id').value+'&do='+document.getElementById('do').value,'_self'); " />

							  <td><input type="button"  style="width:120px" name="btnClear" id="btnClear" value="      Show all    " onclick="window.open('?','_self'); " />							     				  </td>

							  <td align="right" style="padding-right:0px;" ><button type="button" style="width:120px;"  onclick="return creatanswer();">Make new question </button>&nbsp <input type="button" onclick="window.open('?act=export&sql={sql}','_self');" value="Export to Excell"></td>

						  </tr>

						</table>

                      <div align="right">{linkpage}</div>

                      <div style="float:right;margin-top:-180px" >

                      	<div style="float:left; width:120px;"><a class="modal" rel="{handler: 'iframe', size: {x: 750, y: 500}}"  href="ds_cvht.html">CVHT List</a></div>

							  <div ><a class="modal" rel="{handler: 'iframe', size: {x: 750, y: 500}}"  href="ds_po.html">PO List</a></div>

                              

                            </tr>

                            

                        </table>

                        <table class="list" width="265" border="0" cellpadding="1" cellspacing="1">

                          <thead>

                          <tr>

                            <th colspan="2" >&nbsp;</td>

                            <th width="115" >Topic</td>

                            <th width="50" >Question</td>

                          </tr>

                          </thead>

                          <tbody>

                          

                          <tr>

                            

                            <td colspan="2" width="110">Unanswered</td>

                            <td style="color:#CC0000; font-weight:bold"><a href="?subject=0&gv=0&topic=0&delay=0&status=5&searchtext=&attach=0">{thr_norep}</a> | open: {mo} | await:{cho}</td>

                            <td style="color:#CC0000; font-weight:bold">{qs_norep}</td>

                          </tr>

                          <tr>

                            

                            <td colspan="2">Answered</td>

                            <td>{thr_repl}</td>

                            <td>{qs_repl}</td>

                          </tr>

                          <tr>

                            <td colspan="2">After filtering:</td>

                            <td >{total_filter}</td>

                            <td>{filter_question}</td>

                          </tr>

                          <tr>

                            <td colspan="2" >Total</td>

                            <td >{total}</td>

                            <td >{total_question}</td>

                          </tr>

                          </tbody>

                        </table>

						



                      </div>



					  <table class="list" cellpadding="1" cellspacing="1" width="100%">

			  <thead>

								<tr>

									<th>ID</th>

									<th>Topic</th>

                                    <th>Course</th>

								  <th>Number of question</th>

									<th>Question Owner</th>

									<th>Time</th>

									<th>Delay</th>

									<th>Answerer</th>

									<th>Forward</th>

									<th>Status</th>
									<th>Thanks</th>

								    <th>&nbsp;</th>

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

									<td><a class="modal" rel="{handler: 'iframe', size: {x: 570, y: 550}}" href="./?do=assign&id={L_ANWSER.q_id}&thr_id={L_ANWSER.id}" style="{L_ANWSER.forward}">Assign</a></td>

									<td nowrap="nowrap"><strong>{L_ANWSER.status}</strong></td>
									<td align="center">{L_ANWSER.thanks}</td>

								    <td nowrap="nowrap"><a class="modal" rel="{handler: 'iframe', size: {x: 600, y: 240}}"  href="?do=edit_thread&id={L_ANWSER.id}"><img  style="border-style: none;" src="images/edit.png"/></td>

								</tr>

                                <!-- END L_ANWSER -->

							</tbody>

						</table>

                      <div align="right" >{linkpage}</div>

						<div align="center" style=" display:{empty};"> No question yet</div>

						

                     <br />

                        

						

					  

				      </p>

				  </div>

				</div>

			</div></div></div>

			<!--<div class="frame-bot">

			  <div class="frame-bl"></div>

		  <div class="frame-br">&nbsp;</div></div>-->

		</div>

