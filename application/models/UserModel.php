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
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function username_exists($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    public function get_user_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
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

    public function get_users()
    {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function update($id, $data)
    {
        if ($id === null) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function get_user_count()
    {
        return $this->db->count_all($this->table);
    }

    public function get_admin_count()
    {
        $this->db->where('role', 'admin');
        return $this->db->count_all_results($this->table);
    }

    public function get_staff_count()
    {
        $this->db->where('role', 'staff');
        return $this->db->count_all_results($this->table);
    }

    public function get_guest_count()
    {
        $this->db->where('role', 'guest');
        return $this->db->count_all_results($this->table);
    }

    public function get_role_counts()
    {
        $this->db->select('role, COUNT(*) as count');
        $this->db->group_by('role');
        $query = $this->db->get($this->table);

        return $query->result();
    }
}