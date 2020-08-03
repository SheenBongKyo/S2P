<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planning_model extends MY_Model
{

    public $table = 'planning';
    public $primaryKey = 'pln_id';
    public $replaceValue = array();

    public function __construct()
    {   
        parent::__construct();
    }

}