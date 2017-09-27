<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Controller to be used by LCs/GLs
class Terms extends CI_Controller
{
    public function index(){
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('content_terms');
        $this->load->view('footer');

    }
    //TODO REMOVE
    public function test(){
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('content_registrationSuccess');
        $this->load->view('footer');
    }
}