<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Block_planning_model extends MY_Model
{

    public $table = 'block_planning';
    public $primaryKey = 'bpi_id';
    public $replaceValue = array();

    public function __construct()
    {   
        parent::__construct();
    }

}