<?php
$url='http://elearning.dtu.topica.vn/vietth/webservices/get_id_by_account_moodle.php?wsdl';
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

	
function get_url_student_profile($account_name)
 {	
 global $client;
 //echo $forumid;
                        $method = 'get_id_by_account_moodle';
                        $params = array('account_name' =>$account_name);                
                        //print_r($params);						
                        $result = $client->call($method,$params);
						// Display the debug messages
						//echo '<h2>Debug</h2>';
						//echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
						return $result;
 }
?>