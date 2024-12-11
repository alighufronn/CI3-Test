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

    public function load_users()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $users = $this->UserModel->get_users();
        echo json_encode($users);
    }

    // public function load_chats()
    // {
    //     if (!$this->session->userdata('logged_in')) {
    //         redirect('login');
    //         return;
    //     }

    //     $user_id = $this->session->userdata('user_id');
        
    //     $getChat = $this->ChatModel->get_chat_by_id($user_id);

    //     if ($getChat) {
    //         echo json_encode(array('status' => 'success', 'chats' => $getChat));
    //     } else {
    //         echo json_encode(array('status' => 'error', 'message' => 'Gagal mengambil data chat.'));
    //     }
    // }

    public function load_chats_with_user()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $current_user_id = $this->session->userdata('user_id');
        $other_user_id = $this->input->get('user_id');

        $getUser = $this->ChatModel->get_chat_sender_receiver($current_user_id, $other_user_id);

        if ($getUser) {
            echo json_encode(array('status' => 'success', 'chats' => $getUser));
        } else {
            echo json_encode(array('status' => 'success', 'chats' => []));
        }
    }

    public function send_chat()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $message = $this->input->post('message');

        if (empty($message)) {
            return;
        }

        $id = $this->input->post('id');
        $id_sender = $this->input->post('id_sender');
        $name_sender = $this->input->post('name_sender');
        $id_receiver = $this->input->post('id_receiver');
        $name_receiver = $this->input->post('name_receiver');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        
        $data = array(
            'id_sender' => $id_sender,
            'name_sender' => $name_sender,
            'message' => $message,
            'id_receiver' => $id_receiver,
            'name_receiver' => $name_receiver,
            'date' => $date,
            'time' => $time,
        );

        $sending = $this->ChatModel->send($data);

        $sent = $this->ChatModel->get_chat_by_id($sending);

        if ($sent) {
            echo json_encode(array('status' => 'success', 'chats' => $sent, 'message' => 'Pesan berhasil dikirim'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengirim pesan'));
        }
    }

    public function delete_chat()
    {
        $id = $this->input->post('id');

        $deleteChat = $this->ChatModel->delete($id);

        if ($deleteChat) {
            echo json_encode(array('status' => 'success', 'chats' => $deleteChat, 'message' => 'Pesan berhasil dihapus'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus pesan'));
        }
    }
}