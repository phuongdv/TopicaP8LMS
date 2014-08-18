<?
class Cart
{
  var $products_id_in_cart;    //Product Id
  var $products_num_in_cart;   //Product Quantity
  var $num_of_products_id;     //Number Of Product Id
  var $num_of_products_num;    //Number Of Product
  var $final_price;            //Total price
  var $product_detail;  
  var $err_str;                // Error Message
  //Constructor
  function Cart()
  {
    $this->products_id_in_cart = array();
    $this->products_num_in_cart = array();
    $this->init();
  }
  //Session start
  function init()
  {
    if(!session_is_registered('products_id_array'))
    {
      session_register('products_id_array');
      session_register('products_quantity_array');
    }
  }
  //Input variables in array
  function get_shopping_cart()
  {
    $this->products_id_in_cart = $_SESSION['products_id_array'];
    $this->products_num_in_cart = $_SESSION['products_quantity_array'];
    $this->num_of_products_id = count($this->products_id_in_cart);
    $this->num_of_products_num = count($this->products_num_in_cart);
  }
  //Add product in cart
  function add_item($products_id)
  {
    $this->get_shopping_cart();
    
    if($this->num_of_products_id==0 || $this->num_of_products_num==0)
    {
      //No item in cart yet
      $this->products_id_in_cart[] = $products_id;
      $_SESSION['products_id_array'] = $this->products_id_in_cart;
    
      $this->products_num_in_cart[] = 1;
      $_SESSION['products_quantity_array'] = $this->products_num_in_cart;
    }
    else //Cart already had products
    {
      if(!in_array($products_id, $this->products_id_in_cart)) // Not found in cart
      {
        $this->products_id_in_cart[] = $products_id;
        $_SESSION['products_id_array'] = $this->products_id_in_cart;
    
        $this->products_num_in_cart[] = 1;
        $_SESSION['products_quantity_array'] = $this->products_num_in_cart;
      }
      else //Add 1 quantity with the same products
      {
        for($i=0;$i<$this->num_of_products_id;$i++)
        {
          if($products_id==$this->products_id_in_cart[$i])
          {
            $found_products_id_index = $i;
          }
        }
        $this->products_num_in_cart[$found_products_id_index] = $this->products_num_in_cart[$found_products_id_index] +1;
        $_SESSION['products_quantity_array'] = $this->products_num_in_cart;
      }
    } //End: if($this->num_of_products_id==0 || $this->num_of_products_num==0)    
    $this->get_shopping_cart();
    return true;
  }
  //Update cart
  function update_shopping_cart($quantity_array, $if_delete_array)
  {
    if(!session_is_registered('products_id_array'))
    {
      $this->err_str += "[System Error] products_id_array Not Found\n";
      return false;
    }    
    $this->get_shopping_cart();  
	//Get Interger from Quantity array
	$num=count($quantity_array);  
	for($k=0; $k<$num; $k++) {
	 if(ereg("[0-9]",$quantity_array[$k])==false) {
	  $quantity_array[$k]=1;
	 }
	 elseif(ereg("[a-zA-Z|^(~`!@#%&/\)*]",$quantity_array[$k])==true) {
	  $quantity_array[$k]=1;
	 }
	 else {
	  $quantity_array[$k]=abs(intval($quantity_array[$k]));
	 }
	}
	//print_r($quantity_array);
    $_SESSION['products_quantity_array'] = $quantity_array;
    $this->products_num_in_cart = $_SESSION['products_quantity_array'];    
    $if_delete = $if_delete_array;    
    for($i=0;$i<count($this->products_num_in_cart);$i++)    {
      $check_if_delete = false;
      for($j=0;$j<count($if_delete);$j++)      {
        if($i==$if_delete[$j])        {
          $check_if_delete = true;
        }
      }
      if($check_if_delete!=true)
      {
        if($this->products_num_in_cart[$i]!=0)
        {
          $new_products_id_in_cart[]=$this->products_id_in_cart[$i];
          $new_products_num_in_cart[]=$this->products_num_in_cart[$i];
        }
      }
    }  
    $_SESSION['products_id_array'] = $new_products_id_in_cart;
    $_SESSION['products_quantity_array'] = $new_products_num_in_cart;    
    $this->get_shopping_cart();
    return true;
  }  
  
  //Get USD foreign exchange rate
  function get_foreign_rate_today() {
  	$clsCurrency = new Currency();
	
	//Get USD for change foreign rate
	$arrDolaCurrency = $clsCurrency->getAll("name='USD'");
	if(is_array($arrDolaCurrency)) $current_rate = $arrDolaCurrency[0]["price"];
	else $current_rate = 1;
	
	return $current_rate;
  }  
  
  //Convert to USD foreign exchange rate
  function convert_foreign_to_usd($var) {
  	$current_rate = $this->get_foreign_rate_today();
	
	return (int)($var/$current_rate);
  }
  
  //Check Currency Foreign Exchange
  function check_currency_current($var) {
  	$clsCurrency = new Currency();
	if($clsCurrency->getPrice($var)==1) return 1; 
	return 0;
  }
  
  //Show detail product in cart
  function get_shopping_cart_detail()
  {
    $this->get_shopping_cart();
    $clsProduct = new Product();
		      
    for($i=0;$i<$this->num_of_products_id; $i++) 
        $res[$i]=$clsProduct->getAll("product_id='".$this->products_id_in_cart[$i]."'");    
	$this->product_detail = $res;    
	
    return true;
  }
  //Show error
  function show_error()
  {
    return $this->err_str;
  }
}