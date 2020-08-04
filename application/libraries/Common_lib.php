<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common_lib
{
    private $CI;
    public $select;
    public $join;
    public $where;
    public $freeWhere;
    public $like;
    public $groupBy;
    public $orderBy;
    public $limit;
    public $page;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->_init();
    }

    public function _init()
    {
        $this->select = NULL;
        $this->join = NULL;
        $this->where = NULL;
        $this->freeWhere = NULL;
        $this->like = NULL;
        $this->groupBy = NULL;
        $this->orderBy = NULL;
        $this->limit = NULL;
        $this->page = NULL;
    }

    public function getQuery()
    {
        return array(
            'select' => $this->select,
            'join' => $this->join,
            'where' => $this->where,
            'freeWhere' => $this->freeWhere,
            'like' => $this->like,
            'groupBy' => $this->groupBy,
            'orderBy' => $this->orderBy,
            'limit' => $this->limit,
            'page' => $this->page
        );
    }
  
}