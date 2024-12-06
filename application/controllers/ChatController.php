<?php

class ChatController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('ChatModel');
        $this->load->model('UserModel');
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
        $data['id_user'] = $this->session->userdata('user_id');
        $data['title'] = 'Chat';
        $data['pageTitle'] = 'Chit Chat';
        $data['content'] = $this->load->view('chat', $data, true);

        $this->load->view('layout/page_layout', $data);
    }

    public function load_chats()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $id_sender = $this->session->userdata('user_id');

        $chatSent = $this->ChatModel->get_sender_by_id($id_sender);
        echo json_encode(array('status' => 'success', 'chats' => $chatSent));
    }
}