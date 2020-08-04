<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    private $data = array();

    function __construct()
    {      
        parent::__construct();
        $this->allow = array();
        $this->data = array();
        $this->load->library(array('account_lib'));

        $memLevel = $this->login_lib->getInfo('mem_level');
        if ($memLevel > 2) {
            alert();
        }
    }

	public function index()
	{
        $this->form_validation->set_rules('mem_level', '회원 유형', 'required');
        $this->form_validation->set_rules('mem_userid', '아이디', 'required');
        $this->form_validation->set_rules('mem_name', '회원명', 'required');
        if ($_POST && !$_POST['mem_id']) {
            $this->form_validation->set_rules('mem_password', '비밀번호', 'required');
        }
        if ($this->form_validation->run() !== false) {

            $post = $this->input->post();

            if ($this->account_lib->useridOvelap(element('mem_id', $post), $post['mem_userid'])) {
                echo validationFailMsg('<p class="mb0 fs15"><i class="fas fa-exclamation-circle"></i> 이미 사용중인 아이디 입니다.</p>');
                exit;
            }

            $rs = $this->account_lib->memberUpdateById(element('mem_id', $post), $post);
            if ($rs) {
                echo successMsg("", true);
            } else {
                echo failMsg("계정 ".(element('mem_id', $post) ? "수정" : "등록")."에 실패하였습니다.");
            }   
            
        } else if ($_POST) {

            echo validationFailMsg($this->form_validation->error_string());

        } else {
            $this->account_lib->_init();
            $this->account_lib->limit = $limit = getLimit();
            $this->account_lib->page = $page = getPage();
            $this->data['member'] = $member = $this->account_lib->getMemberList();
    
            // 페이징
            $this->load->library('pagination_lib');
            $this->data['paging'] = $this->pagination_lib->getPaging($member['count'], $limit, $page);
    
            $this->data['memLevel'] = $memLevel = config_item('mem_level');
    
            $this->build->view('account/index', $this->data);
        }
    }

    public function ajax_getMemberInfo()
    {
        $id = (int)$this->input->get('id');
        if (!$id) {
            echo failMsg();
            exit;
        }

        $member = $this->account_lib->getMemberInfoById($id);
        if (empty($member)) {
            echo notFoundMsg();
            exit;
        }

        echo successData($member);
    }

    public function ajax_memberRemove()
    {
        $id = (int)$this->input->post('id');
        if (!$id) {
            echo failMsg();
            exit;
        }

        $rs = $this->account_lib->memberDeleteById($id);
        if ($rs) {
            echo successMsg("", true);
        } else {
            echo failMsg("계정 삭제에 실패하였습니다.");
        }
    }

}