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
<h3><span style="float:left;color:#ffffff;margin-top:8px;">Lãnh đạo trung tâm từ xa <strong class="member" style="color:#ffffff">{user}</strong></span><span style="float:right;color:#ffffff;margin-top:8px;"><a style="color:#ffffff" href="{linkforum}" title="" >Diễn đàn </a>&nbsp; | &nbsp; <a style="color:#ffffff" href="./?act=logout" title="" >Quay về lớp học</a></span></h3>
<div class="modulecontent clearfix">
<table cellpadding="1" cellspacing="10">
<tr>
<td width="98">&nbsp;</td>
<td width="169"><label>
</label></td>
<td width="120"></td>
<td width="296"></td>
 </tr>
<tr>
<td width="98"> 
Tìm theo
<td>
<select name="course" id="course" class="dropdown" style="width:150px">
<option value="0">Tất cả các môn học</option>
<!-- BEGIN SUBJECT -->
										<option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>
										<!-- END SUBJECT -->
									</select>
									<label></label></td>
								<td>Thời gian trễ</td>
						  <td><select name="delay" id="delay" class="dropdown" style="width:150px" >
                                <!-- BEGIN DELAY -->
                                <option value="0">Tất cả</option>
                                <option value="1" {DELAY.selected1}>0-24h</option>
                                <option value="2" {DELAY.selected2}>24h-48h</option>
                                <option value="3" {DELAY.selected3}>48h-72h</option>
                                <option value="4" {DELAY.selected4}> &gt; 72h</option>
                                <!-- END DELAY -->
                              </select>	</td>							</tr>
							<tr>
							  <td>Chủ đề                           
							  <td>
							      <select name="lstTopic" id="lstTopic" class="dropdown" style="width:150px">
							        <option value="0">Tất cả các chủ đề</option>
                                    <!-- BEGIN LSTTOPIC -->
                                    <option value="{LSTTOPIC.id}" {LSTTOPIC.select}>{LSTTOPIC.name}</option>
                                    <!-- END LSTTOPIC -->
					            </select>							  </td>
							  <td>Tìm theo từ</td>
							  <td><input type="text" name="txtFulltext" id="txtFulltext" style="width:145px"  value="{searchtext}" /></td>
						  </tr>
							<tr>
							  <td>Trạng thái 
							  <td><select name="lstStatus" id="lstStatus" class="dropdown" style="width:150px">
                                <!-- BEGIN STATUS -->
                                <option value="0">Tất cả các trạng thái</option>
							        <option value="1" {STATUS.select1}>Mới mở</option>
							        <option value="2" {STATUS.select2} >Chờ trả lời</option>
                                    <option value="5" {STATUS.select5}>Mới mở hoặc chờ trả lời</option>
							        <option value="3" {STATUS.select3}>Đã trả lời</option>
							        <option value="4" {STATUS.select4}>Đã đóng</option>
                                    <option value="6" {STATUS.select6}>Đã trả lời hoặc đã đóng</option>
                                <!-- END STATUS -->
                                                            </select></td>
							  <td>Mã chủ đề(ID)</td>
						    <td><input type="text" style="width:145px" name="thr_id" id="thr_id" value="{thr_id}" />
   							  </td>
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
							      <option value="0" {selected_1}> Hiện tất cả câu hỏi </option>
							      <option value="myanswer" {selected_2}>Hiện câu hỏi của tôi</option>
                                </select>						      						  </td>
						  </tr>
							<tr>
							  <td colspan="2">                            
							    <div align="left">
                               
                               <script type="text/javascript">
							   function get_radio_value()
								{
								for (var i=0; i < document.myanswer.length; i++)
								   {
								   if (document.myanswer[i].checked)
									  {
									  var rad_val = document.myanswer.value;
									  }
								   }
								 return rad_val;
								}
        
    						   </script> 
                              
							    <input type="button"  style="width:250px" name="btnTim" id="btnTim" value="         Tìm kiếm(lọc)        " onclick="window.open('?subject='+document.getElementById('course').value+'&topic='+document.getElementById('lstTopic').value+'&delay='+document.getElementById('delay').value+'&status='+document.getElementById('lstStatus').value+'&searchtext='+document.getElementById('txtFulltext').value+'&attach='+document.getElementById('lstAttach').value+'&do='+document.getElementById('do').value+'&thr_id='+document.getElementById('thr_id').value,'_self'); " />
						        </div>
							  <td><div align="right">
							    <input type="button" name="btnClear" style="width:120px" id="btnClear" value="     Xem tất cả    " onclick="window.open('?','_self'); "  />	
						      </div>							     </td>
                              <td style="padding-right:50px;"></td>
						  </tr>
			</table> 
         
<div style="float:right;margin-top:-160px" >
                        <table class="list" width="200" border="0" cellpadding="1" cellspacing="1">
                          <thead>
                          <tr>
                            <th colspan="2" >&nbsp;</td>
                            <th width="50" >Chủ đề</td>
                            <th width="50" >Câu hỏi</td>
                          </tr>
                          </thead>
                          <tbody>
                       
                          <tr>
                           
                            <td colspan="2" width="110">Chưa trả lời</td>
                            <td style="color:#CC0000; font-weight:bold"><a href="?subject=0&topic=0&delay=0&status=5&searchtext=&attach=0&do=0&thr_id="><span>{thr_norep}</span></a> <img height="10px" src="1vang.png" />&nbsp;<img height="10px" width="2px" src="1xanh.png" /></td>
                            <td style="color:#CC0000; font-weight:bold">{qs_norep}</td>
                          </tr>
                          <tr>
                            
                            <td colspan="2">Đã trả lời</td>
                            <td><a href=" " title="Đã trả lời">{datraloi}</a> &nbsp;<img height="10px" src="1do.png" />&nbsp;<img height="10px" width="2px" src="1luc.png" /> </td>
                            <td>{qs_repl}</td>
                          </tr>
                          <tr>
                            <td colspan="2">Sau lọc:</td>
                            <td >{total_filter}</td>
                            <td>{filter_question}</td>
                          </tr>
                          <tr>
                            <td colspan="2" >Tổng</td>
                            <td >{total}</td>
                            <td >{total_question}</td>
                          </tr>
                          </tbody>
                        </table>
						
          </div>
		      <div align="right">{pagingnation}</div></a>
		    <table class="list" cellpadding="1" cellspacing="1" width="100%">
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
            <div align="right" >{pagingnation}</div>
						<div align="center" style=" display:{empty};"> Chưa có câu hỏi</div>
						
                     <br />
                       
                          <tr>
                            <td width="145" bgcolor="#CCCCCC">&nbsp;</td>
                          </tr>
                          <p>&nbsp;</p>
					  
					    </p>
				  </div>
				</div>
			</div></div></div>
			<div class="module clearfix">
			 <h3><span style="float:left;color:#ffffff;margin-top:8px;">Lãnh đạo trung tâm từ xa <strong class="member" style="color:#ffffff">{user}</strong></span><span style="float:right;color:#ffffff;margin-top:8px;"><a style="color:#ffffff" href="{linkforum}" title="" >Diễn đàn </a>&nbsp; | &nbsp; <a style="color:#ffffff" href="./?act=logout" title="" >Quay về lớp học</a></span></h3>
		</div>