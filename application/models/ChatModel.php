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
}