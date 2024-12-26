<?php

class ItemSellModel extends CI_Model
{
    protected $table = 'item_sell';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['seller_id', 'seller_name', 'item_name', 'kategori', 'stock', 'harga'];
    }

    public function find()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_item_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        return $query->row_array();
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
}