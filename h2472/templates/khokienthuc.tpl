

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>

<title>Trang thiết lập kho kiến thức - Knowledge base setting</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<link title="ATHK Style" href="assets/css/style.css" type="text/css" rel="stylesheet" />

<link title="ATHK Style" href="assets/css/calendar.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="assets/js/mootools.js"></script>



<script type="text/javascript" src="assets/js/search.js"></script>



<script language="JavaScript" src="assets/js/functions.js"></script>

<script type="text/javascript"src="assets/js/zxml.js"></script>



<script type="text/javascript"src="assets/js/modal.js"></script>

<link href="assets/css/modal.css" type="text/css" rel="stylesheet" />



<style type="text/css">

<!--

.bg_color1

        {

		background-color:#CCCCCC;

		}

.style1 {

	font-size: 9pt;

	font-weight: bold;

}

-->

</style>

   {refresh}

		<div id="content_knowledge">

			<div class="frame-top"><div class="frame-tl">&nbsp;</div><div class="frame-tr">&nbsp;</div></div>

			<div class="frame-mid"><div class="frame-ml"><div class="frame-mr">

				<div class="module clearfix">

					<h3><span style="float:left;color:#ffffff">Chào mừng  <strong class="member" style="color:#ffffff">{user}</strong></span><span style="float:right;color:#ffffff"> <a style="color:#ffffff" href="./?do=view_kkt" title="" >Kho kiến thức </a>&nbsp; | &nbsp;<a style="color:#ffffff" href="{linkportal}" title="" >Trang chủ topica </a> &nbsp; | &nbsp; <a style="color:#ffffff" href="{linkdiendan}" title="" >Diễn đàn </a>&nbsp; | &nbsp; <a style="color:#ffffff" href="./?act=logout" title="" >Quay về lớp học</a>&nbsp; | &nbsp; <a style="color: rgb(255, 255, 255);" href="./?" title="">Quay lại</a></span></h3>

					<div class="modulecontent clearfix">



						<table width="980" cellpadding="1" cellspacing="10">
							<tr>

							  <td>
								  <table width="268" border="0" cellpadding="0" cellspacing="0">
								  <tr>

									<td width="145" bgcolor="#CCCCCC">Tổng số Chủ đề:</td>

									<td width="75" bgcolor="#CCCCCC">{total} </td>

								  </tr>

								  <tr>
									<td>Số chủ đề trong kho kiến thức:</td>

									<td>{total_filter}</td>
								  </tr>
								</table>
							  Tìm theo

							  <td><label>

							    <select name="monhoc" id="monhoc">

							      <option value="0">Tất cả các môn học</option>

                                  <!-- BEGIN MONHOC -->

                                  <option value="{MONHOC.name}" {MONHOC.selected}>{MONHOC.name}</option>

                                  <!-- END MONHOC -->

						        </select>

							  </label></td>

						      <td width="685" rowspan="4" valign="top"><p class="style1">Kho Kiến Thức là nơi tập trung những câu hỏi-đáp hữu ích. Giúp sinh viên và giảng viên TOPICA tích lũy và sử dụng lại được kiến thức trong quá trình dạy-học.</p>

					          <p class="style1">Hiện nay, Kho Kiến Thức đang được cập nhật. Số lượng chủ đề sẽ tăng dần hàng ngày.</p></td>

						  </tr>

							<tr>

								<td width="138">

								<td width="336"><select name="course" id="course" style="width:250px;">

								  <option value="0">Tất cả các Lớp</option>

                                  <!-- BEGIN SUBJECT -->

                                  <option value="{SUBJECT.id}"{SUBJECT.selected}>{SUBJECT.name}</option>

                                  <!-- END SUBJECT -->

                                </select>

							  <label></label></td>

						    </tr>

							<tr>

							  <td>Tìm theo từ

							  <td><input type="text" name="txtFulltext" id="txtFulltext" style="width:245px" width="150" value="{searchtext}" /></td>

					      </tr>
<tr>

							  <td>Mã chủ đề (ID)

							  <td><input type="text" style="width:145px" name="thr_id" id="thr_id" value="{thr_id}" /></td>

					      </tr>
					      <tr>
					      <td>Tìm theo cá nhân</td>
							  <td>
							    
							    <select name="do_p" id="do_p" class="dropdown" style="width:150px">
							      <option value="0" {selected_1}> Hiện tất cả câu hỏi </option>
							      <option value="myanswer" {selected_2}>Hiện câu hỏi của tôi</option>
                                </select>						      						  </td>
						  </tr>
							<tr>

							  <td>

							  <td><input type="button" name="btnTim" style="" id="btnTim" value="      Tìm ngay      " onclick="window.open('?do=view_kkt&subject='+document.getElementById('course').value+'&searchtext='+document.getElementById('txtFulltext').value+'&monhoc='+document.getElementById('monhoc').value+'&do_p='+document.getElementById('do_p').value+'&thr_id='+document.getElementById('thr_id').value,'_self'); " />

						      <input type="button"  style="" name="btnClear" id="btnClear" value="     Xem tất cả     " onclick="window.open('?do=view_kkt','_self'); " /></td>

					      </tr>

						</table>

                      <form id="knowledge" method="post" action="">

					  <table class="list" cellpadding="1" cellspacing="1" width="100%">

			  <thead>

								<tr>

									<th>ID</th>

									<th>Chủ đề</th>

                                    <th>Khóa học</th>

								  <th>Số câu hỏi</th>

									<th>Người đặt câu hỏi</th>

									<th>Thời gian</th>

								  <th>Người trả lời</th>

							    </tr>

							</thead>

							<tbody>

								<!-- BEGIN L_ANWSER -->

								<tr  style="{L_ANWSER.tr_class}">

									<td>{L_ANWSER.id}</td>

									<td><a href="./?act=answers&do=detail&id={L_ANWSER.id}" title="">{L_ANWSER.name}</a></td>	

									<td>{L_ANWSER.cname}</td>

                                  <td>{L_ANWSER.rate}</td>

									<td nowrap="nowrap">{L_ANWSER.author}</td>

									<td nowrap="nowrap">{L_ANWSER.time}</td>

									<td nowrap="nowrap">{L_ANWSER.answer}</td>

							    </tr>

                                <!-- END L_ANWSER -->

							</tbody>

						</table>

                        

                      <div align="right" >{linkpage}</div>

						<div align="center" style=" display:{empty};"> Chưa có câu hỏi</div>

                     <br />

						<div align="right" style="margin-top:-20px"></div>

                      </form>

					    </p>

				  </div>

				</div>

			</div></div></div>

			<div class="frame-bot">

			  <div class="frame-bl"></div>

		  <div class="frame-br">&nbsp;</div></div>

		</div>

