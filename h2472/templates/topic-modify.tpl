		<div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span>Chào mừng các bạn đến với hệ thống Answering</span></h3>
					<div class="modulecontent clearfix">
						<table cellpadding="1" cellspacing="10">
							<tr>
								<td><button onclick="location.href = './?act=topic'">Quay lại trang chủ đề</button></td>
							</tr>
						</table>
						<form method="post" name="topic">
						<table cellpadding="1" cellspacing="10">
							<!-- BEGIN NEWUSER_MSG -->
							<tr>
								<td colspan="2" class="errmsg">{NEWUSER_MSG.newuser_msg}</td>
							</tr>
							<!-- END NEWUSER_MSG -->
							<tr>
								<td>Tên chủ đề: </td>
								<td><input type="text" name="topicname" value="{topicname}" /></td>
							</tr>
							<tr>
								<td>Trạng thái: </td>
								<td>
									<select name="status">
										<option value="1"{statuson}>Kích hoạt</option>
										<option value="0"{statusoff}>Chế độ chờ</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Chấp nhận" name="submit" class="bnText" /></td>
							</tr>
						</table>
						</form>
					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>