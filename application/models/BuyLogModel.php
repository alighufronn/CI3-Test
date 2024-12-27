<?php

class BuyLogModel extends CI_Model
{
    protected $table = 'buy_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['buyer_id', 'grand_total'];
    }

    public function find()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }
}