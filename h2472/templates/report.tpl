<style type="text/css">
<!--
.style2 {
font-family: Arial, Helvetica, sans-serif;
font-size: 10pt;
}


-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{


  if (form.startdate.value == '') {
    alert( "Xin vui lòng chọn thời gian bắt đầu" );
    return false ;
  }
  if (form.enddate.value == '') {
    alert( "Xin vui lòng chọn thời gian kết thúc" );
    return false ;
  }
 

  return true ;
}
-->
</script>


  <script src="assets/js/datetimepicker_css.js"></script>
<div id="content">
<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>
<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">
<div class="module clearfix">
<h3><span style="float:left;color:#ffffff;margin-top:8px;">Xin chào <strong class="member" style="color:#ffffff">{user}</strong></span><span style="float:right;color:#ffffff;margin-top:8px;"><a style="color:#ffffff" href="./?do=view_kkt" title="" >Kho kiến thức </a>&nbsp; | &nbsp;<a style="color:#ffffff" href="{linkportal}" title="" >Trang chủ TOPICA </a> &nbsp; | &nbsp; <a style="color:#ffffff" href="{linkforum}" title="" >Diễn đàn </a>&nbsp; | &nbsp; <a style="color:#ffffff" href="./?act=logout" title="" >Quay về lớp học</a></span></h3>
<div class="modulecontent clearfix">
<form id="form1" name="form1" method="post" action="" onsubmit=" return checkform(this)">
<table cellpadding="1" cellspacing="10">
<tr>
  <td width="98"> 
    Ngày bắt đầu<td width="169"><label>
      <input type="text" name="startdate" id="startdate" value="{startdate}" />
    </label><img src="images/cal.gif" onClick="javascript:NewCssCal('startdate','yyyyMMdd','arrow')" style="cursor:pointer"/></td>
  <td width="121">Ngày kết thúc</td>
  <td width="296"><label>
    <input type="text" name="enddate" id="enddate" value="{enddate}"/>
  </label><img src="images/cal.gif" onClick="javascript:NewCssCal('enddate','yyyyMMdd','arrow')" style="cursor:pointer"/></td>							</tr>
							<tr>
							  <td>Môn</td>
                              <td>
							   <select name="course" id="course" class="dropdown" style="width:150px">
<option value="0">Tất cả các môn học</option>
<!-- BEGIN SUBJECT -->
										<option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>
										<!-- END SUBJECT -->
									</select>
									<label></label></td>
								<td>POVH</td>
						  <td><select name="po" id="po" class="dropdown" style="width:150px">
				          <option value="0">Tất cả các PO</option>
						      <!-- BEGIN PO -->
						      <option value="{PO.id}"{PO.selected}>{PO.name}</option>
						      <!-- END PO -->
					        </select></td>
							  <td>&nbsp;</td>
						  </tr>
							<tr>
							  <td>CVHT</td>
						      <td><select name="cvht" id="cvht" class="dropdown" style="width:150px">
                                  <option value="0">Tất cả các CVHT</option>
                                  <!-- BEGIN CVHT -->
										<option value="{CVHT.id}"{CVHT.selected}>{CVHT.name}</option>
								  <!-- END CVHT -->
									</select>
                               </td>
							  <td>GV</td>
						    <td>
                            <select name="gv" id="gvt" class="dropdown" style="width:150px">
                                  <option value="0">Tất cả các GV</option>
                                  <!-- BEGIN GV -->
										<option value="{GV.id}"{GV.selected}>{GV.name}</option>
								  <!-- END GV -->
									</select>
                            </td>
						  </tr>
							<tr>
							  <td colspan="2">                            
							    <div align="left">
                                   <input type="submit"  style="width:250px" name="btnTim" id="btnTim" value="         Tìm kiếm(lọc)        " />
						        </div>
							  <td><div align="right">
							    <input type="button" name="btnClear" style="width:120px" id="btnClear" value="     Xem tất cả    " onclick="window.open('?','_self'); "  />	
						      </div>							     </td>
                              <td style="padding-right:50px;">&nbsp;</td>
						  </tr>
			</table> 
            </form>
          <div align="right">{linkpage}</div>

	      <table border="1" class="list" cellpadding="0" cellspacing="0" width="100%">
<thead>
								<tr>
									<th width="1%" rowspan="2">Stt</th>
									<th width="9%" rowspan="2">Mã môn</th>
                                    <th width="14%" rowspan="2">Tên môn</th>
								  <th width="11%" rowspan="2">Tổng số câu hỏi</th>
									<th height="22" colspan="5">Trả lời đúng hạn</th>
									<th colspan="5">Trả lời quá hạn</th>
									
									<th colspan="5">Chưa trả lời</th>
							    </tr>
								<tr>
								  <th width="6%" height="23">CVHT</th>
								  <th width="6%">PO</th>
								  <th width="4%">GV</th>
								  <th width="5%">Khác</th>
								  <th width="5%">Tổng</th>
								  <th width="5%">CVHT</th>
								  <th width="4%">PO</th>
								  <th width="4%">GV</th>
								  <th width="5%">Khác</th>
								  <th width="5%">Tổng</th>
								  <th width="6%">0-24</th>
								  <th width="7%">24-48</th>
								  <th width="6%">48-72</th>
								  <th width="7%">&gt;72</th>
								  <th width="7%">Tổng</th>
              </tr>
		</thead>
							<tbody>
								<!-- BEGIN DATA -->
								<tr>
									<td>{DATA.stt}</td>
									<td>{DATA.mamon}</td>
									<td>{DATA.tenmon}</td>
									<td><div align="center">{DATA.tongsocauhoi}</div></td>
									<td><div align="center">{DATA.cvhtdunghan}</div></td>
									<td><div align="center">{DATA.podunghan}</div></td>
									<td><div align="center">{DATA.gvdunghan}</div></td>
									<td><div align="center">{DATA.dunghankhac}</div></td>
									<td><div align="center">{DATA.traloidunghan}</div></td>
									<td><div align="center">{DATA.cvhtquahan}</div></td>
									<td><div align="center">{DATA.poquahan}</div></td>
									<td><div align="center">{DATA.gvquahan}</div></td>
									<td><div align="center">{DATA.quahankhac}</div></td>
									<td><div align="center">{DATA.quahan}</div></td>
									<td><div align="center">{DATA.tre024}</div></td>
									<td><div align="center">{DATA.tre2448}</div></td>
									<td><div align="center">{DATA.tre4872}</div></td>
									<td><div align="center">{DATA.tre72}</div></td>
								  <td><div align="center">{DATA.chuatraloi}</div></td>
							    </tr>
                            

                             <!-- END DATA -->
                             <tr>
									<td colspan="3"><div align="center"><strong>Tổng</strong></div></td>
									<td><div align="center">{tongsocauhoi}</div></td>
									<td><div align="center">{cvhtdunghan}</div></td>
									<td><div align="center">{podunghan}</div></td>
									<td><div align="center">{gvdunghan}</div></td>
									<td><div align="center">{dunghankhac}</div></td>
									<td><div align="center">{traloidunghan}</div></td>
									<td><div align="center">{cvhtquahan}</div></td>
									<td><div align="center">{poquahan}</div></td>
									<td><div align="center">{gvquahan}</div></td>
									<td><div align="center">{quahankhac}</div></td>
									<td><div align="center">{quahan}</div></td>
									<td><div align="center">{tre024}</div></td>
									<td><div align="center">{tre2448}</div></td>
									<td><div align="center">{tre4872}</div></td>
									<td><div align="center">{tre72}</div></td>
								  <td><div align="center">{chuatraloi}</div></td>
							    </tr>
						</tbody>
		  </table>
<div align="right" >{linkpage}</div>
						
						
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
			  <h3><span style="float:left;color:#ffffff;margin-top:8px;">ADMIN: <strong class="member" style="color:#ffffff">{user}</strong></span><span style="float:right;color:#ffffff;margin-top:8px;"><a style="color:#ffffff" href="./?do=view_kkt" title="" >Kho kiến thức </a>&nbsp; | &nbsp;<a style="color:#ffffff" href="{linkportal}" title="" >Trang chủ topica </a> &nbsp; | &nbsp; <a style="color:#ffffff" href="{linkforum}" title="" >Diễn đàn </a>&nbsp; | &nbsp; <a style="color:#ffffff" href="./?act=logout" title="" >Quay về lớp học</a></span></h3>
		</div>