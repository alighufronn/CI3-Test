<?php

class ChatModel extends CI_Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['id_sender', 'name_sender', 'message', 'id_receiver', 'name_receiver', 'date', 'time'];
    }

    public function get_by_sender_id($id_sender)
    {
        $this->db->where('id_sender', $id_sender);
        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    public function get_by_receiver_id($id_receiver)
    {
        $this->db->where('id_receiver', $id_receiver);
        $query = $this->db->get($this->table);

        return $query->result_array();
    }
}