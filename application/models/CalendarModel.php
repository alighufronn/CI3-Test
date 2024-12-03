<?php

class CalendarModel extends CI_Model
{
    protected $table = 'calendar';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['title', 'start', 'end', 'backgroundColor', 'borderColor', 'textColor', 'id_user', 'role'];
    }

    
    public function get_events_based_on_role_or_id($id_user, $role)
    {
        $this->db->select('*');
        $this->db->from($this->table);

        if ($role === 'admin') {
            $this->db->group_start();
            $this->db->where('role IS NOT NULL');
            $this->db->where('role !=', '');
            $this->db->or_where('id_user', $id_user);
            $this->db->or_where('role', 'all');
            $this->db->group_end();
        } else if (empty($role)) {
            $this->db->group_start();
            $this->db->where('id_user', $id_user);
            $this->db->or_where('role', 'all');
            $this->db->group_end();
        } else {
            $this->db->group_start();
            $this->db->where('role', $role);
            $this->db->or_where('id_user', $id_user);
            $this->db->or_where('role', 'all');
            $this->db->group_end();
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_event($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function add_event_role($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_event($event_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $event_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    // public function update_event($event_id, $data)
    // {
    //     return $this->db->where('id', $event_id)->update($this->table, $data);
    // }

    // public function delete_event($id)
    // {
    //     return $this->db->where('id', $event_id)->delete($this->table);
    // }

    public function update_event($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete_event($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // public function get_events($id_user)
    // {
    //     $this->db->where('id_user', $id_user);
    //     $query = $this->db->get($this->table);

    //     return $query->result_array();
    // }

    // public function get_events_by_role($role)
    // {
    //     $this->db->where('role', $role);
    //     $query = $this->db->get($this->table);

    //     return $query->result_array();
    // }
}
