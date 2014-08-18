<?
class Tours extends DbBasic{
	
	function Tours(){
		$this->pkey = "tours_id";
		$this->tbl = "tours";	
	}		
	
	function getNewsCatID($catid){
		$res = $this->getAll("typeoftour='$catid' order by reg_date desc limit 0,1");					
		return $res;
	}
	function getNewsCatIDOther($catid,$id){
		$res = $this->getAll("typeoftour='$catid' and is_online = 1 order by tours_id desc limit 0,4");					
		return $res;
	}
	
	function getCountryName($cat_id){
		$clsCategory = new Category();
		$clsCountry = new Country();
		$country_id = $clsCategory->getByField($cat_id, "country_id");
		return $clsCountry->getByField($country_id, "name");
	}
	
	function makeSelectHtml($selectName="", $fieldvalue="", $fieldoption="", $cond="", $selectedvalue="", $tag=true){
		global $dbconn;
		$sql = "SELECT DISTINCT(goingto) FROM ".$this->tbl;
		if ($cond!="") $sql.= " WHERE $cond";
		$arrSelect = $dbconn->GetAll($sql);
		
		$html = "";
		if ($selectName=="") $selectName = $fieldvalue;
		if ($tag==true){
			$html.= "<select name=\"$selectName\"  id=\"$selectName\">";
		}		
		if (is_array($arrSelect)){
			foreach ($arrSelect as $k => $v){
				if (is_array($selectedvalue)){
					$selected = (in_array($v[$fieldvalue], $selectedvalue))? "selected" : "";
				}else{	
					$selected = ($v[$fieldvalue]==$selectedvalue)? "selected" : "";
				}
				$value = $v[$fieldvalue];
				$option = $v[$fieldoption];
				$html.= "<option value=\"$value\" $selected class=content>".$option."</option>";
			}	
		}		
		if ($tag==true){
			$html.="</select>";
		}
		return $html;
	}
	
	function checkTour($tour_id){
		$clsCategory = new Category();
		$oneTour= $this->getOne($tour_id);
		$cat_parent= $oneTour["typeoftour"];
		$One_parent = $clsCategory->getOne($cat_parent);
		$grant_parent = $One_parent["parent_id"];
		$ret = "";
		if($grant_parent==81)
			//$ret="vietnam";
			$ret = "viettour";
		elseif($grant_parent==82)
			//$ret="laos";
			$ret = "cambtour";
		elseif($grant_parent==83)
			//$ret="cambodia";
			$ret = "laostour";
		else
			//$ret="multi";
			$ret="vietnam";
			
		return $ret;
	}
}
?>