<?php
/*
* PHPregistry class usage examples.
*
* Class alows you to build up a registry for global or
* per application use, keys are defined as constants
*
* @author Richard Standbrook <richard@koorb.co.uk>
* @version 0.1.3
* @license GPL - http://www.opensource.org/licenses/gpl-license.php
*/
class PhpRegistry{

    /**
    * @var string File compression stream
    * @access private
    */
    var $compression = 'compress.zlib://';
    
    /**
    * @var string version number
    * @access private
    */
    var $version = '0.1.3';

    /**
    * @var string Regex pattern for a valid key
    * @access private
    */
    var $valid_key_pattern = '/^([^\/][a-zA-Z0-9]*[\/]?)*[^\/]$/';
    
    /**
    * @var array Holder for the phpreg array
    * @access private
    */
    var $phpreg = array();
	
	function PhpRegistry(){
	
	}

    /**
    * Serializes $phpreg and saves to file
    * @param string Name of file to save to
    * @param string optionaly add a custom compression stream
    * (must be opened with same compression stream as it was saved)
    * use save($filename, ''); for no compression
    * @return boolean true on success, false on failure
    * @access private
    */
    function save( $filename, $compression = null ) {
    
        //add compresion stream
        $file = $compression || $compression === '' ? $compression : $this->compression;
        $file.= $filename;
        
        if( @$fh = fopen($file,"w") ) {
        
            $phpreg = serialize($this->phpreg);
            fwrite($fh,$phpreg);
            fclose($fh);
            
            return true;
            
        }else{
            die('cannot save to file `'.$filename.'`');
            return false;
        }
    }
    
    /**
    * Opens and unserializes $phpreg
    * @param string Name of file to open
    * @param string optionaly add a custom compression stream
    * (must be opened with same compression stream as it was saved)
    * use open($filename, ''); for no compression
    * @return boolean true on success, false on failure
    * @access private
    */
    function open( $filename, $compression = null ) {

        //add compresion stream
        $file = $compression || $compression === '' ? $compression : $this->compression;
        $file.= $filename;

        if( @$fh = fopen($file,"r") ) {

            $content = fread($fh,filesize($filename)*100);
            fclose($fh);
            $this->phpreg = unserialize($content);

            return true;

        }else{
        
            if( @$fh = fopen($file,"w") ) {

                $this->open($filename,$compression);
                
            }else{
            
                session_destroy();
                die('cannot find/create file `'.$filename.'`. Please check path exists. <a href="'.$_SERVER['PHP_SELF'].'">back</a>');
                return false;
            }
        }
    }
    
    /**
    * Replace path seperators `/` for eval'ing
    * @access private
    */
    function convert_key_path( $key ) {
    
        // strip slashes from the start
        $pattern = "/^(\/)*/";
        $replace = "";
        $key = preg_replace($pattern,$replace,$key);
        
        // strip slashes from the end
        $pattern = "/(\/)*$/";
        $replace = "";
        $key = preg_replace($pattern,$replace,$key);
        
        $pattern = "/\//";
        $replace = "']['";
        $key = preg_replace($pattern,$replace,$key);
        
        return $key;
    }
    
    /**
    * Set a key to the phpreg, either add new or change exsiting
    * @param string name of key
    * @param string optional value, no value with extend the current key
    * @access public
    */
    function set_key( $key, $value = null ) {
    
        if( !preg_match($this->valid_key_pattern,$key) )
        { return false; }

        $phpreg = &$this->phpreg;
        $value  = gettype($value) == "string" ? '"'.$value.'"' : "Array()";
        $key    = $this->convert_key_path($key);
        
        $eval = '$phpreg[\''.$key.'\'] = '.$value.';';
        if(eval($eval)) { return true; }else{ return false; }
    }
    
    /**
    * Remove a key to the phpreg
    * @param string name of key
    * @access public
    */
    function remove_key( $key ) {

        if( !preg_match($this->valid_key_pattern,$key) )
        { return false; }
        
        $phpreg = &$this->phpreg;
        $key    = $this->convert_key_path($key);

        $eval = 'unset( $phpreg[\''.$key.'\'] );';
        if(eval($eval)) { return true; }else{ return false; }
    }
    
    /**
    * Define all keys as constants
    * @param string name of key to start spidering definitions
    * @access public
    */
    function define_keys( $offset_key = null ) {
    
        $phpreg = $this->phpreg;
        
        if($offset_key) {
        
            $offset = $this->convert_key_path($offset_key);
            $eval = '$phpreg = $phpreg[\''.$offset.'\'];';
            eval($eval);
        }
        
        foreach( $phpreg as $key => $value ) {
        
            switch ( gettype($value) ) {
            
                case 'array':
                
                    $next_offset = $offset_key.'/'.$key;
                    $pattern = "/^(\/)*/";
                    $replace = "";
                    $next_offset = preg_replace($pattern,$replace,$next_offset);
                    
                    $this->define_keys($next_offset);
                    break;
                
                default:
                	
                    $key  = $offset_key.'/'.$key;
                    //$key  = trim($key,'/');
                    $key = trim(str_replace('/', '_', $key), '_');
                   	$eval = "define('".$key."','".$value."');";
                    eval($eval);
                    break;
            }
        }
    }
}
?>