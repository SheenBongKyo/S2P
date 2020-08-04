<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Account_lib extends Common_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(array('Member_model'));
    }
    
    public function getMemberList()
    {
        $this->select = 'A.*, "" AS mem_password';
        return $this->CI->Member_model->getList($this->getQuery());
    }

    public function getMemberInfoById($id)
    {
        $this->_init();
        $this->select = 'A.*, "" AS mem_password';
        $this->where['mem_id'] = $id;
        return $this->CI->Member_model->getInfo($this->getQuery());
    }

    public function memberUpdateById($id = "", $updateData)
    {   
        if (element('mem_password', $updateData)) {
            $updateData['mem_password'] = password_hash($updateData['mem_password'], PASSWORD_DEFAULT);
        } else {
            unset($updateData['mem_password']);
        }
        if ($id) {
            return $this->CI->Member_model->updateById($id, $updateData);
        } else {
            return $this->CI->Member_model->update($updateData);
        }
    }

    public function memberDeleteById($id)
    {
        return $this->CI->Member_model->deleteById($id);
    }

    public function useridOvelap($id = "", $userId)
    {
        $this->_init();
        $this->where['mem_userid'] = trim($userId);
        if ($id) {
            $this->where['mem_id !='] = $id;
        }
        $member = $this->CI->Member_model->getInfo($this->getQuery());
        if (empty($member)) {
            return false;
        } else {
            return true;
        }
    }

}