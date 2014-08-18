<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/18/14
 * Time: 3:41 PM
 */

if(file_exists('counter_file.txt')){
	$fil=fopen('counter_file.txt','r');
	$dat=fread($fil,filesize('counter_file.txt'));
	fclose($fil);
	$fil=fopen('counter_file.txt','w');
	fwrite($fil,$dat+1);
	fclose($fil);
}else{
	$fil=fopen('counter_file.txt','w');
	fwrite($fil,1);
	fclose($fil);
}