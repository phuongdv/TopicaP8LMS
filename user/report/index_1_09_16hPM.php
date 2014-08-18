<?php 
include('lang/report.php');



               if(!isset($_REQUEST['nganh']))
			   {
			   	$nganh="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $nganh=$_REQUEST['nganh'];

               //-------------------------------
			   
			   if(!isset($_REQUEST['lop']))
			   {
			   	$lop="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $lop=$_REQUEST['lop'];
               //----------------------------
                if(!isset($_REQUEST['nhom']))
			   {
			   	$nhom="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $nhom=$_REQUEST['nhom'];
               //--------------------------
                if(!isset($_REQUEST['chucdanh']))
			   {
			   	$chucdanh="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $chucdanh=$_REQUEST['chucdanh'];
			   //------------------------------
			   if(!isset($_REQUEST['chucvu']))
			   {
			   	$chucvu="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $chucvu=$_REQUEST['chucvu'];
			   //--------------------------------
			   if(!isset($_REQUEST['chucvutrongnhom']))
			   {
			   	$chucvutrongnhom="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $chucvutrongnhom=$_REQUEST['chucvutrongnhom'];
			   //----------------------------------------
			   if(!isset($_REQUEST['candidate']))
			   {
			   	$candidate="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $candidate=$_REQUEST['candidate'];
			   //----------------------------------
			    if(!isset($_REQUEST['trangthai']))
			   {
			   	$trangthai="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $trangthai=$_REQUEST['trangthai'];
			   //------------------------------
			   if(!isset($_REQUEST['username']))
			   {
			   	$username="";//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $username=$_REQUEST['username'];
			   

$total=0;
$numPages=0;

           


         
			if(!isset($_GET['page'])|| $_GET['page']=='')
			{
			$page=1;//default		
			}
			else 
			{	
			$page=$_GET['page']	;	
			}
			if(!isset($_GET['limit'])|| $_GET['limit']=='')
			{
			   if(!isset($_REQUEST['limit']))
			   {
			   	$limit=1000;//dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨ault
			   }
			   else 
			   $limit=$_REQUEST['limit'];
				
			}
			else 
			{	
			$limit=$_GET['limit']	;	
			}
function connect_db()
{
	
$database='localhost';
$username='crc';
$password='crc145';
$dbname='crc_data2';
$con= mysql_connect($database,$username,$password);
mysql_query("SET character_set_results=utf8", $con);
mb_language('uni');
mb_internal_encoding('UTF-8');
mysql_query("set names 'utf8'",$con);
	
	if (!$con)
  	{
  		die('Loi Ket Noi: ' . mysql_error());
 	 }
    mysql_select_db("$dbname",$con);

	
}

function get_selectdata($colum,$selected)
{
	
	
	
	
	$sql="SELECT DISTINCT
		u.$colum
		FROM
		mdl_user u
		WHERE u.$colum!=''
		";
	$result = mysql_query($sql);
	
  
	while($row = mysql_fetch_array($result))
					{
					if ($row[$colum]==$selected)
					{
						echo"<option value=\"$row[$colum]\" selected=\"selected\">$row[$colum]</option>";
					}
					else
					echo"<option value=\"$row[$colum]\">$row[$colum]</option>";	
					}
	
}





function get_user_data($nganh_qry,
	    $lop_qry,
	    $nhom_qry,
	    $chucdanh_qry,
	    $chucvutronglop_qry,
	    $chucvutrongnhom_qry,
	    $candidate_qry,
	    $status_qry,
	    $username_qry,
	    $page,
	    $limit)
{
	
	
	
	$str_nganh[chua_xac_dinh]='Ch&#432;a x&#225;c &#273;&#7883;nh';
	$str_nganh[TCNH]='T&#224;i ch&#237;nh ng&#226;n h&#224;ng';
	$str_nganh[QTKD]='Qu&#7843;n tr&#7883; kinh doanh';
	$str_nganh[KT]='K&#7871; to&#225;n';
	$str_nganh[CNTT]='Tin h&#7885;c';
	
	$str_chucdanh[Nhan_Vien]='Nh&#226;n vi&#234;n';
	$str_chucdanh[Chuyen_Vien]='Chuy&#234;n vi&#234;n';
	$str_chucdanh[Truong_Nhom]='Tr&#432;&#7903;ng nh&#243;m';
	$str_chucdanh[Pho_Phong]='Ph&#243; ph&#242;ng';
	$str_chucdanh[Truong_Phong]='Tr&#432;&#7903;ng ph&#242;ng';
	$str_chucdanh[Pho_Giam_Doc]='Ph&#243; gi&#225;m &#273;&#7889;c';
	$str_chucdanh[Giam_Doc]='Gi&#225;m &#273;&#7889;c';
	$str_chucdanh[Chuc_danh_khac]='Ch&#7913;c danh kh&#225;c';
	$str_chucdanh[Chua_di_lam]='Ch&#432;a &#273;i l&#224;m';
	
	$str_nhom[chua_xac_dinh]='Ch&#432;a ph&#226;n nh&#243;m';
	$str_nhom[N1]='Nh&#243;m 1';
	$str_nhom[N2]='Nh&#243;m 2';
	$str_nhom[N3]='Nh&#243;m 3';
	$str_nhom[N4]='Nh&#243;m 4';
	$str_nhom[N5]='Nh&#243;m 5';
	
	$str_chucvutronglop[Thanh_vien]='Th&#224;nh vi&#234;n';
	$str_chucvutronglop[Lop_pho]='L&#7899;p ph&#243;';
	$str_chucvutronglop[Lop_Truong]='L&#7899;p tr&#432;&#7903;ng';
	
	$str_chucvutrongnhom[Thanh_Vien]='Th&#224;nh vi&#234;n';
	$str_chucvutrongnhom[Nhom_Pho]='Nh&#243;m ph&#243;';
	$str_chucvutrongnhom[Nhom_Truong]='Nh&#243;m tr&#432;&#7903;ng';
	
	$str_trinhdo[Tot_nghiep_THPT]='T&#7889;t nghi&#7879;p THPT';
	$str_trinhdo[Trung_Cap]='Trung c&#7845;p';
	$str_trinhdo[Cao_Dang]='Cao &#273;&#7859;ng';
	$str_trinhdo[Dai_Hoc]='&#272;&#7841;i h&#7885;c';
	
	$str_doituong[Tot_nghiep_THPT]='T&#7889;t nghi&#7879;p THPT &#273;&#227; &#273;i l&#224;m';
	$str_doituong[Trung_Cap_lien_thong]='Trung c&#7845;p li&#234;n th&#244;ng';
	$str_doituong[Cao_Dang_lien_thong]='Cao &#273;&#7859;ng li&#234;n th&#244;ng';
	$str_doituong[Dai_hoc_VB2]='V&#259;n b&#7857;ng 2';
	$str_doituong[Cac_Ctr_Diploma]='C&#225;c ch&#432;&#417;ng tr&#236;nh DIPLOMA';
	
	$str_trangthai[Binh_Thuong]='<img border=2px src="report/images/binh_thuong.jpg" title="B&#236;nh th&#432;&#7901;ng"';
	$str_trangthai[Hang_Hai]='<img border=2px src="report/images/hang_hai.jpg" title="H&#259;ng h&#225;i"';
	$str_trangthai[Bao_Dong]='<img border=2px src="report/images/bao_dong.jpg"title="B&#225;o &#273;&#7897;ng"';
	
	$str_candidate[Candicate_Y]='Yes';
	$str_candidate[Candicate_N]='No';
	// count
	
	$sql_count="SELECT
	    u.id,
		u.username,
		u.firstname,
		u.lastname,
		u.topica_lop,
		u.topica_nganh,
		u.topica_nhom,
		u.topica_coquan,
		u.topica_chucdanh,
		u.topica_chucvutronglop,
		u.topica_chucvutrongnhom,
		u.topica_candidate,
		u.topica_trinhdo,
		u.topica_doituongtuyensinh,
		u.topica_status,
		u.topica_ghichu
		FROM
		mdl_user u
		WHERE
		u.username!='admin'
		AND
		u.username!='guest'
		$nganh_qry
	    $lop_qry
	    $nhom_qry
	    $chucdanh_qry
	    $chucvutronglop_qry
	    $chucvutrongnhom_qry
	    $candidate_qry
	    $status_qry
	    $username_qry
		";
	
	global $total,$numPages,$limit,$page;
	$tt = mysql_query($sql_count);
	
    $total = mysql_num_rows($tt);
    
    $numPages = ceil($total / $limit);
    $offset = ($page - 1) * $limit;
	
	
	
	
	
	//- ----------------------
	$sql="SELECT
	    u.id,
		u.username,
		u.firstname,
		u.lastname,
		u.topica_lop,
		u.topica_nganh,
		u.topica_nhom,
		u.topica_coquan,
		u.topica_chucdanh,
		u.topica_chucvutronglop,
		u.topica_chucvutrongnhom,
		u.topica_candidate,
		u.topica_trinhdo,
		u.topica_doituongtuyensinh,
		u.topica_status,
		u.topica_ghichu
		FROM
		mdl_user u
		WHERE
		u.username!='admin'
		AND
		u.username!='guest'
		$nganh_qry
	    $lop_qry
	    $nhom_qry
	    $chucdanh_qry
	    $chucvutronglop_qry
	    $chucvutrongnhom_qry
	    $candidate_qry
	    $status_qry
	    $username_qry
		limit $offset,$limit
		";
	
//	echo"$sql";

	
	$result = mysql_query($sql);
	
    $tr=$offset;
	while($row = mysql_fetch_array($result))
					{   $nganh=$row[topica_nganh];
					    $chucdanh=$row[topica_chucdanh];
					    $nhom=$row[topica_nhom];
					    $chucvutronglop=$row[topica_chucvutronglop];
					    $chucvutrongnhom=$row[topica_chucvutrongnhom];
					    $trinhdo=$row[topica_trinhdo];
					    $doituong=$row[topica_doituongtuyensinh];
					    $trangthai=$row[topica_status];
					    $candidate=$row[topica_candidate];
						$scm_bs64=$row[username];
					    $user_b64= base64_encode($scm_bs64);
						$tr ++;
						if($even=$tr%2)
						{
						echo" <tr  bgcolor=\"#FFFFFF\"  id=\"tabletd\" class=\"tablecontent\"style=\"font-size:9pt\">
						        <td > $tr</td>
						        <td>&nbsp;$row[lastname]</td>
						        <td>&nbsp;$row[firstname]</td>
						        <td><a href=\"http://210.245.9.197/SCMSWebPortal/StudentProfiles.aspx?tab=lylich&idhv=$user_b64&idcvht=aG9pdHQ=\" target=\"_blank\" >$row[username]</a></td>
							    <td>$row[topica_lop]</td>
						        <td>$str_nganh[$nganh]</td>
							    <td>$str_nhom[$nhom]</td>
							    <td>$row[topica_coquan]</td>
							    <td>$str_chucdanh[$chucdanh]</td>
							    <td>$str_chucvutronglop[$chucvutronglop]</td>
							    <td>$str_chucvutrongnhom[$chucvutrongnhom]</td>
							    <td align=\"center\" >$str_candidate[$candidate]</td>
							    <td>$str_trinhdo[$trinhdo]</td>
							    <td>$str_doituong[$doituong]</td>
							    <td align=\"center\" >$str_trangthai[$trangthai]</td>
								<td><a href=\"edit_infor.php?id=$row[id]\"><img  src=\"report/images/b_edit.gif\" title=\"S&#7917;a\"></img></a></td>
						      </tr>
						";
						}
						else 
						{
							
							echo" <tr bgcolor=\"#FFFFFF\" id=\"tabletd2\" class=\"tablecontent\" style=\"font-size:9pt\" >
						        <td > $tr</td>
						        <td>&nbsp;$row[lastname]</td>
						        <td>&nbsp;$row[firstname]</td>
						        <td><a href=\"http://210.245.9.197/SCMSWebPortal/StudentProfiles.aspx?tab=lylich&idhv=$user_b64&idcvht=aG9pdHQ=\" target=\"_blank\" >$row[username]</a></td>
							    <td>$row[topica_lop]</td>
						        <td>$str_nganh[$nganh]</td>
							    <td>$str_nhom[$nhom]</td>
							    <td>$row[topica_coquan]</td>
							    <td>$str_chucdanh[$chucdanh]</td>
							    <td>$str_chucvutronglop[$chucvutronglop]</td>
							    <td>$str_chucvutrongnhom[$chucvutrongnhom]</td>
							    <td align=\"center\">$str_candidate[$candidate]</td>
							    <td>$str_trinhdo[$trinhdo]</td>
							    <td>$str_doituong[$doituong]</td>
							    <td align=\"center\" >$str_trangthai[$trangthai]</td>
								<td><a href=\"edit_infor.php?id=$row[id]\"><img  src=\"report/images/b_edit.gif\" title=\"S&#7917;a\"></img></a></td>
						      </tr>
						";
							
							
						}
					}
                  

}

connect_db();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPORT V1</title>

<link href="report/images/style.css" rel="stylesheet" type="text/css" />
<script src="report/js/sorttable.js">
</script>
<script src="report/js/function.js">
</script>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; ">
<div class="navbar clearfix">
        <div class="breadcrumb"><h2 class="accesshide ">B?n ?ang ? ?y</h2> <ul>
<li class="first"><a href="http://www.topica.vn/elearning/" onclick="this.target='_top'">TOPICA</a></li><li class="first"> <span></span><span class="arrow sep">-</span>DANH S&#193;CH H&#7884;C VI&#202;N</li></ul></div>
       
</div>
<!-- form lÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½c -->
<fieldset>
<form id="form1" name="form1" method="post" action="danhsachlop.php" >
  <table width="100%"  cellpadding="0" cellspacing="0" style="border:solid 1px #840C10; font-family:Tahoma, Geneva, sans-serif; font-size:12px;" bgcolor="#F0F0F0" >
    <tr height="30">
      <td width="26%"  align="right" ><?echo $string['nganh']?>
        <label>
      <select name="nganh" id="nganh">
        <option value=""><?echo $string['tatca'];?></option>
        <option value="QTKD">Qu&#7843;n tr&#7883; kinh doanh</option>
        <option value="KT">K&#7871; to&#225;n</option>
        <option value="CNTT">Tin h&#7885;c</option>
        <option value="TCNH">T&#224;i ch&#237;nh ng&#226;n h&#224;ng</option>
        <option value="chua_xac_dinh">Ch&#432;a x&#225;c &#273;&#7883;nh</option>
        
        <?// get_selectdata("topica_nganh",$nganh); ?>
      </select>
      </label>      </td>
      <td width="36%" align="right" ><?echo $string['chucdanh']?> 
        <label>
        <select name="chucdanh" id="chucdanh">
          <option value=""><?echo $string['tatca'];?></option>
          <option value="Nhan_Vien">Nh&#226;n vi&#234;n</option>
          <option value="Pho_Giam_Doc">Ph&#243; gi&#225;m &#273;&#7889;c</option>
          <option value="Truong_Phong">Tr&#432;&#7903;ng ph&#242;ng</option>
          <option value="Chua_di_lam">Ch&#432;a &#273;i l&#224;m</option>
          <option value="Chuyen_Vien">Chuy&#234;n vi&#234;n</option>
          <option value="Chuc_danh_khac">Ch&#7913;c danh kh&#225;c</option>
           <? //get_selectdata("topica_chucdanh",$chucdanh); ?>
        </select>
      </label></td>
      <td width="38%" align="right" style="padding-right:10px">Candidate 
        <label>
        <select name=" candidate" id=" candidate">
          <option value=""><?echo $string['tatca'];?></option>
           <?//get_selectdata("topica_candidate",$candidate); ?>
           <option value="Candicate_Y">Yes</option>
           <option value="Candicate_N">No</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right"><? echo $string['lop']?>
        <input type="text" name="lop" id="lop" value="<?echo $lop;?>" />
      </label></td>
      <td align="right"><? echo $string['chucvutronglop']?>
        <label>
        <select name="chucvu" id="chucvu">
          <option value=""><?echo $string['tatca'];?></option>
          <option value="Thanh_vien">Th&#224;nh vi&#234;n</option>
          <option value="Lop_pho">L&#7899;p ph&#243;</option>
          <option value="Lop_Truong">L&#7899;p tr&#432;&#7903;ng</option>
           <? //get_selectdata("topica_chucvutronglop",$chucvu); ?>
                                </select>
      </label></td>
      <td align="right" style="padding-right:10px"><? echo $string['trangthai']?>
        <label>
        <select name="trangthai" id="trangthai">
          <option value=""><?echo $string['tatca'];?></option>
          <option value="Hang_Hai">H&#259;ng h&#225;i</option>
          <option value="Binh_Thuong">B&#236;nh th&#432;&#7901;ng</option>
          <option value="Bao_Dong">B&#225;o &#273;&#7897;ng</option>
           <? //get_selectdata("topica_status",$trangthai); ?>
                </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" ><?echo $string['nhom']?>
        <label>
        <select name="nhom" id="nhom">
          <option value=""><?echo $string['tatca'];?></option>
          <option value="N1">1</option>
          <option value="N2">2</option>
          <option value="N3">3</option>
           <option value="N4">4</option>
          <option value="N5">5</option>
          <option value="chua_xac_dinh">Ch&#432;a ph&#226;n nh&#243;m</option>
           <? //get_selectdata("topica_nhom",$nhom); ?>
        </select>
      </label>
      <!-- Lá»›p
        <label>
        <select name="lop" id="lop">
          <option value="">-----Táº¥t cáº£-----</option>
           <? //get_selectdata("topica_lop",$lop); ?>
                </select>
        </label></td>
       -->
      </td>
      <td align="right" ><? echo $string['chucvutrongnhom']?>
        <label>
        <select name="chucvutrongnhom" id="chucvutrongnhom">
          <option value=""><? echo $string['tatca'] ?></option>
          
           <? //get_selectdata("topica_chucvutrongnhom"); ?>
           
           
           <option value="Nhom_Vien">Nh&#243;m vi&#234;n</option>
           <option value="Nhom_Pho">Nh&#243;m ph&#243;</option>
           <option value="Nhom_Truong">Nh&#243;m tr&#432;&#7903;ng</option>
        </select>
      </label></td>
      <td align="right" style="padding-right:10px"><label><? echo $string['timkiem']?>
        <input type="text" name="username" id="username" value="<?echo $username;?>" />
      </label></td>
    </tr>
    <tr>
      <td align="right"></td>
      <td>
      
      
      </td>
      <td></td>
    </tr>
    <tr>
      <td style="padding-left:10px;"><? echo $string['hien'] ?><select name="limit" id="limit">
      <?
       $lmarray=array(30,50,100);
       foreach ($lmarray as $value)
 		 {
 		 	if($value==$limit)
 		 	echo"<option value=\"$value\" selected=\"selected\">$value</option>";
  		    else 
  		    echo"<option value=\"$value\">$value</option>";
  		}
      ?>    
      <!--
      <option value="20">20</option>
          <option value="30">30</option>
          <option value="50">50</option>
          <option value="100">100</option>
        -->
          </select> <? echo $string['banghitrentrang']?></td>
      <td><div align="center">
        <label>
        <input type="submit" name="submit" id="sumit" value="     Xem   " />
        </label>
      </div></td>
      <td></td>
    </tr>
    <tr>
    	<td height="5"></td>
    </tr>
  </table>
</form>
</fieldset>

<!-- HÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¿t form lÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½c -->
<link href="images/style.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="5"></td>
    </tr>
</table>
<table   cellspacing="0" cellpadding="0" border="1" class="sortable" align="center" style="border:dotted 1px #CCC;">
<thead>
  <tr  class="tablecontent" align="center" style="font-family:tahoma; font-weight:bold; color:#000 ">
    <td>STT</td>
    <td> <?echo $string['ho'];?></td>
    <td><? echo $string['ten'];?></td>
  	<td><? echo $string['scm'];?></td>
    <td><?echo $string['lop'];?></td>
    <td><?echo $string['nganh'];?></td>
    <td><?echo $string['nhom'];?></td>
    <td><?echo $string['coquan'];?></td>
    <td><?echo $string['chucdanh'];?></td>
    <td><?echo $string['chucvutronglop'];?></td>
    <td><?echo $string['chucvutrongnhom'];?></td>
    <td>Candidate</td>
    <td><?echo $string['trinhdo'];?></td>
    <td><?echo $string['doituongtuyensinh'];?></td>
    <td><?echo $string['trangthai'];?></td>
    <td><?echo $string['ghichu'];?> </td>
  </tr>
   </thead>
  
  <?
  
if (isset($_POST['submit']))
{   
	//$page=1;
	if($nganh=="")
	{
		$nganh_qry="";
	}
	else $nganh_qry="AND u.topica_nganh='$nganh'";
	if($lop=="")
	{
		$lop_qry="";
	}
	else $lop_qry="AND u.topica_lop='$lop'";
	if($nhom=="")
	{
		$nhom_qry="";
	}
	else $nhom_qry="AND u.topica_nhom='$nhom'";
	
	if($chucdanh=="")
	{
		$chucdanh_qry="";
	}
	else $chucdanh_qry="AND u.topica_chucdanh='$chucdanh'";
	if($chucvu=="")
	{
		$chucvu_qry="";
	}
	else $chucvu_qry="AND u.topica_chucvutronglop='$chucvu'";
	if($chucvutrongnhom=="")
	{
		$chucvutrongnhom_qry="";
	}
	else $chucvutrongnhom_qry="AND u.topica_chucvutrongnhom='$chucvutrongnhom'";
	if($candidate=="")
	{
		$candidate_qry="";
	}
	else $candidate_qry="AND u.topica_candidate='$candidate'";
	if($trangthai=="")
	{
		
		$trangthai_qry="";
	}
	else $trangthai_qry="AND u.topica_status='$trangthai'";
	if($username=='')
	{
		$username_qry="";
	}
	else 
	{
	$username_qry="AND CONCAT_WS(' ',username,lastname,firstname,topica_lop,topica_chucdanh,topica_coquan,topica_chucvutronglop,topica_chucvutrongnhom,topica_status) LIKE '%$username%'";	
//	$username_qry="AND MATCH (username,firstname,lastname) AGAINST ('$username')";
	}
	get_user_data($nganh_qry,
	    $lop_qry,
	    $nhom_qry,
	    $chucdanh_qry,
	    $chucvu_qry,
	    $chucvutrongnhom_qry,
	    $candidate_qry,
	    $trangthai_qry,
	    $username_qry,
	    $page,
	    $limit);
	
	
}
  
  else{
  
get_user_data('','','','','','','','','',$page,$limit);
echo $nganh;
  }
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
    	<td height="10"></td>
    </tr>
	<tr>
    	<td style="font-family:tahoma; color:#810C15; font-size:12px;">
<?php

echo $string['tongso'].$total.$string['hocvien'];
echo $numPages;
echo"   trang";
$prev_page = $page - 1;

if ($prev_page >= 1)
{
    echo ("<b>&lt;&lt;</b> <a href=\"danhsachlop.php?page=$prev_page&limit=$limit\" style=\" font-family:tahoma; color:#810C15; font-size:12px;  \"><b>Trang tr&#432;&#7899;c</b></a>");
}


for ($a = 1; $a <= $numPages; $a++)
{
    if ($a == $page)
    {
        echo ("<span style=\" font-family:tahoma; color:#810C15; font-size:12px; \"><b> $a</b></span> | "); //no link
    }
    else
    {
        echo ("  <a href=\"danhsachlop.php?page=$a&limit=$limit\" style=\" font-family:tahoma; color:#810C15; font-size:12px;  \">$a </a> | ");
    }
}

$next_page = $page + 1;
if ($next_page <= $numPages)

    echo ("<a href=\"danhsachlop.php?page=$next_page&limit=$limit\" style=\" font-family:tahoma; color:#810C15; font-size:12px;  \"><b>Trang sau</b></a> &gt; &gt;");

echo '</p>';

?>
        </td>
	</tr>
</table>

</body>
</html>
