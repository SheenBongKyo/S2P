<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Block_planning_supervisor_model extends MY_Model
{

    public $table = 'block_planning_supervisor';
    public $primaryKey = 'bps_id';
    public $replaceValue = array();

    public function __construct()
    {   
        parent::__construct();
        $this->replaceValue = array(
            'bps_gubun' => config_item('bps_gubun'),
            'bps_field' => config_item('bps_field'),
            'bps_level' => config_item('bps_level'),
        );
    }

}