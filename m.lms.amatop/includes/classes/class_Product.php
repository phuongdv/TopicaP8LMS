<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)
   @modifier    : Vu Quoc Trung (trungvq@vietitech.com)		
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Product extends dbBasic{

	function Product(){
		global $_LANG_ID;
		$this->pkey = "product_id";
		$this->tbl = "product";
	}
		
	function getProductName($product_id='') {
		global $_LANG_ID;
		
		$arrOneProduct = $this->getOne($product_id);
		if(is_array($arrOneProduct) && count($arrOneProduct)>0) 
			$pname = ($_LANG_ID=="vn")? $arrOneProduct["name"] : $arrOneProduct["name"];	
				
		return $pname;
	}
	
	function getProductSellPrice($product_id='') {
		$price = 0;
		
		$arrOneProduct = $this->getByCond("product_id='".$product_id."'");
		if(is_array($arrOneProduct) && count($arrOneProduct)>0) 
			$price = $arrOneProduct["price"];	
				
		return $price;
	}
	
	function getProductCurrencyID($product_id='') {
		$currency_id = 0;
		
		$arrOneProduct = $this->getByCond("product_id='".$product_id."'");
		if(is_array($arrOneProduct) && count($arrOneProduct)>0) 
			$currency_id = $arrOneProduct["currency_id"];	
				
		return $currency_id;
	}
	
	function makeStrSQLPriceRange($product_id='', $prefix = '') {
		$strSQL = '';
		
		$arrOneProduct = $this->getByCond("product_id='".$product_id."'");
		if(is_array($arrOneProduct) && count($arrOneProduct)>0) {
			if($arrOneProduct["price"] != 0) {
				$nstrlen = strlen($arrOneProduct["price"]);
				$prefix_sprice = substr($arrOneProduct["price"], 0, 1);
				$suffix_sprice = 1;
				$nstrlen -= 1;
				if($nstrlen>0) 
					for($i=0; $i<$nstrlen; $i++)
						$suffix_sprice *= 10;
					
				$min_sprice = $prefix_sprice * $suffix_sprice;
				$max_sprice = ($prefix_sprice + 1) * $suffix_sprice;
						
				$strSQL .= (empty($prefix))? " price>=" . $min_sprice . " and price<" . $max_sprice : " ".$prefix.".price>=" . $min_sprice . " and ".$prefix.".price<" . $max_sprice;	
			}
		}	
				
		return $strSQL;
	}
		
	# get child of category in left_menu
	function checkProduct($cat_id=''){
		$res = $this->getAll("cat_id='$cat_id'");
		if(is_array($res))
			return 1;
		return 0;
	}
	function getPriceStr($product_id){
		$one = $this->getOne($product_id);
		$price = $one["price"];
		$currency = $one["currency_id"];
		$res ='';
		#
		$clsCurrency = new Currency();
		$oneCurrency = $clsCurrency->getOne($currency_id);
		$current = $oneCurrency["name"];
		#
		$res = $price.' '.$current;
		return $res;
	}
		
	function getInt($var) {
		return (int) $var;
	}
	
	function formatPrice($str) {
		return number_format($str,0,"",",");
	}
	
	function jsCalculatoPrice() {
		global $dbconn;
		
		$clsCurrency = new Currency();
		$arrOneCurrency = $clsCurrency->getAll("name='USD'");
		$usd_price = $arrOneCurrency[0]["price"];
		
		$html = '<script language="javascript">';
		$html .= 'function split(string, sep)
					{
						var items = string.split(sep);
						var result = [];
						for(var i = 0; i < items.length; i++)
							if(items[i]) result[result.length] = items[i];
					
						return result;
					}
					
					function changeTotalPrice(frmName,strName)
					{
						var total_price = 0;
						var name = "";
						for(var i=0;i<frmName.elements.length;i++){
							name = frmName.elements[i].name;
							if(name.match("select") == "select"){
								str = split(frmName.elements[i].value,"&");
								total_price = total_price + parseFloat(str[1]);
							}
						}
						frmName.ResultUSD.value = total_price;	
						frmName.ResultVND.value = total_price*'.$usd_price.';
					}';
					
		$html .= '</script>';
		
		return $html;
	}
	
	function countDown($ints,$inte) {
		$tnow = time();
		$ints = ($tnow>$ints)? $tnow : $ints;
		$int_timer = ($ints<$inte)? ($inte-$ints) : ($ints-$ints);
		$html = '<script type="text/javascript">';
		$html .= '$(function () {';
		$html .= '$(".count_down").countdown({until: +'.$int_timer.',compact: true,onExpiry: f5Page});';
		$html .= 'function f5Page() {
				  	window.location.href=url_ajax_script+"/home"
				  }';
		$html .= '});';
		$html .= '</script>';
		
		return $html;
	}
	
	function setProductCookie($product_id) {
		
		$html = '';
		$html = '<script type="text/javascript">';
		$html .= '$(function () {';
		$html .= 'if ($.cookie("product_history")) {
				var ckstr =  $.cookie("product_history");
				ckstr += ","+'.$product_id.';
				$.cookie("product_history", ckstr, { expires: '.(2*365).', path: "", domain: "giamgiagiovang.com"}); 
			}
			else
				$.cookie("product_history", '.$product_id.', { expires: '.(2*365).', path: "", domain: "giamgiagiovang.com"});
		';
		$html .= '});';
		$html .= '</script>';
		
		return $html;
	}
	
	function showStarRating($product_id) {
		$html = '';
		
		$html .= '<script type="text/javascript">$(function(){$("#rating_'.$product_id.'").rater({postHref:url_ajax_script+"/rating.php"});});</script>';
		
		return $html;
	}
	
	function createTip($divid='', $arrListProduct=array()) {
		$html = '';
		
		$html .= '<div id="'.$divid.'" class="stickytooltip"><div class="head_tips"></div><div class="body_tips"><div class="tips_content">';
		if(is_array($arrListProduct) && count($arrListProduct)>0)
			foreach($arrListProduct as $k => $v) {
				$arrListOneProduct = $this->getOne($v["product_id"]);
				$html .= '<div id="sticky'.$k.'" class="atip">'.html_entity_decode($arrListOneProduct["intro"]).'</div>';
			}
		$html .= '</div></div><div class="bottom_tips"></div></div>';
		
		return $html;
	}
	
	function getProductIDFromNameAlias($str='') {
		$arrListOneProduct = $this->getAll("is_online=1 and name_alias='".$str."' order by order_no ASC");	
		if(is_array($arrListOneProduct) && count($arrListOneProduct)>0)
			return $arrListOneProduct[0]["product_id"];
		else
			return 0;
	}
}
?>