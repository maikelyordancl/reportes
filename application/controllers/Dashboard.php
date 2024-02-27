<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
        if(!$this->session->userdata('usuario')){
            redirect('/login');
        }

	    $this->load->view('dashboard/header', array('title' => 'Dashboard'));
        $this->load->view('dashboard/header_menu');
        $this->load->view('dashboard/sidebar_menu');
		$this->load->view('dashboard/content');
        $this->load->view('dashboard/footer');
	}
}
