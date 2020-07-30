<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $data = array();

    function __construct()
    {      
        parent::__construct();
        $this->data = array();
        $this->load->library(array('block_planning_lib'));
    }

	public function index()
	{
        $this->form_validation->set_rules('bpi_subject', '사업명', 'required');
        if ($this->form_validation->run() !== false) {
            
            $post = $this->input->post();
            $rs = $this->block_planning_lib->blockPlanningUpdateById("", $post);
            if ($rs) {
                echo success("감리원 배치 계획표 등록에 성공하였습니다.", true);
            } else {
                echo fail("감리원 배치 계획표 등록에 실패하였습니다.");
            }         

        } else if ($_POST) {

            echo validationFail($this->form_validation->error_string());

        } else {
            $this->block_planning_lib->_init();
            $this->data['blockPlanningList'] = $this->block_planning_lib->getBlockPlanningList();
            $this->load->view('home', $this->data);
        }
    }
    
    public function info()
    {
        $this->form_validation->set_rules('bpi_id', '배치계획표 고유번호', 'required');
        $this->form_validation->set_rules('bps_gubun', '구분', 'required');
        $this->form_validation->set_rules('bps_field', '분야', 'required');
        $this->form_validation->set_rules('bps_name', '성명', 'required');
        $this->form_validation->set_rules('bps_level', '등급', 'required');
        $this->form_validation->set_rules('bps_start_date', '시작일', 'required');
        $this->form_validation->set_rules('bps_end_date', '종료일', 'required');
        if ($this->form_validation->run() !== false) {

            $post = $this->input->post();
            $rs = $this->block_planning_lib->blockPlanningSupervisorUpdateById(element('bps_id', $post), $post);
            if ($rs) {
                echo success("감리원 등록에 성공하였습니다.", true);
            } else {
                echo fail("감리원 등록에 실패하였습니다.");
            }   
            
        } else if ($_POST) {

            echo validationFail($this->form_validation->error_string());

        } else {
            $id = $this->input->get('id');
            $this->data['blockPlanning'] = $blockPlanning = $this->block_planning_lib->getBlockPlanningInfoAndPeriodById($id);
            
            $this->data['headerDate'] = $headerDate = array();
            $this->data['monthCount'] = $monthCount = diffMonthCount($blockPlanning['min_date'], $blockPlanning['max_date']);
            if ($monthCount > 0) {
                for ($i = 0; $i < $monthCount; $i++) {
                    $year = date('Y', strtotime(substr($blockPlanning['min_date'], 0, 7)." +".$i."month"));    
                    $month = date('m', strtotime(substr($blockPlanning['min_date'], 0, 7)." +".$i."month"));    
                    $headerDate[$year][] = $month;
                }
                $this->data['headerDate'] = $headerDate;
            }

            $this->data['blockPlanningSupervisorList'] = 
            $blockPlanningSupervisorList = 
            $this->block_planning_lib->getBlockPlanningSupervisorListAndMonthCountByBpiId($blockPlanning['bpi_id']);

            $gubunRows = array();
            foreach ($blockPlanningSupervisorList as $key => $item) {
                if (!isset($gubunRows[$item['bps_gubun']])) {
                    $gubunRows[$item['bps_gubun']] = array();
                }
                $gubunRows[$item['bps_gubun']][] = $item['bps_id'];
            }
            $this->data['gubunRows'] = $gubunRows;

            $this->data['bpsGubun'] = $bpsGubun = config_item('bps_gubun');
            $this->data['bpsField'] = $bpsField = config_item('bps_field');
            $this->data['bpsLevel'] = $bpsLevel = config_item('bps_level');
            $this->data['bpsLevelPrice'] = $bpsLevelPrice = config_item('bps_level_price');
    
            $this->load->view('info', $this->data);
        }
    }

    public function blockPainningDelete()
    {
        $this->form_validation->set_rules('bpi_id', '감리원 배치 계획표 고유번호', 'required');
        if ($this->form_validation->run() !== false) {

            $bpsId = $this->input->post('bpi_id');
            $rs = $this->block_planning_lib->blockPainningDeleteById($bpsId);
            if ($rs) {
                echo success("감리원 배치 계획표 삭제에 성공하였습니다.", true);
            } else {
                echo fail("감리원 배치 계획표 삭제에 실패하였습니다.");
            }   

        } else {
            echo fail("감리원 배치 계획표 삭제에 실패하였습니다.");
        }
    }

    public function blockPainningSupervisorDelete()
    {
        $this->form_validation->set_rules('bps_id', '감리사 고유번호', 'required');
        if ($this->form_validation->run() !== false) {

            $bpsId = $this->input->post('bps_id');
            $rs = $this->block_planning_lib->blockPlanningSupervisorDeleteById($bpsId);
            if ($rs) {
                echo success("감리원 삭제에 성공하였습니다.", true);
            } else {
                echo fail("감리원 삭제에 실패하였습니다.");
            }   

        } else {
            echo fail("감리원 삭제에 실패하였습니다.");
        }
    }
}
