<?php

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('UserModel');
        $this->load->model('UserRoleModel');
        $this->load->model('todoModel');
        $this->load->model('ChatModel');
        $this->load->model('CalendarModel');
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library('upload', 'session');
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
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

    public function get_upcoming_events()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');

        $events = $this->CalendarModel->get_upcoming_events($user_id, $role);

        if ($events) {
            echo json_encode(array('status' => 'success', 'events' => $events, 'message' => 'Berhasil menampilkan events'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menampilkan events'));
        }
    }

    public function users_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $user_count = $this->UserModel->get_user_count();
        
        if ($user_count) {
            echo json_encode(array('status' => 'success', 'user_count' => $user_count, 'message' => 'Jumlah users ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak dapat menghitung jumlah users'));
        }
    }

    public function events_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');

        $event_count = $this->CalendarModel->count_event_by_user($user_id, $role);

        if ($event_count) {
            echo json_encode(array('status' => 'success', 'event_count' => $event_count, 'message' => 'Jumlah event ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'Tidak dapat menghitug jumlah event'));
        }
    }

    public function chats_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $user_id = $this->session->userdata('user_id');

        $chat_count = $this->ChatModel->count_chat_by_sender($user_id);

        if ($chat_count) {
            echo json_encode(array('status' => 'success', 'chat_count' => $chat_count, 'message' => 'Jumlah chat ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak dapat menghitung jumlah chat'));
        }
    }

    public function todos_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $user_id = $this->session->userdata('user_id');

        $todo_count = $this->todoModel->count_by_todo($user_id);

        if ($todo_count) {
            echo json_encode(array('status' => 'success', 'todo_count' => $todo_count, 'message' => 'Jumlah to do list ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak dapat menghitung jumlah to do list'));
        } 
    }

    public function admin_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $admin_count = $this->UserModel->get_admin_count();

        if ($admin_count) {
            echo json_encode(array('status' => 'success', 'admin_count' => $admin_count, 'message' => 'Jumlah Admin ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak dapat menghitung jumlah Admin'));
        } 
    }

    public function staff_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $staff_count = $this->UserModel->get_staff_count();

        if ($staff_count) {
            echo json_encode(array('status' => 'success', 'staff_count' => $staff_count, 'message' => 'Jumlah Staff ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak dapat menghitung jumlah Staff'));
        } 
    }

    public function guest_count()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $guest_count = $this->UserModel->get_guest_count();

        if ($guest_count) {
            echo json_encode(array('status' => 'success', 'guest_count' => $guest_count, 'message' => 'Jumlah Guest ditampilkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak dapat menghitung jumlah Guest'));
        } 
    }

    public function get_chart_data()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }
        
        $role_counts = $this->UserModel->get_role_counts();

        $labels = [];
        $data = [];
        $backgroundColor = ['#00c0ef', '#3c8dbc', '#d2d6de'];

        foreach ($role_counts as $index => $role_count) {
            $labels[] = $role_count->role;
            $data[] = $role_count->count;
        }

        $chart_data = array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColor, 0, count($labels)),
                )
            )
        );

        echo json_encode($chart_data);
    }
}