<?
/**
*  Created by   :
*  @author		: Vu Quoc Trung (trungvq@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class _site_status extends DbBasic{
	function _site_status(){
		global $_LANG_ID;
		$this->pkey = "_site_status_id";
		$this->tbl = "_site_status";	
	}
}
?>