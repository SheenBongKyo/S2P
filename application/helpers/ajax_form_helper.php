<?php
function validationFailMsg($msg)
{
    return json_encode(
        array(
            'resultCode' => config_item('VALIDATION_FAIL_CODE'), 
            'msg' => '<div class="alert alert-danger">'.$msg.'<div>'
        )
    );
}

function successData($data, $reload = false)
{
    return json_encode(
        array(
            'resultCode' => config_item('SUCCESS_CODE'), 
            'data' => $data,
            'reload' => $reload
        )
    );
}

function failData($data, $reload = false)
{
    return json_encode(
        array(
            'resultCode' => config_item('FAIL_CODE'), 
            'data' => $data,
            'reload' => $reload
        )
    );
}

function successMsg($msg = "", $reload = false)
{
    return json_encode(
        array(
            'resultCode' => config_item('SUCCESS_CODE'), 
            'msg' => $msg,
            'reload' => $reload
        )
    );
}

function failMsg($msg = "잘못된 접근입니다.", $reload = false)
{
    return json_encode(
        array(
            'resultCode' => config_item('FAIL_CODE'), 
            'msg' => $msg,
            'reload' => $reload
        )
    );
}

function notFoundMsg($msg = "해당 데이터가 존재하지 않습니다.", $reload = false)
{
    return json_encode(
        array(
            'resultCode' => config_item('NOT_FOUND_CODE'), 
            'msg' => $msg,
            'reload' => $reload
        )
    );
}