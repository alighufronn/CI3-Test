<?php

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('UserRoleModel');
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library('upload', 'session');
    }

    public function login()
    {
        $this->load->view('login');
    }
    
    public function login_process() 
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->UserModel->get_user($username, $password);
        if ($user) {
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('name', $user->name);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('role', $user->role);
            $this->session->set_userdata('user_id', $user->id);
            redirect('/');
        } else {
            redirect('login');
        }
    }

    public function logout() 
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('user_id');
        redirect('/login');
    }

    public function users()
    {

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $role = $this->session->userdata('role');
        
        if ($role !== 'admin') {
            redirect()->back();
            return;
        }

        $data['logged_in'] = $this->session->userdata('logged_in');
        $data['name'] = $this->session->userdata('name');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $role;

        $data['title'] = 'User Control';
        $data['pageTitle'] = 'User Control';
        $data['users'] = $this->UserModel->findUser();
        $data['content'] = $this->load->view('admin/users', $data, true);

        $this->load->view('layout/page_layout', $data);
    }
}
?>
