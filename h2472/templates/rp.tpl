		<script type="text/javascript">
			HTMLArea.init();
			HTMLArea.onload = initDocument;
		</script>
        <div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span>Chào mừng <strong class="member">{user}</strong></span></h3>
					<div class="modulecontent clearfix">						
						{newuser_msg}
						<div id="replayform" class="areply">
							<form method="post" name="answers" enctype="multipart/form-data">
							<table cellpadding="1" cellspacing="10">
								<tr>
									<td colspan="2"><span class="replyform">Trả lời</span></td>
								</tr>
								<tr>
									<td colspan="2">
										<!--<textarea id="editor" name="editor" rows="20" cols="75">{content}</textarea>-->
                                        
											<textarea cols="80" id="editor_kama" name="editor_kama" rows="10">{content}</textarea>
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
									<td colspan="2"><input type="submit" name="submit" value="Chấp nhận" onclick="ste.submit();" /></td>
								</tr>
							</table>
							</form>
						</div>
					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>