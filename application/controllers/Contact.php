<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Controller to be used by LCs/GLs
class Contact extends CI_Controller
{
    public function index(){
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('content_home');
        $this->load->view('footer');

    }

    public function home(){

    }
}