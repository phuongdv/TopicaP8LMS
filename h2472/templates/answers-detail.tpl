	<script type="text/javascript">

			HTMLArea.init();

			HTMLArea.onload = initDocument;

		</script>

        <div id="content">

			<div class="frame-top">

			  <div class="frame-tl"></div><div class="frame-tr">&nbsp;</div></div>

			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">

				<div class="module clearfix">

					<h3><span  style="color:#ffffff; float:left; margin-top:8px;"><strong class="member" style="color:#ffffff">{user}</strong><label style="padding-left:20px;color:#ffffff"> Mã chủ đề:&nbsp;{id_answer}&nbsp; </label>

					<label style="color:#ffffff">&nbsp;{assigner}&nbsp;|&nbsp;Trạng thái : {thread_status} </label></span><span style="float:right;color:#ffffff;margin-top:8px;"><a href="./?do=view_kkt" title="" style="color:#ffffff">Kho kiến thức </a>&nbsp; | &nbsp; <a style="color:#ffffff" href="{linkforum}" title="" >Diễn đàn </a>&nbsp; | &nbsp; <a  style="color:#ffffff" href="./?act=logout" title="" >Về lớp học</a>&nbsp; | &nbsp; <a style="color:#ffffff" href="/h2472" title="" >Quay lại trang chủ H2472</a></span></h3>

				  <div class="modulecontent clearfix"><span class="errmsg">{newuser_msg}</span>

				    <!-- BEGIN A_DETAIL -->

						<div class="adetail">

							<div class="detail-left">

								<p>{A_DETAIL.picture}

							    <a href="/user/view.php?id={A_DETAIL.uid}" target="_blank"><strong>{A_DETAIL.author}</strong></a></p>

								<p><strong>{A_DETAIL.uname}</strong><br />

							  ({A_DETAIL.group})						        </p>

						  </div>

<div class="detail-right">

								<div class="detail-status">

									Nhóm câu hỏi : {A_DETAIL.topic}-- Môn học : <strong>                                    {A_DETAIL.cname}</strong><br />&nbsp; &nbsp; {A_DETAIL.link}{A_DETAIL.thread_edit}</div>

			    <div class="detail-title"><img src="./images/q.png" width="32" height="32" /> Câu hỏi số :{A_DETAIL.id} - {A_DETAIL.title}{A_DETAIL.edit}</div>

								<div class="detail-des">{A_DETAIL.answerdes}</div>

								{A_DETAIL.attach}

                                 

								<div style="color:#810C15; font-weight:bold; text-align:right;" >{A_DETAIL.time}</div>

                                <div >{A_DETAIL.assign}</div>

                               

								<div id="reply_button"  style="text-align:right">{A_DETAIL.reply} {A_DETAIL.forward}</div>

								

							  <div></div>

							</div>

                      </div>

						

						<div id="listreply">

						{totalreply}

						

						<div class="lreplay"  style="{A_DETAIL.lreplay}" >

							<div class="repley-left">

								{A_DETAIL.reply_picture}

								<a href="/user/view.php?id={A_DETAIL.repuid}" target="_blank"><strong>{A_DETAIL.reply_author}</strong></a>

								<br />

								<strong>{A_DETAIL.reply_name}</strong>

								<br>

								{A_DETAIL.reply_group}

							</div>

							<div class="repley-right">

								<div class="repley-des">{A_DETAIL.reply_replydes}{A_DETAIL.reply_edit}</div>

							  <p>{A_DETAIL.reply_attach}								</p>

								<!--<p>---------------------------------------------</p>-->

								<div style="color:#810C15; font-weight:bold; text-align:right; padding-right:10px;" >

								  <p><span class="repley-des"></span>{A_DETAIL.reply_time}   {A_DETAIL.reply_id} </p>

								  <p id="reply_ask" style="display:inline">{A_DETAIL.reply_ask}</p>

							  </div>

                                

							  <div class="repley-report"></div>

							</div>

						</div>

                       </div>

                       

                      <!-- END A_DETAIL -->

						

						{linkpage}

						

                        

                        

						

                       



				  

                        

                        <!-- Insert by vietth-->

                    

            

<div id="replyform" class="areply2" style=" display:none;">

               

							<form method="post" name="answers2" enctype="multipart/form-data">

							<table cellpadding="1" cellspacing="10">

								<tr>

									<td colspan="2"><span class="replyform">Trả lời câu hỏi</span></td>

								</tr>

								<tr>

									<td colspan="2">

									{editor2}

                                    <script type="text/javascript">

			//<![CDATA[



				CKEDITOR.replace( 'editor_kama',

					{

						skin : 'kama'

					});



			//]]>

			</script>



									</td>

								</tr>

								<tr>

									<td>File đình kèm: </td>

									<td><input type="file" name="attach" /></td>

								</tr>

								<tr>

									<td colspan="2"><input type="submit" name="addreply" value="Chấp nhận" onclick="ste.submit();" />                </td>

                                    

								</tr>

							</table>

							</form>

                        

					</div>

                            

                    




{thanks}
				
				
				<span class="detail-status">{close}{setkkt}</span></div>

			</div>
			<div align="left" class="answerother_user_thanks">
			{ds_thanks}
 				<!-- BEGIN U_ANWSER -->
					
					
					&nbsp;{U_ANWSER.username_thanks} ({U_ANWSER.date_thanks}),
			  		
						
                <!-- END U_ANWSER -->
            </div>

<div id="questionform" class="areply2" style=" display:none;">

               

							<form method="post" name="answers2" enctype="multipart/form-data">

							<table cellpadding="1" cellspacing="10">

								<tr>

									<td colspan="2"><span class="replyform">Thêm câu hỏi</span></td>

								</tr>

								<tr>

									<td colspan="2">

									{editor1}

                                     <script type="text/javascript">

			//<![CDATA[



				CKEDITOR.replace( 'editor_kama',

					{

						skin : 'kama'

					});



			//]]>

			</script>

									</td>

								</tr>

								<tr>

									<td>File đình kèm: </td>

									<td><input type="file" name="attach" /></td>

								</tr>

								<tr>

									<td colspan="2"><input type="submit" name="addquestion" value="Chấp nhận" onclick="ste.submit();" /></td>

								</tr>

							</table>

							</form>

                        

					</div>

            

               

            </div></div>

			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>

		</div>

   