<?
/**
* Editor class provides a GUI interface to create,
* and manage phpregistry files.
*
* @author Richard Standbrook <richard@koorb.co.uk>
* @version 0.1
*/
class PhpRegedit extends PhpRegistry {

    /**
    * @var string Current key
    * @access private
    */
    var $current_key;

	function PhpRegedit(){
	
	}
    /**
    * Handles actions to display, update, add, remove and save phpregistry
    * @access public
    */
    function editor() {

        session_start();
        
        //if a valid path is specified in the querystring
        if( !@$this->change_current_key($_GET['key']) )
        { $this->change_current_key(''); }

        $output  = "<!DOCTYPE html\n";
        $output .= "PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n";
        $output .= "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";

        $output .= "<html>\n";

        $output .= " <head>\n";
        $output .= " <title>phpregistry editor</title>\n";
        
        $output .= "<style>\n";
        $output .= " a {color: #222222;text-decoration: underline;}\n";
        $output .= " a:hover {text-decoration: none;}\n";
        $output .= " .pr_main,input {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;}\n";
        $output .= " .pr_key_links {background-color: #E4EEDB; padding: 5px;}\n";
        $output .= " .pr_main {width:500px;}\n";
        $output .= " .pr_path {background-color: #EDEBDC; padding: 2px; font-weight:bold;}\n";
        $output .= " .pr_value {background-color: #F4F3EC; padding: 2px;}\n";
        $output .= " .pr_set_frm {padding:10px;background:#BCD6DA;}";
        $output .= " .pr_set_frm_title {color:#ffffff;padding:5px;background:#619EA7;font-weight:bold;}";
        $output .= " .pr_options {padding:5px;background:#BCD6DA;}";
        $output .= " .pr_filename {padding:3px;font-size:10pt;font-weight:bold;text-align:right;}";
        $output .= " .pr_filename input {padding:3px;font-weight:normal;}";
        $output .= " .pr_open_frm {padding:10px;background:#BCD6DA;}";
        $output .= " .pr_open_frm_title {color:#ffffff;padding:5px;background:#619EA7;font-weight:bold;}";
        $output .= "</style>\n";
        
        $output .= " </head>\n";
        
        $output .= "<body>\n\n";
        $output .= "<table class=\"pr_main\" align=\"center\" cellpadding=\"0\" cellspacing=\"1\">\n\n";
        
        //Close file
        if( @$_POST['action'] == 'close' )
        {
            $_SESSION['regfile'] = null;
        }

        //Open a file to the session
        if(!@$_SESSION['regfile']) {
            $output .= $this->openform();
            $hide_content = true;
        }else{
            $this->open($_SESSION['regfile']);
        }

        switch (@$_POST['action']) {
        
            //Add / update key and value
            case 'set key':

                $key = $this->current_key ? $this->current_key.'/'.$_POST['key'] : $_POST['key'];

                if(@$_POST['mkdir'] != 'true')
                {
                    $value = $_POST['value'];

                }else{
                
                    $value = null;
                }
                
                $this->set_key($key,$value);
                $this->save($_SESSION['regfile']);
                break;

            //Update the value of multiple existing keys
            case 'update keys':

                foreach( $_POST['update'] as $key => $value )
                { $this->set_key($key,$value);}
                $this->save($_SESSION['regfile']);
                break;
        
            //Remove multiple existing keys
            case 'delete selected':

                foreach( $_POST['delete'] as $key => $foo )
                { $this->remove_key($key); }
                $this->save($_SESSION['regfile']);
                break;
                
        }//switch($_POST['action'])
        
        //Unless we have specified to hide the content, add it here
        if(!@$hide_content) {

            $output .= $this->content();
        }

        $output .= "\n</table>";
        $output .= "\n\n</body>";
        $output .= "\n\n</html>";

        //echo output to screen
        echo $output;
    }
    
    /**
    * returns a html set of breadcrum links for the current path
    * @access private
    */
    function key_path_links() {

        $links_array = explode('/',$this->current_key);

        $kp = "<a href='?root'>root</a>";

        if(!$this->current_key)
        {return $kp;}

        foreach($links_array as $c => $key) {

            $kp_count = 0;
            $kp_key = '';
            
            while($kp_count != $c) {

                $kp_key .= $links_array[$kp_count]."/";
                $kp_count++;
            }

            $kp .= " / <a href='?key=".$kp_key.$key."'>".$key."</a>";
        }

        return $kp.' :';
    }
    
    /**
    * Handles opening a phpreg file
    * @access private
    */
    function openform() {
    
        if( @$_POST['filename'] ) {
        
            $_SESSION['regfile'] = $_POST['filename'];
            $this->open($_SESSION['regfile']);
            return $this->content();
        }
        
        $open_form = "<tr>\n <td class=\"pr_open_frm_title\">";
        $open_form.= "Open / create php registry file";
        $open_form.= " </td>\n</tr>\n";

        $open_form.= "<form name=\"open\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">\n";
        $open_form.= "<tr>\n <td class=\"pr_open_frm\">\n";
        $open_form.= "  <input type=\"text\" name=\"filename\" id=\"filename\" size=\"50\" />\n";
        $open_form.= "  <input type=\"submit\" name=\"action\" id=\"action\" value=\"open/create\" />\n";
        $open_form.= " </td>\n</tr>\n";
        $open_form.= "</form>\n";
        
        $open_form.= "<tr>\n <td class=\"pr_open_frm\">";
        $open_form.= "<b>OPEN A FILE</b><br />";
        $open_form.= "&bull; Type the path and name of your file<br />";
        $open_form.= "&bull; Click `open/create`<br />";
        $open_form.= "<br /><b>CREATE A FILE</b><br />";
        $open_form.= "&bull; Type the path and name for the file to be saved as<br />";
        $open_form.= "&bull; Click `open/create`<br />";
        $open_form.= "&bull; <b>Note: The directory structure must already exsist</b><br />";
        $open_form.= " </td>\n</tr>\n";
        
        $open_form.= "<tr>\n <td class=\"pr_open_frm_title\">";
        $open_form.= "Version ".$this->version." | <a href=\"http://www.koorb.co.uk\">richard standbrook</a>";
        $open_form.= " </td>\n</tr>\n";

        return $open_form;
    }
    
    /**
    * Handles setting keys and values in a phpreg file
    * @access private
    */
    function setform() {

        $set_form = "<tr>\n <td class=\"pr_set_frm_title\" colspan=\"3\">";
        $set_form.= "Set new key and value";
        $set_form.= " </td>\n</tr>\n";

        $set_form.= "<form name=\"set\" method=\"post\">\n";
        $set_form.= "<tr>\n <td class=\"pr_set_frm\" colspan=\"3\">\n";
        $set_form.= "  <input type=\"text\" name=\"key\" id=\"key\" />\n";
        $set_form.= "  <input type=\"text\" name=\"value\" id=\"value\" />\n";
        $set_form.= "  <input type=\"submit\" name=\"action\" id=\"action\" value=\"set key\" />\n";
        $set_form.= "  <input type=\"checkbox\" name=\"mkdir\" id=\"mkdir\" value=\"true\" /> Extend key\n";
        $set_form.= " </td>\n</tr>\n";
        $set_form.= "</form>\n";

        return $set_form;
    }
    
    /**
    * Change the current key path
    * @param string name of key
    * @access private
    */
    function change_current_key ( $key ) {

        if( !preg_match($this->valid_key_pattern,$key) )
        { return false; }
        
        $this->current_key = $key;
    }

    /**
    * Outputs key settings and handles actions to update, add, remove and save
    * @param string name of key to start spidering definitions
    * @access private
    */
    function content() {

        $phpreg = $this->phpreg;
        $paths  = '';
        $keys   = '';

        //offset array on current_key if set
        if( $this->current_key ) {

            $offset = $this->convert_key_path($this->current_key);
            $eval = '$phpreg = $phpreg[\''.$offset.'\'];';
            eval($eval);
        }

        if($phpreg) {
        
            //alpha. sort keys
            @ksort ($phpreg);

            foreach( $phpreg as $key => $value ) {

                $next_key = $this->current_key ? $this->current_key.'/'.$key : $key;

                switch ( gettype($value) ) {

                    case 'array':

                        $paths .= "<tr>\n";
                        $paths .= " <td class=\"pr_path\" width=\"20\">\n";
                        $paths .= "  <input type=\"checkbox\" name=\"delete[".$next_key."]\" id=\"delete[".$next_key."]\" value=\"delete[".$next_key."]\"/>\n </td>\n";
                        $paths .= " <td class=\"pr_path\" colspan=\"2\">";
                        $paths .= "<a href='?key=".$next_key."'>".$key."</a>";
                        $paths .= "</td>\n</tr>\n\n";
                        break;

                    default:

                        $keys .= "<tr>\n";
                        $keys .= " <td class=\"pr_value\" width=\"20\">\n";
                        $keys .= "  <input type=\"checkbox\" name=\"delete[".$next_key."]\" id=\"delete[".$next_key."]\" value=\"delete[".$next_key."]\"/>\n </td>\n";
                        $keys .= " <td class=\"pr_value\">";
                        $keys .= $key;
                        $keys .= "</td>\n <td class=\"pr_value\" width=\"50%\">\n";
                        $keys .= "  <input type=\"text\" size=\"40\" name=\"update[".$next_key."]\" id=\"update[".$next_key."]\" value=\"".$value."\" />";
                        $keys .= "\n </td>\n</tr>\n\n";
                        break;
                }
            }
        }

        $output  = "<form name=\"phpreg\" method=\"post\">\n";
        $output .= "<tr>\n <td class=\"pr_filename\" colspan=\"3\">\n  ";
        $output .= $_SESSION['regfile']." &nbsp;&nbsp;<input type=\"submit\" name=\"action\" id=\"action\" value=\"close\" /> ";
        $output .= "\n </td>\n</tr>";
        $output .= "</form>\n";
        
        $output .= $this->setform();
        
        $output .= "<form name=\"phpreg\" method=\"post\">\n";
        
        $output .= "<tr>\n <td class=\"pr_key_links\" colspan=\"3\">\n  ";
        $output .= $this->key_path_links();
        $output .= "\n </td>\n</tr>";
        
        $output .= $paths.$keys;
        
        $output .= "<tr>\n";
        $output .= " <td colspan=\"3\">\n";
        
        $output .= " <table width=\"100%\" cellpadding=0 cellspacing=0>\n";
        $output .= " <tr>\n";
        $output .= "  <td class=\"pr_options\" colspan=\"2\">\n";
        
        $output .= "   <input type=\"submit\" name=\"action\" id=\"action\" value=\"delete selected\" />";
        $output .= "  </td>\n";
        $output .= "  <td class=\"pr_options\" align=\"right\">\n";
        $output .= "   <input type=\"submit\" name=\"action\" id=\"action\" value=\"update keys\" />";
        
        $output .= "  </td>\n";
        $output .= "  </td>\n</tr>\n\n";
        $output .= " </table>\n";
        
        $output .= " </td>\n";
        $output .= " </td>\n</tr>\n\n";
        
        $output .= "\n</form>";
        
        //return content
        return  $output;
    }
}

?>