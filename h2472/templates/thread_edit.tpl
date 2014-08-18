		<script type="text/javascript" src="editor/ckeditor.js"></script>
	<script src="editor/sample.js" type="text/javascript"></script>
	<link href="editor/sample.css" rel="stylesheet" type="text/css" />
		
		
		<script type="text/javascript">
			HTMLArea.init();
			HTMLArea.onload = initDocument;
		</script>
        <div id="content" style="font-family:Arial, Helvetica, sans-serif">
          <div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
				<div class="module clearfix">
			
                    
					<div class="modulecontent clearfix">
                
					  <form method="post" name="answers" enctype="multipart/form-data">
						<table width="586" cellpadding="1" cellspacing="10" bgcolor="#CCCCCC">
							
							<tr>
								<td colspan="2" class="errmsg"></td>
							</tr>
							
							<tr>
								<td width="124">Tên chủ đề: </td>
								<td width="426"><input type="text" name="name" size="55" value="{name}" /></td>
							</tr>
							<tr>
								<td>Nhóm chủ đề: </td>
						  <td> <select name="lstTopic" id="lstTopic" class="dropdown" style="width:150px">
							        <option value="0">Tất cả các chủ đề</option>
                                    <!-- BEGIN LSTTOPIC -->
                                    <option value="{LSTTOPIC.id}" {LSTTOPIC.select}>{LSTTOPIC.name}</option>
                                    <!-- END LSTTOPIC -->
					            </select>					
														</td>
							</tr>
							<tr>
								<td>Khóa học: </td>
								<td><select name="course" id="course" class="dropdown" style="width:150px">
										<option value="0">Tất cả các môn học</option>
										<!-- BEGIN SUBJECT -->
										<option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>
										<!-- END SUBJECT -->
									</select>
																</td>
							</tr>
							<tr>
							  <td>Knowledgebase</td>
							  <td><label>
							    <select name="knb" id="knb">
							      <option value="1" {knb_selected1}>Có</option>
							      <option value="0" {knb_selected2}>Không</option>
						        </select>
							  </label></td>
						  </tr>
							<tr>
							<td>Ẩn</td>
								<td><label>
								  <select name="hidden" id="hidden">
								    <option value="1" {hdn_selected1}>Không</option>
								    <option value="0" {hdn_selected2}>Có</option>
							      </select>
								</label></td>	
						  </tr>
							
							<tr>
								<td colspan="2"><div align="center">
								  <input type="submit" name="submit" value="Chấp nhận" onclick="ste.submit();" />
							    </div></td>
							</tr>
						</table>
					  </form>
              
					</div>
				</div>
			</div></div></div>
			<div class="frame-bot"><div class="frame-bl">&nbsp;</div><div class="frame-br">&nbsp;</div></div>
		</div>