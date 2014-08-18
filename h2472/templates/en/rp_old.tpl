		<div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span>Welcome <strong class="member">{user}</strong> to Answering System</span></h3>
					<div class="modulecontent clearfix">						
						{newuser_msg}
						<div id="replayform" class="areply">
							<form method="post" name="answers" enctype="multipart/form-data">
							<table cellpadding="1" cellspacing="10">
								<tr>
									<td colspan="2"><span class="replyform">Answer</span></td>
								</tr>
								<tr>
									<td colspan="2">
										<textarea id="editor" name="editor" rows="8" cols="75">{content}</textarea>
										<script type="text/javascript">
										var ste = new SimpleTextEditor("editor", "ste");
										ste.init();
										HTMLArea.init();
	HTMLArea.onload = initDocument;
										</script>
									</td>
								</tr>
								<tr>
									<td>Attachments: </td>
									<td><input type="file" name="attach" /></td>
								</tr>
								<tr>
									<td colspan="2"><input type="submit" name="submit" value="Accept" onclick="ste.submit();" /></td>
								</tr>
							</table>
							</form>
						</div>
					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>