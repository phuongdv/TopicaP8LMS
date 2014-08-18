<?
function read_file($file){
    $handle = fopen ($file, "rb");
    $contents = "";
    do {
        $data = fread($handle, 8192);
        if (strlen($data) == 0) {
           break;
       }
       $contents .= $data;
    } while(true);
    fclose ($handle);
    return $contents;
}


function save_file($file,$content,$append=0,$binary=0){
    if($binary){
        $b = 'b';
    } else {
        $b= 't';
    }
    if($append) {
        $mode = "a$b";
    } else {
        $mode = "w$b";
    }
    $fp = @fopen($file,$mode);
    $err = '';
    if($fp) {
        fwrite($fp,$content);
        fclose($fp);
        //@chmod($file, 0666);
    } else {
        $err = " Can't write file $file. Check file/directory permissions.";
    }
    return $err;
}

function get_size($size) {//bytes
	$kb = 1024;
	$mb = 1024 * $kb;
	$gb = 1024 * $mb;
	$tb = 1024 * $gb;
	if ($size < $kb) {
		$file_size = "$size Bytes";
	}
	elseif ($size < $mb) {
		$final = round($size/$kb,2);
		$file_size = "$final KB";
	}
	elseif ($size < $gb) {
		$final = round($size/$mb,2);
		$file_size = "$final MB";
	}
	elseif($size < $tb) {
		$final = round($size/$gb,2);
		$file_size = "$final GB";
	} else {
		$final = round($size/$tb,2);
		$file_size = "$final TB";
	}
	return $file_size;
} 

if (!function_exists('file_put_contents')) {
	function file_put_contents($filename="", $str){
		if (is_writable($filename)) {
			$fp = fopen($filename, "w");
			fwrite($fp, $str);
			fclose($fp);
			return 1;
		}else{
			return 0;
		}
	}	
}
if (!function_exists('file_get_contents')) {
	function file_get_contents($filename=""){
		$fp = fopen($filename, "w");
		$str = fread($fp, filesize($filename));
		fclose($fp);
		return $str;
	}	
}

function getDirectory($dir){
	$arr = "";
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && is_dir($dir."/".$file)){
				$arr[] = $file;
			}
		}
		closedir($handle);
	}
	return $arr;
}
?>