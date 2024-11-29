<?php

class UserModel extends CI_Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_fields()
    {
        return ['name', 'username', 'password', 'role'];
    }

    public function get_user($username, $password)
    {
        // Cari user berdasarkan username
        $this->db->where('username', $username);
        $query = $this->db->get($this->table);

        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return null;
        }
    }

    public function getUser()
    {
        $query = $this->db->get($this->table); 
        return $query->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete($this->table);
    }

    public function find($id)
    {
        if ($id === null) {
            return null;
        }
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function findUser()
    {
        return $this->db->get($this->table)->result();
    }

    public function update($id, $data)
    {
        if ($id === null) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}