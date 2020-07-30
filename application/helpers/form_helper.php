<?php
function validationFail($msg)
{
    return json_encode(
        array(
            'resultCode' => 400, 
            'msg' => '<div class="alert alert-danger">'.$msg.'<div>'
        )
    );
}

function success($msg, $reload = false)
{
    return json_encode(
        array(
            'resultCode' => 200, 
            'msg' => $msg,
            'reload' => $reload
        )
    );
}

function fail($msg)
{
    return json_encode(
        array(
            'resultCode' => 201, 
            'msg' => $msg
        )
    );
}