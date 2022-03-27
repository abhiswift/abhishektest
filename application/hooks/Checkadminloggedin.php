<?php
class Checkadminloggedin
{
    /**
     * loading the CI instance
     * @var [object]
     */
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');//working with sessions - you want sessions 
        //to be loaded ASAP so better way would be having it in 
        //APPPATH.'config/autoload.php' instead in all classes

        /** 
         * @tutorial how to exclude hook interaction with particular class/controller
         */
        $this->CI->load->helper('url');
    }

    /**
     * Check the enduser for login verify, every time when the enduser
     * loads the controller.
     */
    public function check_admin_login() 
    {
        /**
        *  if end user is not logged in, redirect to the login page
        */  
        if ( strtolower( $this->CI->router->class ) == 'dashboardadmin')
        {
            if(!isset($_SESSION['AdminloggedIn']))
	        {
	            //$this->CI->session->set_tempdata('faliure','Please sign in to continue');
	            $this->CI->session->sess_destroy();
	            redirect(base_url('admincontrol'));
	        }
        }
        
    }
}