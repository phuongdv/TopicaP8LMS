		<div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span>Welcome to Answering System</span></h3>
					<div class="modulecontent clearfix">

						<table cellpadding="1" cellspacing="10">
							<tr>
								<td><button onclick="location.href = './?act=topic&do=modify'"{disabled}>Create topic</button></td>
							</tr>
						</table>

						<table class="list" cellpadding="1" cellspacing="1">
							<thead>
								<tr>
									<th>ID</th>
									<th>Topic</th>
									<th>Status</th>
									{featuredtitle}
								</tr>
							</thead>
							<tbody>
								<!-- BEGIN TOPIC -->
								<tr>
									<td>{TOPIC.id}</td>
									<td>{TOPIC.name}</td>
									<td align="center">{TOPIC.status}</td>
									{TOPIC.featured}
								</tr>
								<!-- END TOPIC -->
							</tbody>
						</table>

					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>