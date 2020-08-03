<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planning_supervisor_model extends MY_Model
{

    public $table = 'planning_supervisor';
    public $primaryKey = 'pls_id';
    public $replaceValue = array();

    public function __construct()
    {   
        parent::__construct();
        $this->replaceValue = array(
            'pls_gubun' => config_item('pls_gubun'),
            'pls_field' => config_item('pls_field'),
            'pls_level' => config_item('pls_level'),
        );
    }

}