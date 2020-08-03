<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planning extends CI_Controller {

    private $data = array();

    function __construct()
    {      
        parent::__construct();
        $this->data = array();
        $this->load->library(array('planning_lib'));
    }

	public function index()
	{
        $this->form_validation->set_rules('pln_subject', '사업명', 'required');
        $this->form_validation->set_rules('pln_price', '감리대상공사비', 'required');
        if ($this->form_validation->run() !== false) {
            
            $post = $this->input->post();
            $post['pln_price'] = str_replace(',', '', $post['pln_price']);
            $rs = $this->planning_lib->planningUpdateById(element('pln_id', $post), $post);
            if ($rs) {
                echo successMsg("", true);
            } else {
                echo failMsg("배치 계획표 ".(element('pln_id', $post) ? "수정" : "등록")."에 실패하였습니다.");
            }

        } else if ($_POST) {

            echo validationFailMsg($this->form_validation->error_string());

        } else {
            $this->planning_lib->_init();
            $this->data['planning'] = $planning = $this->planning_lib->getPlanningList();

            $this->build->view('planning/index', $this->data);
        }
    }

    public function ajax_getPlanningInfo()
    {
        $id = (int)$this->input->get('id');
        if (!$id) {
            echo failMsg();
            exit;
        }

        // 배치 계획표 정보
        $planning = $this->planning_lib->getPlanningInfoById($id);
        if (empty($planning)) {
            echo notFoundMsg();
            exit;
        }

        echo successData($planning);
    }

    public function ajax_planningRemove()
    {
        $id = (int)$this->input->post('id');
        if (!$id) {
            echo failMsg();
            exit;
        }

        // 배치 계획표 삭제
        $rs = $this->planning_lib->planningDeleteById($id);
        if ($rs) {
            echo successMsg("", true);
        } else {
            echo failMsg("배치 계획표 삭제에 실패하였습니다.");
        }
    }

    public function info()
    {
        $id = (int)$this->uri->segment(3);

        $this->form_validation->set_rules('pls_gubun', '구분', 'required');
        $this->form_validation->set_rules('pls_field', '분야', 'required');
        $this->form_validation->set_rules('pls_name', '성명', 'required');
        $this->form_validation->set_rules('pls_level', '등급', 'required');
        $this->form_validation->set_rules('pls_start_date', '시작일', 'required');
        $this->form_validation->set_rules('pls_end_date', '종료일', 'required');
        if ($this->form_validation->run() !== false) {

            $post = $this->input->post();
            $post['pln_id'] = $id;
            $rs = $this->planning_lib->planningSupervisorUpdateById(element('pls_id', $post), $post);
            if ($rs) {
                echo successMsg("", true);
            } else {
                echo failMsg("감리원 ".(element('pls_id', $post) ? "수정" : "등록")."에 실패하였습니다.");
            }   
            
        } else if ($_POST) {

            echo validationFailMsg($this->form_validation->error_string());

        } else {
            // 배치 계획표 정보
            $this->data['planning'] = $planning = $this->planning_lib->getPlanningInfoById($id);

            // 표 상단 날짜 계산
            $this->data['headerDate'] = $headerDate = array();
            $this->data['monthCount'] = $monthCount = getMonthDiff($planning['min_date'], $planning['max_date']);
            if ($monthCount > 0) {
                for ($i = 0; $i < $monthCount; $i++) {
                    $year = date('Y', strtotime(substr($planning['min_date'], 0, 7)." +".$i."month"));    
                    $month = date('m', strtotime(substr($planning['min_date'], 0, 7)." +".$i."month"));    
                    $headerDate[$year][] = $month;
                }
                $this->data['headerDate'] = $headerDate;
            }

            // 배치된 감리원 목록
            $this->data['planningSupervisor'] = 
            $planningSupervisor= 
            $this->planning_lib->getPlanningSupervisorListByPlnId($planning['pln_id']);

            // 구분 rowspan 설정
            $gubunRows = array();
            foreach ($planningSupervisor as $key => $item) {
                if (!isset($gubunRows[$item['pls_gubun']])) {
                    $gubunRows[$item['pls_gubun']] = array();
                }
                $gubunRows[$item['pls_gubun']][] = $item['pls_id'];
            }
            $this->data['gubunRows'] = $gubunRows;

            // 총배치 인월수
            $this->data['totalInwolsu'] = 
            $totalInwolsu = 
            $this->planning_lib->getTotalInwolsu($planning['pln_id']);

            // 법정 인월수
            $this->data['courtInwolsu'] = 
            $courtInwolsu = 
            $this->planning_lib->getCourtInwolsu($planning['pln_price']);

            // 비상주감리원 인월수
            $this->data['transientInwolsu'] = 
            $transientInwolsu = 
            $this->planning_lib->getTransientInwolsu($planning['pln_id']);

            // 비상주감리원 퍼센트
            if ($transientInwolsu > 0) {
                $transientInwolsuPercent = $transientInwolsu / $courtInwolsu * 100;
            } else {
                $transientInwolsuPercent = 0;
            }
            $this->data['transientInwolsuPercent'] = $transientInwolsuPercent;
            
            $this->data['plsGubun'] = $plsGubun = config_item('pls_gubun');
            $this->data['plsField'] = $plsField = config_item('pls_field');
            $this->data['plsLevel'] = $plsLevel = config_item('pls_level');
            $this->data['plsLevelPrice'] = $plsLevelPrice = config_item('pls_level_price');
            
            $this->build->addJs(base_url('assets/js/printThis.js'));
            $this->build->view('planning/info', $this->data);
        }
    }

    public function ajax_getPlanningSurpervisorInfo()
    {
        $id = (int)$this->input->get('id');
        if (!$id) {
            echo failMsg();
            exit;
        }

        // 배치 계획표 정보
        $planning = $this->planning_lib->getPlanningSupervisorInfoById($id);
        if (empty($planning)) {
            echo notFoundMsg();
            exit;
        }

        echo successData($planning);
    }

    public function ajax_planningSupervisorRemove()
    {
        $id = (int)$this->input->post('id');
        if (!$id) {
            echo failMsg();
            exit;
        }

        // 배치 계획표 삭제
        $rs = $this->planning_lib->planningSupervisorDeleteById($id);
        if ($rs) {
            echo successMsg("", true);
        } else {
            echo failMsg("감리원 삭제에 실패하였습니다.");
        }
    }

}
