<?php

class ItemCategoryModel extends CI_Model
{
    protected $table = 'item_category';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['kategori'];
    }

    public function find()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

}