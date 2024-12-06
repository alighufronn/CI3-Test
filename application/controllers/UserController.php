<?php

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('UserRoleModel');
        $this->load->model('CalendarModel');
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


    public function index()
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
        $data['roles'] = $this->UserRoleModel->find();
        $data['users'] = $this->UserModel->get_users();
        $data['content'] = $this->load->view('admin/users', $data, true);

        $this->load->view('layout/page_layout', $data);
    }


    public function load_users()
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

        $users = $this->UserModel->get_users();
        echo json_encode($users);
    }


    public function add_user()
    {
        $username = $this->input->post('username');
        $name = $this->input->post('name');
        $role = $this->input->post('role');
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

        if (preg_match('/\s/', $username)) {
            echo json_encode(array('status' => 'error', 'message' => 'Username tidak boleh memiliki spasi'));
            return;
        }

        if ($this->UserModel->username_exists($username)) {
            echo json_encode(array('status' => 'error', 'message' => 'Username sudah dipakai'));
            return;
        }

        if (empty($username && $name && $role && $password)) {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak boleh ada yang kosong'));
            return;
        }

        $data = array(
            'name' => $name,
            'role' => $role,
            'username' => $username,
            'password' => $password,
        );

        $inserted_id = $this->UserModel->insert($data);

        $new_user = $this->UserModel->get_user_by_id($inserted_id);
        echo json_encode(array('status' => 'success', 'user' => $new_user, 'message' => 'Data berhasil disimpan'));
    }


    public function get_users()
    {
        $user_id = $this->input->post('id');

        $user = $this->UserModel->get_user_by_id($user_id);

        if ($user) {
            echo json_encode(array('status' => 'success', 'user' => $user));
        } else {
            echo json_encode(array('status' => 'success', 'message' => 'User tidak ditemukan'));
        }
    }


    public function edit_user()
    {
        $user_id = $this->input->post('id');
        $username = $this->input->post('username');
        $name = $this->input->post('name');
        $role = $this->input->post('role');
        $password = $this->input->post('password');

        $current_user = $this->UserModel->get_user_by_id($user_id); 
        

        if (preg_match('/\s/', $username)) {
            echo json_encode(array('status' => 'error', 'message' => 'Username tidak boleh memiliki spasi'));
            return;
        }

        if ($username !== $current_user['username'] && $this->UserModel->username_exists($username)) {
            echo json_encode(array('status' => 'error', 'message' => 'Username sudah dipakai'));
            return;
        }

        if (empty($username && $name && $role)) {
            echo json_encode(array('status' => 'error', 'message' => 'Name, username, dan role tidak boleh kosong'));
            return;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $data = array(
                'name' => $name,
                'role' => $role,
                'username' => $username,
                'password' => $hashedPassword,
            );
        } else {
            $data = array(
                'name' => $name,
                'role' => $role,
                'username' => $username,
            );
        }

        $updated = $this->UserModel->update($user_id, $data);

        $updated_user = $this->UserModel->get_user_by_id($user_id);
        echo json_encode(array('status' => 'success', 'user' => $updated_user, 'message' => 'Data berhasil diubah'));
    }


    public function delete_user()
    {
        $user_id = $this->input->post('id');

        $events_deleted = $this->CalendarModel->delete_events_by_user($user_id);

        $user_deleted = $this->UserModel->delete($user_id);

        if ($user_deleted && $events_deleted) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dihapus'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data'));
        }
    }
}

?>
