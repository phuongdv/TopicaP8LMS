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
					<h3><span>Kỹ thuật viên <strong class="member">{user}</strong> <a href="./?act=logout" title="" style="padding-left:400px;">Quay về lớp học</a></span></h3>
				  <div class="modulecontent clearfix">

						<table cellpadding="1" cellspacing="10">
							<tr>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
						  </tr>
							<tr>
							  <td>Tìm theo
							  <td><select name="course" id="course" class="dropdown" style="width:150px">
										<option value="0">Tất cả các môn học</option>
										<!-- BEGIN SUBJECT -->
										<option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>
										<!-- END SUBJECT -->
									</select>   							  </td>
							  <td>Thời gian trễ</td>
							  <td><select name="delay" id="delay" class="dropdown" style="width:150px"
                                 
                                    >
                                <!-- BEGIN DELAY -->
                                <option value="0">Tất cả</option>
                                <option value="1" {DELAY.selected1}>0-24h</option>
                                <option value="2" {DELAY.selected2}>24h-48h</option>
                                <option value="3" {DELAY.selected3}>48h-72h</option>
                                <option value="4" {DELAY.selected4}> &gt; 72h</option>
                                <!-- END DELAY -->
                              </select></td>
						  </tr>
							<tr>
							  <td>Trạng thái 
							  <td>
                                
							      <select name="lstStatus" id="lstStatus" class="dropdown" style="width:150px">
                                    <!-- BEGIN STATUS -->
							        <option value="0">Tất cả các trạng thái</option>
							        <option value="1" {STATUS.select1}>Mới mở</option>
							        <option value="2" {STATUS.select2} >Chờ trả lời</option>
                                    <option value="5" {STATUS.select5}>Mới mở hoặc chờ trả lời</option>
							        <option value="3" {STATUS.select3}>Đã trả lời</option>
							        <option value="4" {STATUS.select4}>Đã đóng</option>
                                    <option value="6" {STATUS.select6}>Đã trả lời hoặc đã đóng</option>

                                    <!-- END STATUS -->
				                    </select>							  </td>
							  <td>Tìm theo từ</td>
							  <td>
							      <input type="text" name="txtFulltext" id="txtFulltext" style="width:145px" value="{searchtext}" />							  </td>
						  </tr>
							<tr>
							  <td>File đính kèm<td>
							    
							        <select name="select" id="lstAttach" class="dropdown" style="width:150px">
							          <option value="0">Tất cả</option>
                                      <!-- BEGIN FILEATTACH -->
							          <option value="1" {FILEATTACH.select1}>Có</option>
							          <option value="2" {FILEATTACH.select2}>Không</option>
                                       <!-- END FILEATTACH -->
						            </select>
						         
							  </td>
							  <td>Tìm theo cá nhân</td>
							  <td>
							    
							    <select name="do" id="do" class="dropdown" style="width:150px">
							      <option value="0" {selected_1}> Hiện tất cả các câu hỏi </option>
							      <option value="myanswer" {selected_2}>Hiện câu hỏi của tôi</option>
                                                                </select>						      						  </td>
						  </tr>
							<tr>
							  <td>                            
							  <td> <div align="right">
							    <input type="button" style="width:150px"  name="btnTim" id="btnTim" value="         Tìm kiếm        " onclick="window.open('?subject='+document.getElementById('course').value+'&gv='+document.getElementById('gv').value+'&topic='+document.getElementById('lstTopic').value+'&delay='+document.getElementById('delay').value+'&status='+document.getElementById('lstStatus').value+'&searchtext='+document.getElementById('txtFulltext').value+'&attach='+document.getElementById('lstAttach').value+'&do='+document.getElementById('do').value,'_self'); " />							  </td>
							 	
						      </td>
					      <td><input type="button"  style="width:120px" name="btnClear" id="btnClear" value="         Xem tất cả        " onclick="window.open('?','_self'); " />						  </tr>
						</table>

				    <table class="list" cellpadding="1" cellspacing="1" width="100%">
			  <thead>
								<tr>
									<th>ID</th>
									<th>Chủ đề</th>
                                    <th>Khóa học</th>
								  <th>Số câu hỏi</th>
									<th>Người đặt câu hỏi</th>
									<th>Thời gian</th>
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
						<div align="center" style=" display:{empty};"> Chưa có câu hỏi</div>
						
                     <br />
                        
                          <tr>
                            <td width="145" bgcolor="#CCCCCC">&nbsp;</td>
                            <td width="75" bgcolor="#CCCCCC">Chủ đề</td>
                            <td width="162" bgcolor="#CCCCCC">Câu hỏi</td>
                          </tr>
                          <tr>
                            <td>Sau lọc:</td>
                            <td>{total_filter}</td>
                            <td>{filter_question}</td>
                          </tr>
                          <tr>
                            <td bgcolor="#CCCCCC">Tổng</td>
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
