<?php
require_once("../../config.php");
require_once("libs_trung.php");
$attempt=$_POST['attemptid'];
$choice =$_POST['choice'];
//$choice='2903669,2903698,2903678,2903662,2903713,2903753,2903745,2903760,2903834,2903805,2903846,2903873,2903817,2903839,2903826,2903853,2903851,2903815,2903887,2903890,';
$sql="insert into vietth_q169_answer(attempt,answer) values('$attempt','$choice')";
mysql_query($sql);
   // bat dau cham diem
    // lay ra dap an;
   $sql ="select vd.answers answers from vietth_q169_de vd INNER join vietth_q169_attempts va on vd.id = va.ma_de where va.id = $attempt";
   $result=mysql_query($sql);
   $rows=mysql_fetch_array($result);
   $answers = substr($rows['answers'],0,-1);
   $choice  = substr($choice,0,-1);
   $arr_choice =  explode(',',$choice);
   $arr_answers = explode(',',$answers);

   $arr_fail=array_diff($arr_answers,$arr_choice);
   $correct = count($arr_answers)-count($arr_fail);
   $grade   = round(($correct/count($arr_answers))*10,2);
   $finishtime = date('Y-m-d H:i:s');
   $sql ="UPDATE vietth_q169_attempts set sumgrade='$grade',corrects='$correct',finishtime='$finishtime',status='submited' where id=$attempt";
   mysql_query($sql);
// end cham diem
?>