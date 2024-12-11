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

    // public function get_by_sender_id($id_sender)
    // {
    //     $this->db->where('id_sender', $id_sender);
    //     $this->db->order_by('date', 'ASC');
    //     $this->db->order_by('time', 'ASC');
    //     $query = $this->db->get($this->table);

    //     return $query->result_array();
    // }

    // public function get_by_receiver_id($id_receiver)
    // {
    //     $this->db->where('id_receiver', $id_receiver);
    //     $this->db->order_by('date', 'ASC');
    //     $this->db->order_by('time', 'ASC');
    //     $query = $this->db->get($this->table);

    //     return $query->result_array();
    // }

    public function get_chat_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // public function get_chat_by_id($user_id)
    // {
    //     $this->db->group_start();
    //     $this->db->where('id_sender', $user_id);
    //     $this->db->or_where('id_receiver', $user_id);
    //     $this->db->group_end();
    //     $this->db->order_by('date', 'ASC');
    //     $this->db->order_by('time', 'ASC');

    //     $query = $this->db->get($this->table);

    //     return $query->result_array();
    // }

    public function get_chat_sender_receiver($current_user_id, $other_user_id)
    {
        $this->db->group_start();
        $this->db->group_start()
                 ->where('id_sender', $current_user_id)
                 ->where('id_receiver', $other_user_id)
                 ->group_end();
        $this->db->or_group_start()
                 ->where('id_sender', $other_user_id)
                 ->where('id_receiver', $current_user_id)
                 ->group_end();
        $this->db->group_end();
        $this->db->order_by('date', 'ASC');
        $this->db->order_by('time', 'ASC');

        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    public function send($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}