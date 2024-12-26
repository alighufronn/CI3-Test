<?php

class ItemBuyModel extends CI_Model
{
    protected $table = 'item_buy';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['buyer_id', 'buyer_name', 'item_id', 'item_name', 'qty', 'harga', 'seller_id', 'seller_name'];
    }

    public function find()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

}