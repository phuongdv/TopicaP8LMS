<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Clip extends dbBasic{
	function Clip(){
		global $_LANG_ID;
		$this->pkey = "clip_id";
		$this->tbl = "clip";
	}
}
?>