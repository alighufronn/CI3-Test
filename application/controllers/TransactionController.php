<?php

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionController extends CI_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('ItemCategoryModel');
        $this->load->model('ItemSellModel');
        $this->load->model('ItemBuyModel');
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library('upload', 'session');
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $data['logged_in'] = $this->session->userdata('logged_in');
        $data['name'] = $this->session->userdata('name');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        $data['id_user'] = $this->session->userdata('user_id');
        $data['title'] = 'Transaction';
        $data['pageTitle'] = 'Transaction';
        $data['content'] = $this->load->view('transaction', $data, true);

        $this->load->view('layout/page_layout', $data);
    }

    public function load_category()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $category = $this->ItemCategoryModel->find();
        echo json_encode(array('status' => 'success', 'categories' => $category, 'message' => 'Berhasil memuat kategori'));
    }

    public function loads()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $items = $this->ItemSellModel->find();
        echo json_encode(array('status' => 'success', 'items' => $items, 'message' => 'Berhasil memuat items'));
    }

    public function item_add()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $id = $this->input->post('id');
        $seller_id = $this->input->post('seller_id');
        $seller_name = $this->input->post('seller_name');
        $item_name = $this->input->post('item_name');
        $kategori = $this->input->post('kategori');
        $stock = $this->input->post('stock');
        $harga = $this->input->post('harga');

        $data = array(
            'seller_id' => $seller_id,
            'seller_name' => $seller_name,
            'item_name' => $item_name,
            'kategori' => $kategori,
            'harga' => $harga,
            'stock' => $stock,
        );

        $save = $this->ItemSellModel->insert($data);

        $saved = $this->ItemSellModel->get_item_by_id($save);
        if ($saved) {
            echo json_encode(array('status' => 'success', 'items' => $saved, 'message' => 'Item berhasil disimpan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan item'));
        }
    }

    public function item_edit()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $id = $this->input->post('id');
        $item_name = $this->input->post('item_name');
        $kategori = $this->input->post('kategori');
        $harga = $this->input->post('harga');
        $stock = $this->input->post('stock');
        $seller_id = $this->session->userdata('user_id');
        $seller_name = $this->session->userdata('name');

        $newData = array(
            'item_name' => $item_name,
            'kategori' => $kategori,
            'harga' => $harga,
            'stock' => $stock,
            'seller_id' => $seller_id,
            'seller_name' => $seller_name,
        );

        $update = $this->ItemSellModel->update($id, $newData);

        $updated = $this->ItemSellModel->get_item_by_id($id);

        if ($updated) {
            echo json_encode(array('status' => 'success', 'items' => $updated, 'message' => 'Item berhasil diedit'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengedit item'));
        }
    }

    public function item_delete()
    {
        if (!$this->session->userdata('logged_in')) {
            show_error('You are not authorized to access this page.', 401, 'Unauthorized');
            return;
        }

        $id = $this->input->post('id');

        $delete = $this->ItemSellModel->delete($id);

        $deleted = $this->ItemSellModel->get_item_by_id($delete);

        if ($delete) {
            echo json_encode(array('status' => 'success', 'items' => $deleted, 'message' => 'Item berhasil dihapus'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus item'));
        }
    }
}

?>
