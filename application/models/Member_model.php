<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends MY_Model
{

    public $table = 'member';
    public $primaryKey = 'mem_id';
    public $replaceValue = array();

    public function __construct()
    {   
        parent::__construct();
    }

}