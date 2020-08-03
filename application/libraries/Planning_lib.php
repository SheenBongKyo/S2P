<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Planning_lib extends Common_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(array('Planning_model', 'Planning_supervisor_model'));
    }


    /**
     * ========================================================================================
     * 배치 계획표 관련 함수
     * ========================================================================================
     */

    // 배치 계획표 목록
    public function getPlanningList()
    {
        return $this->CI->Planning_model->getList($this->getQuery());
    }

    // 배치 계획표 정보
    public function getPlanningInfoById($id)
    {
        $this->_init();
        $this->select = 'A.*, MIN(B.pls_start_date) as min_date, MAX(B.pls_end_date) as max_date';
        $this->where = array('A.pln_id' => $id);
        $this->join = array('table' => 'planning_supervisor B', 'on' => 'A.pln_id = B.pln_id', 'type' => 'LEFT');
        $this->groupBy = 'A.pln_id';
        return $this->CI->Planning_model->getInfo($this->getQuery());
    }

    // 배치 계획표 등록/수정
    public function planningUpdateById($id = "", $updateData)
    {   
        if ($id) {
            return $this->CI->Planning_model->updateById($id, $updateData);
        } else {
            return $this->CI->Planning_model->update($updateData);
        }
    }

    // 배치 계획표 삭제
    public function planningDeleteById($id) {
        $rs = $this->CI->Planning_model->deleteById($id);
        if ($rs) {
            $data = array('where' => array('pln_id' => $id));
            $this->CI->Planning_supervisor_model->delete($data);
        }
        return $rs;
    }

    // 총배치 인월수
    public function getTotalInwolsu($id) 
    {
        $this->_init();
        $this->select = 'A.*, (TIMESTAMPDIFF(MONTH, A.pls_start_date, A.pls_end_date) + 1) as month_count';
        $this->where = array('A.pln_id' => $id, 'A.pls_gubun !=' => 6); // 추가배치 제외
        $list = $this->CI->Planning_supervisor_model->getList($this->getQuery());

        $result = 0;
        if (!empty($list)) {
            $levelPrice = config_item('pls_level_price');
            foreach ($list as $key => $item) {
                $result += $levelPrice[$item['pls_level']] * $item['month_count'];
            }
        }
        return $result;
    }

    // 법정 인월수
    public function getCourtInwolsu($price)
    {
        $price = $price / 100000000;
        $a = $b = $c = $d = 0;
        if (0 <= $price && $price < 20) {
            $a = 20; 
            $b = 0; 
            $c = 12.1; 
            $d = 0;
        } else if (20 <= $price && $price < 30) {
            $a = 30; 
            $b = 20; 
            $c = 15.5; 
            $d = 12.1;
        } else if (30 <= $price && $price < 50) {
            $a = 50; 
            $b = 30; 
            $c = 19.6; 
            $d = 15.5;
        } else if (50 <= $price && $price < 100) {
            $a = 100; 
            $b = 50; 
            $c = 38.1; 
            $d = 19.6;
        } else if (100 <= $price && $price < 200) {
            $a = 200; 
            $b = 100; 
            $c = 73.8;
            $d = 38.1;
        } else if (200 <= $price && $price < 300) {
            $a = 300; 
            $b = 200; 
            $c = 109.9;
            $d = 73.8;
        } else if (300 <= $price && $price < 500) {
            $a = 500; 
            $b = 300; 
            $c = 163.2;
            $d = 109.9;
        } else if (500 <= $price && $price < 1000) {
            $a = 1000; 
            $b = 500; 
            $c = 277;
            $d = 163.2;
        } else if (1000 <= $price && $price < 2000) {
            $a = 2000; 
            $b = 1000; 
            $c = 472;
            $d = 277;
        } else if (2000 <= $price) {
            $a = 3000; 
            $b = 2000; 
            $c = 645.2;
            $d = 472;
        } else {
            return 0;
        }
        return ($price - $b) / ($a - $b) * ($c - $d) + $d;
    }

    // 비상주감리원 인월수
    public function getTransientInwolsu($id)
    {
        $this->_init();
        $this->select = 'A.*, (TIMESTAMPDIFF(MONTH, A.pls_start_date, A.pls_end_date) + 1) as month_count';
        $this->where = array('A.pln_id' => $id, 'A.pls_gubun' => 3); // 비상주
        $list = $this->CI->Planning_supervisor_model->getList($this->getQuery());

        $result = 0;
        if (!empty($list)) {
            $levelPrice = config_item('pls_level_price');
            foreach ($list as $key => $item) {
                $result += $levelPrice[$item['pls_level']] * $item['month_count'];
            }
        }
        return $result;
    }

    /**
     * ========================================================================================
     * 감리원 관련 함수
     * ========================================================================================
     */
    
    // 배치 계획표 별 감리원 목록
    public function getPlanningSupervisorListByPlnId($id)
    {
        $this->_init();
        $this->select = 'A.*, (TIMESTAMPDIFF(MONTH, A.pls_start_date, A.pls_end_date) + 1) as month_count';
        $this->where = array('A.pln_id' => $id);
        $this->orderBy = 'A.pls_gubun ASC, A.pls_level ASC';
        return $this->CI->Planning_supervisor_model->getList($this->getQuery());
    }

    // 감리원 정보
    public function getPlanningSupervisorInfoById($id)
    {
        $this->_init();
        $this->where = array('A.pls_id' => $id);
        return $this->CI->Planning_supervisor_model->getInfo($this->getQuery());
    }

    // 감리원 등록/수정
    public function planningSupervisorUpdateById($id = "", $updateData)
    {
        if ($id) {
            return $this->CI->Planning_supervisor_model->updateById($id, $updateData);
        } else {
            return $this->CI->Planning_supervisor_model->update($updateData);
        }
    }

    // 감리원 삭제
    public function planningSupervisorDeleteById($id) 
    {
        return $this->CI->Planning_supervisor_model->deleteById($id);
    }

}
