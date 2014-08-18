<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)
   @modifier    : Vu Quoc Trung (trungvq@vietitech.com)		
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Service extends dbBasic{
	function Service(){
		global $_LANG_ID;
		$this->pkey = "service_id";
		$this->tbl = "service";
	}
}
?>