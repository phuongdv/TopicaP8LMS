		<script type="text/javascript">
			HTMLArea.init();
			HTMLArea.onload = initDocument;
		</script><div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3>&nbsp;</h3>
                    
					<div class="modulecontent clearfix">
					  <form method="post" name="answers" enctype="multipart/form-data">
						<table cellpadding="1" cellspacing="10">
							<!-- BEGIN QUESTION -->
							<tr>
								<td colspan="2" class="errmsg">&nbsp;</td>
						  </tr>
						
							<tr>
								<td><strong>Question's name: </strong></td>
								<td>{QUESTION.name}</td>
						  </tr>
							<tr>
							  <td><strong>Question Owner:</strong></td>
							  <td>{QUESTION.author}</td>
						  </tr>
							<tr>
							  <td><strong>Delay:</strong></td>
							  <td>{QUESTION.delay}</td>
						  </tr>
							<tr>
								<td><strong>Question ID:</strong></td>
								<td>{QUESTION.id}</td>
						  </tr>
							<tr>
								<td><strong>Topic ID:</strong></td>
								<td>&nbsp;{QUESTION.thread}</td>
						  </tr>
							<tr>
							  <td><strong>Question's name: </strong></td>
							  <td>{QUESTION.name}</td>
						  </tr>
                            <tr>
                            <td colspan="2"><p><strong>Question content:</strong>{QUESTION.des}</p>
                              </td>
                            <td></td>
                            </tr>
                             <tr>
                            <td colspan="2"><p>{QUESTION.attach}</p>
                              </td>
                            <td></td>
                            </tr>
                                <tr>
                            {reply}
							<tr>
							<td style="display:{editor}" >Fast reply</td>
								<td>&nbsp;</td>	
						  </tr>
							{attact}
							<tr>
								<td colspan="2"><!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    <!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    	<!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    <!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    	<div style="display:{editor}"
									<!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    <!--<textarea id="editor" name="editor" rows="20" cols="75">{des}</textarea>-->
                                    	<textarea cols="80" id="editor_kama" name="editor_kama" rows="10">{noidung}</textarea>
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
								<td><div style="display:{editor}">Attachments: </div></td>
								<td><div style="display:{editor}"><input type="file" name="attach" /></td></tr></div></td>
							</tr>
							<tr>
								<td colspan="2">{action}</td>
							</tr>
						</table>
					  </form>
	<!-- END QUESTION -->
			  </div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>