<?php
function getMonthDiff($start = "", $end = "")
{
    if ($start && $end) {
        $startYear = date('Y', strtotime($start));
        $startMonth = date('m', strtotime($start));
        $endYear = date('Y', strtotime($end));
        $endMonth = date('m', strtotime($end));
        $monthDiff = (($endYear * 12) + $endMonth) - (($startYear * 12) + $startMonth) + 1;
        return $monthDiff;
    } else {
        return 0;
    }
}

function getInput($getKey)
{
    $result = "";
    $REQUEST_URI = explode("?", $_SERVER['REQUEST_URI']);
    if (isset($REQUEST_URI[1])) {
        $paramsArr = explode("&", $REQUEST_URI[1]);
        foreach ($paramsArr as &$value) {
            $valueArr = explode("=", $value);
            if ($valueArr[0] == $getKey) {
                $result = urldecode($valueArr[1]);
                break;
            }
        }
    }
    return $result;
} 

function getLimit($limit = false) 
{
    if ($limit) {
        return $limit;
    } else {
        return getInput('limit') ? getInput('limit') : config_item('defaultLimit');
    }
}

function getPage()
{
    return getInput('page') ? getInput('page') : 1;
}

function getUri() 
{
    $REQUEST_URI = explode('?', $_SERVER['REQUEST_URI']);
    return $REQUEST_URI[0];
}

function getParamString($addParams = array()) 
{
    $parmas = "";
    $REQUEST_URI = explode("?", $_SERVER['REQUEST_URI']);
    if (isset($REQUEST_URI[1])) {
        $parmas = $REQUEST_URI[1];
    }
    if (!empty($addParams)) {
        if ($parmas) {
            $parmasArr = explode("&", $parmas);
            foreach($addParams as $key => $value) {
                $is = false;
                foreach ($parmasArr as $idx => $param) {
                    $paramArr = explode("=", $param);
                    if ($paramArr[0] == $key) {
                        $is = true;
                        $parmasArr[$idx] = $key.'='.$value;
                        break;
                    }
                }
                if (!$is) {
                    $parmasArr[] = $key.'='.$value;
                }
            }
            $parmas = implode("&", $parmasArr);
        } else {
            $parmasArr = array();
            foreach ($addParams as $key => $value) {
                $parmasArr[] = $key.'='.$value;
            }
            $parmas = implode("&", $parmasArr);
        }
    }
    return $parmas ? "?" . $parmas : "";
}

function alert($msg='', $url='') {
    $CI =& get_instance();
    if (!$msg) $msg = '잘못된 접근입니다.';
   
    echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
    echo "<script type='text/javascript'>alert('".$msg."');";
       if ($url) {
           echo "
               if (window.parent.length > 0) {
                   window.parent.location.replace('".$url."');
               } else {
                   location.replace('".$url."');
               }
           ";
       } else {
           echo "history.go(-1);";
       }
    echo "</script>";
    exit;
   }