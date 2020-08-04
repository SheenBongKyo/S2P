<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Build {

    private $defaultHead = 'common/head';
    private $defaultHeader = 'common/header';
    private $defaultHeaderNav = 'json/headerNav.json';
    private $defaultLayout = 'common/layout';
    private $defaultFooter = 'common/footer';

    public $head = null, $header = null, $headerNav = null, $contents = null, $footer = null, $data = array();
    public $addCss = array();
    public $addJs = array();

    public function __construct()
    {   
        $this->CI =& get_instance();
        $this->setImp('head', $this->defaultHead, array('build' => $this));
        $this->setImp('headerNav', $this->defaultHeaderNav, array('build' => $this));
        $this->setImp('header', $this->defaultHeader, array('build' => $this));
        $this->setImp('footer', $this->defaultFooter, array('build' => $this));
    }

    public function setImp($var, $url, $data = array())
    {
        if ($url) {
            if ($var == 'headerNav') {
                $headerNav = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $url), true);
                foreach ($headerNav as $idx => $item) {
                    if (isset($item['accessLevel']) && !in_array($this->CI->login_lib->getInfo('mem_level'), $item['accessLevel'])) {
                        unset($headerNav[$idx]);
                    }
                }
                $this->{$var} = $headerNav;
            } else {
                $this->{$var} = $this->CI->load->view($url, $data, true);
            }
        } else if ($url == NULL){
            $this->{$var} = NULL;
        }
    }

    public function setHeaderNav()
    {
        
    }

    public function addCss($cssUrl) {
        $this->addCss[] = $cssUrl;
        $this->setImp('head', $this->defaultHead, array('build' => $this));
    }

    public function addJs($jsUrl) {
        $this->addJs[] = $jsUrl;
        $this->setImp('head', $this->defaultHead, array('build' => $this));
    }

    public function view($contentsUrl, $data = array()) 
    {
        $this->setImp('contents', $contentsUrl, $data);
        $this->CI->load->view($this->defaultLayout, array('build' => $this));
    }
    
}