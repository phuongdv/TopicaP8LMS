<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Announce extends dbBasic{
	function Announce(){
		global $_LANG_ID;
		$this->pkey = "announce_id";
		$this->tbl = "_announce";
	}
}
?>