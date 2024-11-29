<?php

class CalendarController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('CalendarModel');
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
        $data['id_user'] = $this->session->userdata('user_id');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');

        log_message('debug', 'User ID: ' . $data['id_user']);

        $data['title'] = 'Calendar';
        $data['pageTitle'] = 'Calendar';

        $data['user_specific_data'] = $this->CalendarModel->get_events($data['id_user']);
        
        $data['content'] = $this->load->view('calendar', $data, true);

        $this->load->view('layout/page_layout', $data);
    }

    public function load_events()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $id_user = $this->session->userdata('user_id');
        $events = $this->CalendarModel->get_events($id_user);

        foreach ($events as $event) {
            $event['start'] = date('Y-m-d', strtotime($event['start']));
            $event['end'] = date('Y-m-d', strtotime($event['end']));
        }

        log_message('debug', 'Event: ' . json_encode($events));
        echo json_encode($events);
    }

    public function add_event() 
    {
        $title = $this->input->post('title');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $backgroundColor = $this->input->post('backgroundColor');
        $borderColor = $this->input->post('borderColor');
        $textColor = $this->input->post('textColor');
        $id_user = $this->input->post('id_user');
    
        if (empty($title) || empty($start)) {
            echo json_encode(array('status' => 'error', 'message' => 'Event title and start date cannot be empty.'));
            return;
        }
    
        $data = array(
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
            'textColor' => $textColor,
            'id_user' => $id_user,
        );
    
        $event_id = $this->CalendarModel->add_event($data);
        if ($event_id) {
            echo json_encode(array('status' => 'success', 'id' => $event_id));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add event'));
        }
    }

    public function update_event() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $backgroundColor = $this->input->post('backgroundColor');
        $borderColor = $this->input->post('borderColor');
        $textColor = $this->input->post('textColor');
        $id_user = $this->input->post('id_user');
    
        // Log the received data
        log_message('debug', 'Received data: id=' . $id . ', title=' . $title . ', start=' . $start . ', end=' . $end . ', backgroundColor=' . $backgroundColor . ', borderColor=' . $borderColor . ', textColor=' . $textColor);
    
        if (empty($id) || empty($title) || empty($start)) {
            echo 'Event ID, title, and start date cannot be empty.';
            return;
        }
    
        $data = array(
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
            'textColor' => $textColor,
            'id_user' => $id_user,
        );
    
        if ($this->CalendarModel->update_event($id, $data)) {
            echo 'Event updated successfully';
        } else {
            echo 'Failed to update event';
        }
    }    

    public function delete_event() {
        $id = $this->input->post('id');
    
        // Log the received data
        log_message('debug', 'Received data: id=' . $id);
    
        if (empty($id)) {
            echo 'Event ID cannot be empty.';
            return;
        }
    
        if ($this->CalendarModel->delete_event($id)) {
            echo 'Event deleted successfully';
        } else {
            echo 'Failed to delete event';
        }
    }    
}