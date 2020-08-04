<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $data = array();

    function __construct()
    {      
        parent::__construct();
        $this->allow = array('login');
        $this->data = array();
        $this->load->library(array('account_lib'));
    }

	public function index()
	{
        $this->build->view('home', $this->data);
    }

    public function login()
	{
        $this->form_validation->set_rules('mem_userid', '아이디', 'required');
        $this->form_validation->set_rules('mem_password', '비밀번호', 'required');
        if ($this->form_validation->run() !== false) {

            $post = $this->input->post();
            if ($this->login_lib->login($post['mem_userid'], $post['mem_password'])) {
                echo successMsg('redirect:'.base_url());
            } else {
                echo validationFailMsg('<p class="mb0 fs15"><i class="fas fa-exclamation-circle"></i> 아이디 또는 비밀번호가 일치하지 않습니다.</p>');
            }

        } else if ($_POST) {

            echo validationFailMsg($this->form_validation->error_string());

        } else {
            $this->login_lib->logout();
            $this->build->setImp('header', NULL, array('build' => $this->build));
            $this->build->setImp('footer', NULL, array('build' => $this->build));
            $this->build->view('login', $this->data);
        }
    }

    public function logout()
	{
        $this->login_lib->logout();
        redirect(base_url('login'));
    }
    
    public function ajax_accountSet()
    {
        $this->form_validation->set_rules('mem_name', '회원명', 'required');
        if ($this->form_validation->run() !== false) {

            $post = $this->input->post();

            $rs = $this->account_lib->memberUpdateById($this->login_lib->getInfo('mem_id'), $post);
            if ($rs) {
                $member = $this->account_lib->getMemberInfoById($this->login_lib->getInfo('mem_id'));
                $this->login_lib->loginSessionSave($member);
                echo successMsg("", true);
            } else {
                echo failMsg("계정 설정에 실패하였습니다.");
            }   
            
        } else if ($_POST) {

            echo validationFailMsg($this->form_validation->error_string());

        }
    }
}
