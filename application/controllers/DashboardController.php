<?php

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library('upload', 'session');
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $data['logged_in'] = $this->session->userdata('logged_in');
        $data['name'] = $this->session->userdata('name');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        $data['title'] = 'Dashboard';
        $data['content'] = $this->load->view('dashboard', $data, true);

        $this->load->view('layout/page_layout', $data);
    }
}