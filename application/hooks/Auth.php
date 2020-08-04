<?php
class Auth {
    function checkPermission()
    {
        $CI =& get_instance();
        if (isset($CI->allow) && in_array($CI->router->method, $CI->allow) === false)
        {
            if (!$CI->login_lib->isLogin()) {
                redirect(base_url('login'));
            }
        }
    }
}
?>