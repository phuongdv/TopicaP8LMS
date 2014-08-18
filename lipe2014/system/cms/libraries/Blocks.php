<?php  defined('BASEPATH') OR exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
* CodeIgniter Blocks Library
*
* @package         CodeIgniter
* @subpackage      Libraries
* @category        Libraries
* @author          'CaoPV'
*/

// ------------------------------------------------------------------------
class Blocks {
    
    public $CI;
    
    /**
     * Core functions
     *
     * Functions that are required in order to run the Blocks library
     *
     */
    
    function Blocks()
    {
        $this->CI =& get_instance();
    }

    
    // Get a list of all the plugins that are currently activated and execute them
    public function area($area)
    {    
        // Create the query to fetch the names of all activated widgets
        $this->CI->db->select(array('id','block_name','title','settings','container'));
        //$this->CI->db->like('area',$area);
        $this->CI->db->order_by('order_number', 'asc');
        $query = $this->CI->db->get_where('blocks',array('area' => $area,'active' => '1'));
        
        // Verify the results
        if($query->num_rows() > 0)
        {
            // Store the results
            $blocks = $query->result_array();            
            // Execute each block
            foreach($blocks as $block)
            {
                /*$areas = explode(",",$block['area']);
                
                // Only run the blocks for the current area
                if(in_array($area,$areas))
                {
                    $this->load($block['name']);
                }*/    
                echo $this->_load($block);        
            }
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Load block direct from the layout and the view file without using area.
     * @param  string Block name
     * @param  string Block title
     * @param  string Block Container
     * @param  array Block Settings
     * @return string
     * @access public
     */
    public function load($block_name,$block_title='', $block_container='',$block_settings = array()){    
        // Verify if the file exists at all
        if(file_exists(APPPATH . "blocks/$block_name/$block_name.php") == true)
        {
            // Open the block
            require_once(APPPATH . "blocks/$block_name/$block_name.php");
            
            // First letter needs to be uppercase, in case the user forgets this
            $class  = ucfirst($block_name);

            // Create the block class
            $obj_block = new $class();            
            
            // Verify if we can actually call the function at all
            if(is_object($obj_block))
            {        
                $data['title'] = $block_title;
                $data['content'] = $obj_block->run($block_settings);      
                $container = 'themes/' . $this->CI->settings->default_theme. '/views/containers/' . $block_container;
                
                if (file_exists( APPPATH . $container . EXT ))
                    echo $this->CI->load->view('../' . $container, $data, true);
                else
                    echo $data['content'];
            }
            else
            {
                // Show an error
                show_error("The run function of the $block_name block could not be executed, please verify that the function exists.");
                
                // Log the results
                //log_message('error',"Blocks Library - The run function of the $block_name block could not be executed.");
                
                // Prevent any other code from being executed
                exit();                
            }
        }
        else
        {
            // Show an error
            show_error("The $block_name block couldn't be loaded, please verify that the file exists.");
            
            // Log the results
            //log_message('error',"Blocks Library - The $block_name block could not be loaded.");
                
            // Prevent any other code from being executed
            exit();
        }
    }
    
    
    // Function to run a block based on the name, by default it will run all blocks
    private function _load($block)
    {
        $name = $block['block_name'];        
        // Verify if the file exists at all
        if(file_exists(APPPATH . "blocks/$name/$name.php") == true)
        {
            // Open the block
            require_once(APPPATH . "blocks/$name/$name.php");
            
            // First letter needs to be uppercase, in case the user forgets this
            $class  = ucfirst($name);

            // Create the block class
            $obj_block = new $class();            
            
            // Verify if we can actually call the function at all
            if(is_object($obj_block))
            {        
                $data['title'] = $block['title'];
                $data['content'] = $obj_block->run($block);
                $container = 'themes/' . $this->CI->settings->item('default_theme') . '/views/containers/' . $block['container'];
                
                if (file_exists( APPPATH . $container . EXT ))
                    return $this->CI->load->view('../' . $container, $data, true);
                else
                    return $data['content'];
            }
            else
            {
                // Show an error
                show_error("The run function of the $name block could not be executed, please verify that the function exists.");
                
                // Log the results
                //log_message('error',"Blocks Library - The run function of the $name block could not be executed.");
                
                // Prevent any other code from being executed
                exit();                
            }
        }
        else
        {
            // Show an error
            show_error("The $name block couldn't be loaded, please verify that the file exists.");
            
            // Log the results
            //log_message('error',"Blocks Library - The $name block could not be loaded.");
                
            // Prevent any other code from being executed
            exit();
        }
    }
    
    // Function to display a block's view file. All variables should contain the block_ prefix in order to prevent name collisions
    public function display($block_name,$block_data = array(),$block_view='block_view')
    {        
        // Verify the view file
        if(file_exists(APPPATH . "blocks/$block_name/views/$block_view.php"))
        {
            // Load the view file
            $view_file = $this->CI->load->view('../blocks/'.$block_name.'/views/'.$block_view, $block_data,true);
            //echo '<li>'.$view_file.'</li>';
            return $view_file;
        }
        else
        {
            // Show an error
            show_error("The view file for the $block_name block could not be loaded, please verify that the file exists.");
            
            // Log the results
            //log_message('error',"Blocks Library - The view file for the $block_name block could not be laoded.");
            
            // Prevent any other code from being executed
            exit();
        }        
    }
    
    /**
     * Get all settings for block
     * @author: ''
     */
    public function get_settings($block_id){
        // Create the query
        $this->CI->db->select('settings');        
        $query = $this->CI->db->get_where('blocks',array('id' => $block_id));        
        
        // Return the results
        $results = $query->result_array();
        
        // Turn the results into a single array
        foreach($results as $row)
        {

            // Decode the JSON string into an associative array
            $array     = json_decode($row['settings'],true);                        

            // Do we want to return all settings, or just a single one ?                
            return $array;
        }
    }
    
    
    /**
     * Data handling functions
     *
     * Functions can be user as a simplified way of updating or retrieving database data. 
     *
     */
    
    
    // Function to retrieve the block data from the body field (MUST BE JSON!!)
    public function get_data($name,$key = '0')
    {        
        // Create the query
        $this->CI->db->select('body');        
        $query = $this->CI->db->get_where('blocks',array('name' => $name));        
        
        // Return the results
        $results = $query->result_array();
        
        // Turn the results into a single array
        foreach($results as $row)
        {

            // Decode the JSON string into an associative array
            $array     = json_decode($row['body'],true);                        

            // Do we want to return all settings, or just a single one ?                
            return $array[$key];
        }
    }
    
    
    /*
     * Information functions
     * 
     * These function can be used to retrieve block information, such as the author, description, etc
     */
    
    
    // Function to parse the blocks.json file in each block directory
    public function get_block_info($name,$key = 'all')
    {
        if(!empty($name))
        {
            // Does the file exist ?
            if(file_exists(APPPATH ."blocks/$name/block.json"))
            {
                // Get the JSON string
                $json_string = file_get_contents(APPPATH ."blocks/$name/block.json");
                
                // Decode it
                $decode = json_decode($json_string,true);
                
                if($key !== 'all')
                {
                    // Get the single key
                    return $decode[$key];
                }
                else
                {
                    // Return the results
                    return $decode;
                }                
            }
            else
            {
                // Show an error
                show_error('The block.json file does not exist!');
                
                // Load the error
                //log_message('error','Blocks Library - The block.json file does not exist!');
                exit();
            }
        }
        else
        {
            // Show an error
            show_error('No block name has been specified!');
            
            // Log the error
            //log_message('error','Blocks Library - No block name has been specified!');
            exit();
        }
    }
    
    
    // Function to get a list of all available areas that are defined in the areas.json file
    function get_areas($path = null)
    {
        if($path != null)
        {
            // Get the json file
            $json_string = file_get_contents(APPPATH.$path);    
            
            // Decode it    
            $decode = json_decode($json_string,true);
            
            // Return it    
            return $decode;
        }
        else
        {
            // Show an error
            show_error('The areas.json file could not be found!');
            
            // Log the error
            //log_message('error','WIdgets Library - Areas.json could not be found');
        }
        
    }
    

    // Function to get the names of all blocks, either activated or deactivated
    function get_block_names($activated = null)
    {
        if($activated !== null)
        {
            // Active or not ?
            if($activated == 'activated')
            {
                $activated = 'true';
            }
            else
            {
                $activated = 'false';                
            }

            // Query time
            $this->CI->db->select('name');
            $query = $this->CI->db->get_where('blocks',array('active' => $activated));
            
            if($query->num_rows() > 0)
            {
                // Set the $results variable
                $results = $query->result_array();
                
                // Create an empty array
                $names = array();
                
                // Loop through each row
                foreach($results as $row)
                {
                    $names[] .= $row['name'];
                }
                
                // Return the results
                return $names;                
            }
        }
        else
        {
            // Show an error
            show_error('The block state(activated/deactivated) is not specified!');
            
            // Load the error
            //log_message('error','Blocks Library - The block state(activated/deactivated) is not specified!');
            exit();
        }
    }
    
    
    /**
     * Maintenance functions
     *
     * The functions below will install the block or activate/deactivate it.
     *
     */
    
    
    // Function to install a block, should only be triggered once
    public function install_block($name,$title,$description)
    {
        // Set the fields
        $data['id']        = 'id';
        $data['name']     = strtolower($name);
        $data['title']     = $title;
        $data['description'] = $description;
        $data['active'] = 'false';
        
        // Query to create the row for the block
        $this->CI->db->insert('block_def',$data);
        
        // Log the results
        //log_message('info',"Blocks Library - The following block has been installed : $name");
    }
    
    
    // Function to uninstall a block
    public function uninstall_block($name)
    {
        // Delete the block's table row
        $this->CI->db->delete('block_def',array('name' => strtolower($name)));
        
        // Log the results
        //log_message('info',"Blocks Library - The following block has been uninstalled : $name");
    }
    
    
    // Function to activate a block (after it has been installed)
    public function activate_block($name)
    {        
        // Update it
        $this->CI->db->where('name',strtolower($name));
        $this->CI->db->update('blocks',array('active' => 'true'));
        
        // Log the results
        //log_message('info',"Blocks Library - The following block has been activated : $name");
    }
    
    
    // Function to deactivate a block (after it has been activated)
    public function deactivate_block($name)
    {
        // Update it
        $this->CI->db->where('name',strtolower($name));
        $this->CI->db->update('blocks',array('active' => 'false'));
        
        // Log the results
        //log_message('info',"Blocks Library - The following block has been deactivated : $name");
    }
    
}
?>