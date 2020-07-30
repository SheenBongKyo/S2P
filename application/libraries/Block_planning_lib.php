<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Block_planning_lib extends Common_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(array('Block_planning_model', 'Block_planning_supervisor_model'));
    }

    // 감리원 배치 계획표 목록
    public function getBlockPlanningList()
    {
        return $this->CI->Block_planning_model->getList($this->getQuery());
    }

    // 감리원 배치 계획표 등록/수정
    public function blockPlanningUpdateById($id = "", $updateData)
    {   
        if ($id) {
            return $this->CI->Block_planning_model->updateById($id, $updateData);
        } else {
            return $this->CI->Block_planning_model->update($updateData);
        }
    }

    // 감리원 배치 계획표 삭제
    public function blockPainningDeleteById($id) {
        $rs = $this->CI->Block_planning_model->deleteById($id);
        if ($rs) {
            $data = array('where' => array('bpi_id' => $id));
            $this->CI->Block_planning_supervisor_model->delete($data);
        }
        return $rs;
    }

    // 감리원 배치 계획표 정보 + 최소날짜 + 최대날짜
    public function getBlockPlanningInfoAndPeriodById($id)
    {
        $this->_init();
        $this->select = 'A.*, MIN(B.bps_start_date) as min_date, MAX(B.bps_end_date) as max_date';
        $this->where = array('A.bpi_id' => $id);
        $this->join = array('table' => 'block_planning_supervisor B', 'on' => 'A.bpi_id = B.bpi_id', 'type' => 'LEFT');
        $this->groupBy = 'A.bpi_id';
        return $this->CI->Block_planning_model->getInfo($this->getQuery());
    }

    // 배치된 감리원 목록 + 개월
    public function getBlockPlanningSupervisorListAndMonthCountByBpiId($id)
    {
        $this->_init();
        $this->select = 'A.*, (TIMESTAMPDIFF(MONTH, A.bps_start_date, A.bps_end_date) + 1) as month_count';
        $this->where = array('A.bpi_id' => $id);
        $this->orderBy = 'A.bps_gubun ASC, A.bps_level ASC';
        return $this->CI->Block_planning_supervisor_model->getList($this->getQuery());
    }

    // 감리원 등록/수정
    public function blockPlanningSupervisorUpdateById($id = "", $updateData)
    {
        if ($id) {
            return $this->CI->Block_planning_supervisor_model->updateById($id, $updateData);
        } else {
            return $this->CI->Block_planning_supervisor_model->update($updateData);
        }
    }

    // 감리원 삭제
    public function blockPlanningSupervisorDeleteById($id) {
        return $this->CI->Block_planning_supervisor_model->deleteById($id);
    }
}
