<?php 
               if(!isset($_REQUEST['nganh']))
			   {
			   	$nganh="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $nganh=$_REQUEST['nganh'];

               //-------------------------------
			   
			   if(!isset($_REQUEST['lop']))
			   {
			   	$lop="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $lop=$_REQUEST['lop'];
               //----------------------------
                if(!isset($_REQUEST['nhom']))
			   {
			   	$nhom="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $nhom=$_REQUEST['nhom'];
               //--------------------------
                if(!isset($_REQUEST['chucdanh']))
			   {
			   	$chucdanh="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $chucdanh=$_REQUEST['chucdanh'];
			   //------------------------------
			   if(!isset($_REQUEST['chucvu']))
			   {
			   	$chucvu="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $chucvu=$_REQUEST['chucvu'];
			   //--------------------------------
			   if(!isset($_REQUEST['chucvutrongnhom']))
			   {
			   	$chucvutrongnhom="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $chucvutrongnhom=$_REQUEST['chucvutrongnhom'];
			   //----------------------------------------
			   if(!isset($_REQUEST['candidate']))
			   {
			   	$candidate="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $candidate=$_REQUEST['candidate'];
			   //----------------------------------
			    if(!isset($_REQUEST['trangthai']))
			   {
			   	$trangthai="";//dÃƒÆ’Ã‚Â¨ault
			   }
			   else 
			   $trangthai=$_REQUEST['trangthai'];
			   //------------------------------
			   if(!isset($_REQUEST['username']))
			   {
			   	$username="";//dÃƒÆ’Ã‚Â¨ault
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
			   	$limit=20;//dÃƒÆ’Ã‚Â¨ault
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
$username='root';
$password='dhm123';
$dbname='topicaeldemo';
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
	// count
	
	$sql_count="SELECT
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
					{   $scm_bs64=$row[username];
					    $user_b64= base64_encode($scm_bs64);
						$tr ++;
						if($even=$tr%2)
						{
						echo" <tr  id=\"tabletd\" class=\"tablecontent\">
						         <td > $tr</td>
						         <td> $row[lastname]</td>
						         <td> $row[firstname]</td>
						        <td ><a title=\" Click vào để xem thông tin SCM của học viên\" alt=\" Click vào để xem thông tin SCM của học viên\" href=\"http://210.245.9.197/scm/viewProfiles.aspx?id=$user_b64\"> $row[username]</a></td>
							    <td >$row[topica_lop]</td>
							    <td > $row[topica_nganh]</td>
							    <td >$row[topica_nhom]</td>
							    <td >$row[topica_coquan]</td>
							    <td >$row[topica_chucdanh]</td>
							    <td >$row[topica_chucvutronglop]</td>
							    <td >$row[topica_chucvutrongnhom]</td>
							    <td >$row[topica_candidate]</td>
							    <td >$row[topica_trinhdo]</td>
							    <td >$row[topica_doituongtuyensinh]</td>
							    <td >$row[topica_status]</td>
							    <td>$row[topica_ghichu]</td>
						      </tr>
						";
						}
						else 
						{
							echo" <tr  bgcolor=\"#FFFFFF\" id=\"tabletd2\" class=\"tablecontent\" >
						         <td > $tr</td> 
						         <td> $row[lastname]</td>
						         <td> $row[firstname]</td>
							    <td ><a title=\" Click vào để xem thông tin SCM của học viên\" alt=\" Click vào để xem thông tin SCM của học viên\"  href=\"http://210.245.9.197/scm/viewProfiles.aspx?id=$user_b64\"> $row[username]</a></td>
							    <td >$row[topica_lop]</td>
							    <td > $row[topica_nganh]</td>
							    <td >$row[topica_nhom]</td>
							    <td >$row[topica_coquan]</td>
							    <td >$row[topica_chucdanh]</td>
							    <td >$row[topica_chucvutronglop]</td>
							    <td >$row[topica_chucvutrongnhom]</td>
							    <td >$row[topica_candidate]</td>
							    <td >$row[topica_trinhdo]</td>
							    <td >$row[topica_doituongtuyensinh]</td>
							    <td >$row[topica_status]</td>
							    <td>$row[topica_ghichu]</td>
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
<!-- form lÃƒÂ¡Ã‚Â»Ã¯Â¿Â½c -->
<fieldset>
<form id="form1" name="form1" method="post" action="http://topica.edu.vn/eldemo/user/danhsachlop.php" >
  <table width="100%" height="184" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td width="26%" align="right" bgcolor="#CCCCCC">Ngành
        <label>
      <select name="nganh" id="nganh">
        <option value="">----Tất cả------</option>
        <? get_selectdata("topica_nganh",$nganh); ?>
      </select>
      </label>      </td>
      <td width="36%" align="right" bgcolor="#CCCCCC">Chức danh 
        <label>
        <select name="chucdanh" id="chucdanh">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_chucdanh",$chucdanh); ?>
        </select>
      </label></td>
      <td width="38%" align="right" bgcolor="#CCCCCC">Candidate 
        <label>
        <select name=" candidate" id=" candidate">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_candidate",$candidate); ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right">Lớp
        <label>
        <select name="lop" id="lop">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_lop",$lop); ?>
                </select>
        </label></td>
      <td align="right">Chức vụ trong lớp
        <label>
        <select name="chucvu" id="chucvu">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_chucvutronglop",$chucvu); ?>
                                </select>
      </label></td>
      <td align="right">Trạng thái
        <label>
        <select name="trangthai" id="trangthai">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_status",$trangthai); ?>
                </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">Nhóm
        <label>
        <select name="nhom" id="nhom">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_nhom",$nhom); ?>
        </select>
      </label></td>
      <td align="right" bgcolor="#CCCCCC">Chức vụ trong nhóm
        <label>
        <select name="chucvutrongnhom" id="chucvutrongnhom">
          <option value="">-----Tất cả-----</option>
           <? get_selectdata("topica_chucvutrongnhom"); ?>
        </select>
      </label></td>
      <td align="right" bgcolor="#CCCCCC"><label>Tìm kiếm
        <input type="text" name="username" id="username" value="<?echo $username;?>" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Hiện <select name="limit" id="limit">
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
          </select> bản ghi/trang</td>
      <td>
      
      
      </td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td><div align="center">
        <label>
        <input type="submit" name="submit" id="sumit" value="     Xem   " />
        </label>
      </div></td>
      <td></td>
    </tr>
  </table>
</form>
</fieldset>

<!-- HÃƒÂ¡Ã‚ÂºÃ‚Â¿t form lÃƒÂ¡Ã‚Â»Ã¯Â¿Â½c -->
<link href="images/style.css" rel="stylesheet" type="text/css" />

<table align="center" border="1" bordercolor="#00CCFF" cellspacing="0" cellpadding="0" class="sortable">
<thead>
  <tr  class="tablecontent" align="center" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold">
     <td>STT</td>
     <td>Họ</td>
    <td> Tên</td>
  <td>Username</td>
    <td>Lớp</td>
    <td> Ngành</td>
    <td>Nhóm</td>
    <td>Cơ quan</td>
    <td>Chức danh</td>
    <td>Chức vụ trong lớp</td>
    <td>Chức vụ trong nhóm</td>
    <td>Candidate</td>
    <td>Trình độ</td>
    <td>Đối tượng tuyển sinh</td>
    <td>Trạng thái</td>
    <td> Ghi chú</td>
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
	$username_qry="AND CONCAT_WS(' ',username,lastname,firstname,topica_lop,topica_chucdanh,topica_chucvutronglop,topica_chucvutrongnhom,topica_status) LIKE '%$username%'";	
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
<?php
echo ("Tìm thấy tổng số  :$total Học viên ,  $numPages trang   |                  ");
$prev_page = $page - 1;

if ($prev_page >= 1)
{
    echo ("<b>&lt;&lt;</b> <a href=danhsachlop.php?page=$prev_page&limit=$limit><b>Trang trước</b></a>");
}


for ($a = 1; $a <= $numPages; $a++)
{
    if ($a == $page)
    {
        echo ("<b> $a</b> | "); //no link
    }
    else
    {
        echo ("  <a href=danhsachlop.php?page=$a&limit=$limit>$a </a> | ");
    }
}

$next_page = $page + 1;
if ($next_page <= $numPages)

    echo ("<a href=danhsachlop.php?page=$next_page&limit=$limit><b>Trang sau</b></a> &gt; &gt;");

echo '</p>';

?>

</body>
</html>
