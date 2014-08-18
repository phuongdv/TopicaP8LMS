<?php
 class Paging
 {

    function sql_limit($total,$currpage,$rowperpage)
    {
    	$limit_sql=' limit '.($currpage-1)*$rowperpage.','.$currpage*$rowperpage;
    	return $limit_sql;   	
    }
    
    function get_max_page($total,$rowperpage)
    {
    	$totalpage = ceil($total/$rowperpage);
    	return       $totalpage;
    }
    
    function get_pages($total,$rowperpage)
    {
    	$totalpage = ceil($total/$rowperpage);
    	
    	for($i=1;$i<=5;$i++)
    	{
    		$pages[$i]=$i;    		
    	}
    	return $pages;  	
    }
 	
 	
 }

?>