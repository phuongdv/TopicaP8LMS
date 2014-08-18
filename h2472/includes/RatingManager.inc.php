<?php


/**
 * mysql database wrapper class for start rating
 *@package AJAXRATING
 *@access public
 *@abstract Database
 *@author Sudhir Chauhan (chauhansudhir@gmail.com, sudhir_sonu@yahoo.com)
 *@return string
 *@version 1.0.0;
 */
//database host name or IP
define('DATABASEHOST','localhost');
//database user name
define('DATABASEUSERNAME','crc');
// database user password
define('DATABASEPASSWORD','crc145');
//database name
define('DATABASENAME','crcdata2');
// single start width
define('STARWIDTH',20);
// total number of starts
// NOTE: This is not working complately. If you want to increase of decrease stars you have to modify css also
define('TOTALSTARS',5);

//mysql extention must be loaded
// Abstact class for rating
abstract class Database {
	public $databaseHost = DATABASEHOST;
	public $databaseUser = DATABASEUSERNAME;
	public $databasePassword = DATABASEPASSWORD;
	public $databaseName = DATABASENAME;
	public $connection = null; //  database connection
	protected $recordsSelected = 0;
	protected $recordsUpdated = 0;
	
	
	protected function connect() {
	
		$this->connection = mysql_connect($this->databaseHost, $this->databaseUser, $this->databasePassword);
		if (!$this->connection) {
			$this->connection = null;
   			trigger_error(mysql_error());
		}
		mysql_select_db($this->databaseName);
	}
	
	protected function querySelect($query) {
		
		if (strlen(trim($query)) < 0 ) {
			trigger_error("Database encountered empty query string in querySelect function", E_USER_ERROR);
			return false;
		}
		
		if ($this->connection === null ) {
			$this->connect();
		}

		$result = mysql_query($query, $this->connection) or die(mysql_error());
		if (!$result) {
			return array();
		}

		$this->recordsSelected = mysql_num_rows($result);
		return $this->getData($result); 
	}
	
	protected function queryExecute($query) {
		
		if (strlen(trim($query)) < 0 ) {
			trigger_error("Database encountered empty query string in queryExecute function", E_ERROR);
		}
		
		if ($this->connection === null ) {
			$this->connect();
		}
		
		$res = mysql_query($query, $this->connection);
		if($res) {
			$this->recordsUpdated = mysql_affected_rows($this->connection);
		}
	}
	
	protected function getData($result) {
		$data = array();
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			foreach ($row as $key => $value) {
				$data[$i][$key] = stripslashes($value);		
			}
			$i++;
		}
		return $data;
	}	
	
}

/**
 * Ajax start rating
 *@package AJAXRATING
 *@access public
 *@abstract Database
 *@author Sudhir Chauhan (chauhansudhir@gmail.com, sudhir_sonu@yahoo.com)
 *@return string
 *@version 1.0.0;
 * TODO:: 
 *	for optimisation we can get all values from rating table in the constructer
 * 	and avoid multiple select queries.
 * 	IP base check: restrict users how have already voted. (cookie or ip address0
 */
class RatingManager extends Database {
	public static $instance = 0;
	
	private $totalVotes 	= 1; 
	private $totalValues	= 0;	
	private $oldIPs 		= Array();
	private $id 			= '';
	
	public function __construct() {	}
	
	public static function getInstance() {
		if (self::$instance == 0 ) {
			self::$instance = new RatingManager();
		}
		return self::$instance;
	}
	
	/**
	 * Draw stars
	 * TODO: add IP restriction check to avoid person to vote again
	 * COOKIE can also be used for this
	 */
	public function drawStars($id) {
		
		if (!is_numeric($id)) {
			trigger_error("RatingManager encountered problem in drawStars() parameter. Passed parameter must be numeric.");
			exit;
		}	
		$this->id = $id;
		$result = $this->getRatingById();
		
		$this->parseOldRatings($result);
		$allowVote = true;
		$ipAddress = $this->getRealIpAddress();
		if (in_array($ipAddress, $this->oldIPs)) {		
			$allowVote = false;
		}
		
		return $this->drawPrintedStars(true, $allowVote);
	}
		
	
	/**
	 * update votes for id
	 */
	public function updateVote($numberofVotesReceived, $voteForWitchId) {
		$this->id = $voteForWitchId;
		if (!is_numeric($this->id)) {
			trigger_error("RatingManager encountered problem in updateVote() parameter. Passed parameter must be numeric.");
			exit;
		}
		$result = $this->getRatingById();
		$total = count((array)$result);
		$this->parseOldRatings($result);
		$ipAddress = $this->getRealIpAddress();
		if ($total > 0) {
			if (in_array($ipAddress, $this->oldIPs)) {				
				return $this->drawPrintedStars(false, false);
			}
			
			$this->totalValues = $numberofVotesReceived + $this->totalValues;	// add together current vote value and the total vote value
			$this->totalVotes = $this->totalVotes + 1;//increment the current number of votes
			array_push($this->oldIPs, $ipAddress);  //if it is an array i.e. already has entries the push in another value						
			$query = "UPDATE ratings SET total_votes = '".$this->totalVotes."', total_value='".$this->totalValues."', 
					  used_ips='".serialize($this->oldIPs)."' WHERE id='".(int)$this->id."'";
		}		
		else {
			$this->totalValues = ($numberofVotesReceived > 0)? $numberofVotesReceived : 1;
			$this->totalVotes = 1;
			array_push($this->oldIPs, $ipAddress);			
			$query = "INSERT INTO ratings (id, total_votes, total_value, used_ips) 
					 VALUES ({$this->id}, {$this->totalVotes}, {$this->totalValues}, '".serialize($this->oldIPs)."')";			
		}
		
		$this->queryExecute($query);
		return $this->drawPrintedStars(false, false);
	}
	
			
	private function drawPrintedStars($addWrapperDiv = false, $allowVote = false) {
		$currentRating = @number_format($this->totalValues / $this->totalVotes, 2) * STARWIDTH;	
		$voteClass = ($allowVote == true)? 'allow': 'voted';
		$ratingString = array("<ul class=\"ratings\">");
		$ratingString[] = "<li class=\"current\" style=\"width:". $currentRating ."px;\">Currently " . $currentRating ."</li>";
		for ($i = 1; $i <= TOTALSTARS; $i++) { 
			$ratingString[] = "<li><a href=\"num={$i}&id={$this->id}\" title=\"{$i} out of " . TOTALSTARS ."\" class=\"s{$i} {$voteClass}\" onclick=\"return vote(this, {$this->id}, '{$voteClass}');\">{$i}</a></li>";
		}
		$ratingString[] = "</ul>"; //show the updated value of the vote
		
		//name of the div id to be updated | the html that needs to be changed
		if ($addWrapperDiv === true) {
			$output = '<div id="' . $this->id. '">' . implode("",$ratingString) . '</div>';
		}
		else {
			$output = implode("",$ratingString);
		}
		
		return $output;
	}	
	
	private function getRatingById() {
		$query = "SELECT * FROM tblreply WHERE id='".(int)$this->id."'";
		return $this->querySelect($query);
	}
	
	// return user ip
	private function getRealIpAddress() {
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}		
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	private function parseOldRatings($results) {
		$this->totalVotes 	= 1; 
		$this->totalValues	= 0;	
		$this->oldIPs 		= Array();		

		if (count((array)$results) > 0 ) {
			$this->totalVotes 	= $results[0]['total_votes'];	//how many total votes
			$this->totalValues 	= $results[0]['total_value'];  //total number of rating added together and stored
			$this->oldIPs 		= unserialize($results[0]['used_ips']);
		}		
	}
}

?>