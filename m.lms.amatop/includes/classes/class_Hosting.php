<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Hosting extends dbBasic{

	function Hosting(){
		$this->pkey = "id";
		$this->tbl = "hosting";
	}
	function getInfoPackage($typeId='', $packageId='') {
		$arrListOne = $this->getAll("is_online=1 and cat_id='".$typeId."' and package='".$packageId."'  order by order_no ASC limit 0, 1");	
		if(is_array($arrListOne) && count($arrListOne)>0)
			return $arrListOne;
		else
			return 0;
	}
}
?>