<?php
$url='http://forum.tvu.topica.vn/vietth/report/count_post.php?wsdl';
//$client = new nusoap_client($url, 'wsdl');
//$client->setCredentials("viet","123456","basic");

$cache = new nusoap_wsdlcache('../../../tmp', 86400);
$wsdl = $cache->get($url);
if(is_null($wsdl))
{
  $wsdl = new wsdl($url, '', '', '', '', 5);
  $cache->put($wsdl);
}
$client = new nusoap_client($wsdl,'wsdl','','','','');
$client->setCredentials("viet","123456","basic");

	
function count_post_forum($start,$end,$forumid,$dshv)
 {	
 global $client;
 //echo $forumid;
                        $method = 'count_post';
                        $params = array('start' =>$start,'end'=>$end,'forumid'=>$forumid,'dshv'=>$dshv);                
                        //print_r($params);						
                        $result = $client->call($method,$params);
						// Display the debug messages
						//echo '<h2>Debug</h2>';
						//echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
						return $result;
 }
?>