<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Member_lib extends Common_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(array('Member_model'));
    }
    
}