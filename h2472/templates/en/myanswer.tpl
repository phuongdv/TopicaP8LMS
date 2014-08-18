		<div id="content">
			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
					<h3><span>Welcome <strong class="member">{user}</strong> to Answering System</span></h3>
					<div class="modulecontent clearfix">
						
						<table class="list" cellpadding="1" cellspacing="1" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Topics</th>
									<th>Rate</th>
									<th>Question Owner</th>
									<th>Time</th>
									<th>Delay</th>
									<th>Answerer</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<!-- BEGIN L_ANWSER -->
								<tr class="{L_ANWSER.tr_class}">
									<td>{L_ANWSER.stt}</td>
									<td><a href="./?act=answers&do=detail&id={L_ANWSER.id}" title="">{L_ANWSER.name}</a></td>
									<td>{L_ANWSER.rate}</td>
									<td>{L_ANWSER.author}</td>
									<td>{L_ANWSER.time}</td>
									<td>
										<div id="delay{L_ANWSER.id}"></div>
										{L_ANWSER.delay}
									</td>
									<td>{L_ANWSER.answer}</td>
									<td><strong>{L_ANWSER.status}</strong></td>
								</tr>
								<!-- END L_ANWSER -->
							</tbody>
						</table>
						{linkpage}

					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>