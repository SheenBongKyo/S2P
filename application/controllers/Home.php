<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $data = array();

    function __construct()
    {      
        parent::__construct();
        $this->data = array();
        $this->load->library(array());
    }

	public function index()
	{
        redirect(base_url('planning'));
        $this->build->view('home', $this->data);
    }
    
}
