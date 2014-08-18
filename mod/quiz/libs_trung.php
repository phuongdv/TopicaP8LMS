<?php
ini_set('display_errors',1);
function wwwcopy($link,$file) 
{ 
   $fp = @fopen($link,"r"); 
   $cont="";
   while(!feof($fp)) 
   { 
       $cont.= fread($fp,1024); 
   } 
   fclose($fp); 
   $fp2 = @fopen($file,"w"); 
   fwrite($fp2,$cont); 
   fclose($fp2); 
} 
//Example on using this function
function vietdecode($value) 
{ 
    $value = str_replace("."," .", $value);
	$value = str_replace(" ","", $value); 
    $value = str_replace("?"," ?", $value); 
    #---------------------------------a^ 
    $value = str_replace("ấ", "a", $value); 
    $value = str_replace("ầ", "a", $value); 
    $value = str_replace("ẩ", "a", $value); 
    $value = str_replace("ẫ", "a", $value); 
    $value = str_replace("ậ", "a", $value); 
    #---------------------------------A^ 
    $value = str_replace("Ấ", "A", $value); 
    $value = str_replace("Ầ", "A", $value); 
    $value = str_replace("Ẩ", "A", $value); 
    $value = str_replace("Ẫ", "A", $value); 
    $value = str_replace("Ậ", "A", $value); 
    #---------------------------------a( 
    $value = str_replace("ắ", "a", $value); 
    $value = str_replace("ằ", "a", $value); 
    $value = str_replace("ẳ", "a", $value); 
    $value = str_replace("ẵ", "a", $value); 
    $value = str_replace("ặ", "a", $value); 
    #---------------------------------A( 
    $value = str_replace("Ắ", "A", $value); 
    $value = str_replace("Ằ", "A", $value); 
    $value = str_replace("Ẳ", "A", $value); 
    $value = str_replace("Ẵ", "A", $value); 
    $value = str_replace("Ặ", "A", $value); 
    #---------------------------------a 
    $value = str_replace("á", "a", $value); 
    $value = str_replace("à", "a", $value); 
    $value = str_replace("ả", "a", $value); 
    $value = str_replace("ã", "a", $value); 
    $value = str_replace("ạ", "a", $value); 
    $value = str_replace("â", "a", $value); 
    $value = str_replace("ă", "a", $value); 
    #---------------------------------A 
    $value = str_replace("Á", "A", $value); 
    $value = str_replace("À", "A", $value); 
    $value = str_replace("Ả", "A", $value); 
    $value = str_replace("Ã", "A", $value); 
    $value = str_replace("Ạ", "A", $value); 
    $value = str_replace("Â", "A", $value); 
    $value = str_replace("Ă", "A", $value); 
    #---------------------------------e^ 
    $value = str_replace("ế", "e", $value); 
    $value = str_replace("ề", "e", $value); 
    $value = str_replace("ể", "e", $value); 
    $value = str_replace("ễ", "e", $value); 
    $value = str_replace("ệ", "e", $value); 
    #---------------------------------E^ 
    $value = str_replace("Ế", "E", $value); 
    $value = str_replace("Ề", "E", $value); 
    $value = str_replace("Ể", "E", $value); 
    $value = str_replace("Ễ", "E", $value); 
    $value = str_replace("Ệ", "E", $value); 
    #---------------------------------e 
    $value = str_replace("é", "e", $value); 
    $value = str_replace("è", "e", $value); 
    $value = str_replace("ẻ", "e", $value); 
    $value = str_replace("ẽ", "e", $value); 
    $value = str_replace("ẹ", "e", $value); 
    $value = str_replace("ê", "e", $value); 
    #---------------------------------E 
    $value = str_replace("É", "E", $value); 
    $value = str_replace("È", "E", $value); 
    $value = str_replace("Ẻ", "E", $value); 
    $value = str_replace("Ẽ", "E", $value); 
    $value = str_replace("Ẹ", "E", $value); 
    $value = str_replace("Ê", "E", $value); 
    #---------------------------------i 
    $value = str_replace("í", "i", $value); 
    $value = str_replace("ì", "i", $value); 
    $value = str_replace("ỉ", "i", $value); 
    $value = str_replace("ĩ", "i", $value); 
    $value = str_replace("ị", "i", $value); 
    #---------------------------------I 
    $value = str_replace("Í", "I", $value); 
    $value = str_replace("Ì", "I", $value); 
    $value = str_replace("Ỉ", "I", $value); 
    $value = str_replace("Ĩ", "I", $value); 
    $value = str_replace("Ị", "I", $value); 
    #---------------------------------o^ 
    $value = str_replace("ố", "o", $value); 
    $value = str_replace("ồ", "o", $value); 
    $value = str_replace("ổ", "o", $value); 
    $value = str_replace("ỗ", "o", $value); 
    $value = str_replace("ộ", "o", $value); 
    #---------------------------------O^ 
    $value = str_replace("Ố", "O", $value); 
    $value = str_replace("Ồ", "O", $value); 
    $value = str_replace("Ổ", "O", $value); 
    $value = str_replace("Ô", "O", $value); 
    $value = str_replace("Ộ", "O", $value); 
    #---------------------------------o* 
    $value = str_replace("ớ", "o", $value); 
    $value = str_replace("ờ", "o", $value); 
    $value = str_replace("ở", "o", $value); 
    $value = str_replace("ỡ", "o", $value); 
    $value = str_replace("ợ", "o", $value); 
    #---------------------------------O* 
    $value = str_replace("Ớ", "O", $value); 
    $value = str_replace("Ờ", "O", $value); 
    $value = str_replace("Ở", "O", $value); 
    $value = str_replace("Ỡ", "O", $value); 
    $value = str_replace("Ợ", "O", $value); 
    #---------------------------------u* 
    $value = str_replace("ứ", "u", $value); 
    $value = str_replace("ừ", "u", $value); 
    $value = str_replace("ử", "u", $value); 
    $value = str_replace("ữ", "u", $value); 
    $value = str_replace("ự", "u", $value); 
    #---------------------------------U* 
    $value = str_replace("Ứ", "U", $value); 
    $value = str_replace("Ừ", "U", $value); 
    $value = str_replace("Ử", "U", $value); 
    $value = str_replace("Ữ", "U", $value); 
    $value = str_replace("Ự", "U", $value); 
    #---------------------------------y 
    $value = str_replace("ý", "y", $value); 
    $value = str_replace("ỳ", "y", $value); 
    $value = str_replace("ỷ", "y", $value); 
    $value = str_replace("ỹ", "y", $value); 
    $value = str_replace("ỵ", "y", $value); 
    #---------------------------------Y 
    $value = str_replace("Ý", "Y", $value); 
    $value = str_replace("Ỳ", "Y", $value); 
    $value = str_replace("Ỷ", "Y", $value); 
    $value = str_replace("Ỹ", "Y", $value); 
    $value = str_replace("Ỵ", "Y", $value); 
    #---------------------------------DD 
    $value = str_replace("Đ", "D", $value); 
    $value = str_replace("Đ", "D", $value); 
    $value = str_replace("đ", "d", $value); 
    #---------------------------------o 
    $value = str_replace("ó", "o", $value); 
    $value = str_replace("ò", "o", $value); 
    $value = str_replace("ỏ", "o", $value); 
    $value = str_replace("õ", "o", $value); 
    $value = str_replace("ọ", "o", $value); 
    $value = str_replace("ô", "o", $value); 
    $value = str_replace("ơ", "o", $value); 
    #---------------------------------O 
    $value = str_replace("Ó", "O", $value); 
    $value = str_replace("Ò", "O", $value); 
    $value = str_replace("Ỏ", "O", $value); 
    $value = str_replace("Õ", "O", $value); 
    $value = str_replace("Ọ", "O", $value); 
    $value = str_replace("Ô", "O", $value); 
    $value = str_replace("Ơ", "O", $value); 
    #---------------------------------u 
    $value = str_replace("ú", "u", $value); 
    $value = str_replace("ù", "u", $value); 
    $value = str_replace("ủ", "u", $value); 
    $value = str_replace("ũ", "u", $value); 
    $value = str_replace("ụ", "u", $value); 
    $value = str_replace("ư", "u", $value); 
    #---------------------------------U 
    $value = str_replace("Ú", "U", $value); 
    $value = str_replace("Ù", "U", $value); 
    $value = str_replace("Ủ", "U", $value); 
    $value = str_replace("Ũ", "U", $value); 
    $value = str_replace("Ụ", "U", $value); 
    $value = str_replace("Ư", "U", $value); 
    #--------------------------------- 
    return $value; 
}
function genRandomString($length=10) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}
function getRandomString($length=10) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}
function getExt($filename){
	return end(explode('.', $filename));
}
function upload_url($url,$save_to)
{
	$type_upload=explode(",","jpg,bmp,gif,png");//return an array
	$ext=getExt(basename($url));// return extension of filename
	$name=basename($url);//lấy tên file từ URL
	
	if(!in_array($ext,$type_upload)){
		echo ("Khong upload duoc anh vi : Anh khong dung dinh dang ");
	}
	else{
		$fn=$save_to.$name;//vi du:images/news/
		$fp=fopen($fn,"w");
		$content=file_get_contents($url);//lấy nội dung của file
		fwrite($fp,$content,strlen($content));
		fclose($fp);
	}
}
function Get_Image($content)
{
    $matched = array();
    // Pattern img tag
    $pattern = '/<img.+src=\"([^\"]+)\"[^\/>]+[\/]?>/i';
    // Find all image tag
    preg_match_all($pattern,$content,$matched);
    // Output with image tag
    return $matched;
}
?>