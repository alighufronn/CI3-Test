<?php

class todoController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('todoModel');
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
        $data['title'] = 'To Do List';
        $data['pageTitle'] = 'To Do List';
        $data['content'] = $this->load->view('todolist', $data, true);

        $this->load->view('layout/page_layout', $data);
    }

    public function loads()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $id_user = $this->session->userdata('user_id');

        $todos = $this->todoModel->get_by_user_id($id_user);
        echo json_encode($todos);

    }

    public function add_todo()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $title = $this->input->post('title');
        $status = $this->input->post('status');
        $id_user = $this->input->post('id_user');

        $data = array(
            'title' => $title,
            'status' => $status,
            'id_user' => $id_user
        );

        $inserted_id = $this->todoModel->insert($data);

        $newData = $this->todoModel->get_data_by_id($inserted_id);
        echo json_encode(array('status' => 'success', 'todo' => $newData, 'message' => 'Data berhasil ditambahkan'));
        
    }

    public function get_todo()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $id = $this->input->post('id');

        $data = $this->todoModel->get_data_by_id($id);
        
        if ($data) {
            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menampilkan data'));
        }
    }

    public function update_todo()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $id = $this->input->post('id');
        $title = $this->input->post('title');

        $data = array(
            'title' => $title,
        );

        $updateSuccesful = $this->todoModel->update($id, $data);

        if($updateSuccesful) {
            $updatedData = $this->todoModel->get_data_by_id($id);
            echo json_encode(array('status' => 'success', 'todo' => $updatedData, 'message' => 'Data berhasil di-update'));
        } else {
            echo json_encode(array('status' => 'success', 'message' => 'Gagal mengupdate data'));
        }
    }

    public function save_position()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $item_id = $this->input->post('item_id');
        $new_status = $this->input->post('new_status');

        $this->todoModel->update_status($item_id, $new_status);

        echo json_encode(array('status' => 'success', 'message' => 'Posisi berhasil diupdate'));
    }

    public function delete_todo()
    {
        $id = $this->input->post('id');

        $delete = $this->todoModel->delete($id);
        if ($delete) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dihapus'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data'));
        }
    }
}