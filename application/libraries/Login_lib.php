<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_lib extends Common_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(array('Member_model'));
    }

    public function login($userid, $password) 
    {
        $userid = trim($userid);
        $password = trim($password);
        $member = $this->CI->Member_model->getInfo(array('where' => array('mem_userid' => $userid)));
        if (empty($member)) {
            return false;
        }

        if (password_verify($password, $member['mem_password'])) {
            return $this->loginSessionSave($member);
        } else {
            return false;
        }
    }

    private function loginSessionSave($member) 
    {
        $this->CI->session->set_userdata('mem_id', $member['mem_id']);
        $this->CI->session->set_userdata('mem_level', $member['mem_level']);
        $this->CI->session->set_userdata('mem_name', $member['mem_name']);
        return $this->CI->Member_model->updateById($member['mem_id'], array('mem_logined' => date('Y-m-d H:i:s')));
    }

    public function isLogin()
    {
        return $this->CI->session->userdata('mem_id');
    }
    
    public function getLoginInfo($key = "")
    {
        if ($key) {
            return $this->CI->session->userdata($key);
        } else {
            return $this->CI->session->userdata();
        }
    }

    public function logout()
    {
        $this->CI->session->sess_destroy();
    }

}