<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Build {

    private $defaultHead = 'common/head';
    private $defaultHeader = 'common/header';
    private $defaultLayout = 'common/layout';
    private $defaultFooter = 'common/footer';

    public $head = null, $header = null, $contents = null, $footer = null, $data = array();
    public $addCss = array();
    public $addJs = array();

    public function __construct()
    {   
        $this->CI =& get_instance();
        $this->setImp('head', $this->defaultHead, array('build' => $this));
        $this->setImp('header', $this->defaultHeader, array('build' => $this));
        $this->setImp('footer', $this->defaultFooter, array('build' => $this));
    }

    public function setImp($var, $url, $data = array())
    {
        if ($url) {
            $this->{$var} = $this->CI->load->view($url, $data, true);
        } else if ($url == NULL){
            $this->{$var} = NULL;
        }
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