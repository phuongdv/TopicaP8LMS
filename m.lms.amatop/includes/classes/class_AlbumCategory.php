<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class AlbumCategory extends dbBasic{
	function AlbumCategory(){
		$this->pkey = "album_category_id";
		$this->tbl = "_album_category";
	}
}
?>