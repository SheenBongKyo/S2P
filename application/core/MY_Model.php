<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $table;
    protected $primaryKey;
    protected $replaceValue;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->table ? $this->table." A" : Null; 
    }

    private function _setQuery($data, $sop = "AND")
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                switch ($key) {
                    case 'select':
                        $this->db->select($value);
                        break;
                    case 'join':
                        if (!empty($value['table']) && !empty($value['on'])) {
                            $value['type'] = isset($value['type']) ? $value['type'] : "INNER";
                            $this->db->join($value['table'], $value['on'], $value['type']);
                        } else {
                            foreach ($value as $key2 => $join) {
                                $join['type'] = isset($join['type']) ? $join['type'] : "INNER";
                                $this->db->join($join['table'], $join['on'], $join['type']);
                            }
                        }
                        break;
                    case 'where':
                        $this->db->group_start();
                        if (strtoupper($sop) == "AND") {
                            $this->db->where($value);
                        } else {
                            $this->db->or_where($value);
                        }           
                        $this->db->group_end();
                        break;
                    case 'freeWhere':
                        $this->db->group_start();
                        if (strtoupper($sop) == "AND") {
                            $this->db->where($value, null, false);
                        } else {
                            $this->db->or_where($value, null, false);
                        }           
                        $this->db->group_end();
                        break;
                    case 'like':
                        $this->db->group_start();
                        if (strtoupper($sop) == "AND") {
                            $this->db->like($value);
                        } else {
                            $this->db->or_like($value);
                        }           
                        $this->db->group_end();
                        break;
                    case 'groupBy':
                        $this->db->group_by($value);
                        break;
                    case 'limit':
                        if (!empty((int)$value)) {
                            if (isset($terms['page']) && !empty((int)$terms['page'])) {
                                $offset = ((int)$terms['page'] - 1) * (int)$value;
                            } else {
                                $offset = '';
                            }
                            $this->db->limit($value, $offset);
                        }
                        break;
                    case 'orderBy':
                        if (is_array($value)) {
                            foreach ($value as $index => $order) {
                                $this->db->order_by($index, $order);
                            }
                        } else {
                            $this->db->order_by($value);
                        }
                    break;
                }
            }
        }
    }

    public function getList($data = array()) 
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of getList function";
            exit;
        }
        
        if (!isset($data['orderBy'])) $data['orderBy'] = $this->primaryKey." DESC";

        $this->db->reset_query();
        $this->db->from($this->table);
        $this->_setQuery($data);
        $qry = $this->db->get();
        $list = $this->replaceValueFunc($qry->result_array(), __FUNCTION__);

        if (isset($data['limit']) && isset($data['page'])) {
            unset($data['select']);
            unset($data['limit']);
            unset($data['page']);

            $this->db->reset_query();
            $this->db->from($this->table);
            $this->db->select('count(*) as rownum');
            $this->_setQuery($data);

            $qry = $this->db->get();
            $rows = $qry->row_array();
            $count = $rows['rownum'];
            return array('list' => $list, 'count' => $count);
        } else {
            return $list;
        }
    }

    public function getInfo($data = array()) 
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of getInfo function";
            exit;
        }

        $this->db->reset_query();
        $this->db->from($this->table);
        $this->_setQuery($data);
        $qry = $this->db->get();
        $result = $this->replaceValueFunc($qry->row_array(), __FUNCTION__);
        return $result;
    }

    public function getInfoById($id)
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of getInfoById function";
            exit;
        }

        $data = array('where' => array($this->primaryKey => $id));
        $result = $this->getInfo($data);
        return $result;
    }

    public function getCount($data = array()) 
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of getCount function";
            exit;
        }

        $this->db->reset_query();
        $this->db->from($this->table);
        $this->_setQuery($data);
        return $this->db->count_all_results();
    }
    
    public function update($updateData, $data = array()) 
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of update function";
            exit;
        }

        if (empty($updateData)) return false;

        $this->db->reset_query();
        $this->db->set($updateData);
        if (empty(element('where', $data)) && empty(element('freeWhere', $data)) && empty(element('like', $data))) {
            $result = $this->db->insert(str_replace(' A', '', $this->table));
            if ($result) $result = $this->db->insert_id();
        } else {
            $this->_setQuery($data);
            $result = $this->db->update(str_replace(' A', '', $this->table));
        }
        return $result;
    }

    public function updateById($id, $updateData)
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of updateById function";
            exit;
        }

        unset($updateData[$this->primaryKey]);
        $data = array('where' => array($this->primaryKey => $id));
        $result = $this->update($updateData, $data);
        return $result;
    }

    public function delete($data)
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of delete function";
            exit;
        }

        if (empty(element('where', $data)) && empty(element('freeWhere', $data)) && empty(element('like', $data))) {
            echo "The delete function requires where or freeWhere or like";
            exit;
        
        }
        $this->db->reset_query();
        $this->_setQuery($data);
        $result = $this->db->delete(str_replace(' A', '', $this->table));
        return $result;
    }

    public function deleteById($id)
    {
        if (empty($this->table) || empty($this->primaryKey)) {
            echo "Please set table and primaryKey of deleteById function";
            exit;
        }
        
        $data = array('where' => array($this->primaryKey => $id));
        $result = $this->delete($data);
        return $result;
    }

    private function replaceValueFunc($data = array(), $func)
    {
        if (empty($this->replaceValue) || empty($data)) return $data;
        if ($func == 'getList') {
            foreach($data as $idx => $item) {
                foreach ($item as $key => $value) {
                    if (empty($value)) continue;
                    if (array_key_exists($key, $this->replaceValue) && array_key_exists($value, $this->replaceValue[$key])) {
                        $data[$idx][$key.'_rv'] = $this->replaceValue[$key][$value];
                    }
                }
            }
        } else if ($func == 'getInfo') {
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                if (array_key_exists($key, $this->replaceValue) && array_key_exists($value, $this->replaceValue[$key])) {
                    $data[$key.'_rv'] = $this->replaceValue[$key][$value];
                }
            }
        }
        return $data;
    }

}