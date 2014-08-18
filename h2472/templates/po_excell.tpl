<table class="list" cellpadding="1" cellspacing="1" width="100%" border="1">
<thead>
								<tr>
									<th>ID</th>
									<th>Chủ đề</th>
                                    <th>Khóa học</th>
								  <th>Người đặt câu hỏi</th>
									<th>Độ trễ</th>
									<th>Người trả lời</th>
									
									<th>Trạng thái</th>
								    
							    </tr>
		</thead>
							<tbody>
								<!-- BEGIN L_ANWSER -->
								<tr>
									<td>{L_ANWSER.id}</td>
									<td><a href="./?act=answers&do=detail&id={L_ANWSER.id}" title="">{L_ANWSER.name}</a></td>	
									<td>{L_ANWSER.cname}</td>
                                  <td nowrap="nowrap">{L_ANWSER.author}</td>
									<td style="white-space:nowrap;">
								  {L_ANWSER.delay}									</td>
									<td nowrap="nowrap">{L_ANWSER.answer}</td>
									
									<td nowrap="nowrap"><strong>{L_ANWSER.status}</strong></td>
								  							    </tr>
                              <!-- END L_ANWSER -->
						</tbody>
			</table>