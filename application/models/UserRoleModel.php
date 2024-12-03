<?php

class UserRoleModel extends CI_Model
{
    protected $table = 'user_role';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['role_name'];
    }

    public function find()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

}