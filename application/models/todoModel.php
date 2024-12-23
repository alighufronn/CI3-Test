<?php

class todoModel extends CI_Model
{
    protected $table = 'todo';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['id_user', 'title', 'status'];
    }

    public function find()
    {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function get_by_user_id($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_data_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function update_status($item_id, $new_status)
    {
        $this->db->where('id', $item_id);
        $this->db->update($this->table, array('status' => $new_status));
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function count_by_todo($user_id)
    {
        $this->db->where('id_user', $user_id);
        $this->db->where('status', 'todo');
        return $this->db->count_all_results($this->table);
    }

    public function count_by_progress($user_id)
    {
        $this->db->where('id_user', $user_id);
        $this->db->where('status', 'progress');
        return $this->db->count_all_results($this->table);
    }

    public function count_by_done($user_id)
    {
        $this->db->where('id_user', $user_id);
        $this->db->where('status', 'done');
        return $this->db->count_all_results($this->table);
    }

}