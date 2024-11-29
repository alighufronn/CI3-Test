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
        return ['title', 'start', 'end', 'backgroundColor', 'borderColor', 'textColor', 'id_user'];
    }

    // public function get_events()
    // {
    //     return $this->db->get($this->table)->result();
    // }

    public function add_event($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_event($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete_event($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function get_events($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get($this->table);

        return $query->result_array();
    }
}
