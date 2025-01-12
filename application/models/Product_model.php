<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    // fungsi insert ke tabel
    public function insert($table, $data) 
    {
        $this->db->insert($table, $data);
    }

    // fungsi insert ke tabel secara masal
    public function insert_batch($data, $table) 
    {
        $this->db->empty_table($table); //hapus / truncate dulu data lama
        $this->db->query('ALTER TABLE '.$table.' AUTO_INCREMENT = 1'); //reset auto increment jadi 1 lagi
        $this->db->insert_batch($table, $data); //baru masukkan data baru
    }

    // fungsi untuk update data pada database
    public function update($table, $data, $where) 
    {
        $this->db->where($where);
		$this->db->update($table,$data);
    }

    // fungsi mengambil data produk dengan berbagai parameter
    public function get_products($param = []) //berikan nilai parameter [] sbg default
    {
        // ambil data dengan join tabel
        $this->db->select('
            produk.*,
            status.nama_status,
            kategori.nama_kategori
            ');
        $this->db->from('produk');
        $this->db->join('status', 'status.id_status  = produk.status_id');
        $this->db->join('kategori', 'kategori.id_kategori  = produk.kategori_id');

        // cek apakah terdapat parameter get_by_status 
        if (isset($param['get_by_status']) && !is_null($param['get_by_status'])) {
            $this->db->where('status_id', $param['get_by_status']); //jika ya maka tambahkan klausa where berdasarkan status_id
        }

        // cek apakah terdapat parameter get_by_id
        if (isset($param['get_by_id']) && !is_null($param['get_by_id'])) {
            $this->db->where('id_produk', $param['get_by_id']); //jika ya maka tambahkan klausa where berdasarkan id_produk
        }

        // lakukan get data pada query dan masukkan dalam variable query
        $query = $this->db->get(); 

        // kembalikan hasil query yang ada pada variabel $query
        return $query;
    }

    // fungsi mengambil data status dengan berbagai parameter
    function get_status($param = [])
    {
        // ambil data dari tabel status
        $this->db->select('*');
        $this->db->from('status');

        // cek apakah terdapat parameter get_by_id
        if (isset($param['get_by_id']) && !is_null($param['get_by_id'])) {
            $this->db->where('id_status', $param['get_by_id']); //jika ya maka tambahkan klausa where berdasarkan id_status
        }  
        
        // cek apakah terdapat parameter get_status_by_name
        if (isset($param['get_status_by_name']) && !is_null($param['get_status_by_name'])) {
            $this->db->where('nama_status', $param['get_status_by_name']); //jika ya maka tambahkan klausa where berdasarkan nama_status
        }  

        // lakukan get data pada query dan masukkan dalam variable query
        $query = $this->db->get();

        // kembalikan hasil query yang ada pada variabel $query
        return $query;
    }

    // fungsi mengambil data kategori dengan berbagai parameter
    function get_kategori($param = [])
    {
        $this->db->select('*');
        $this->db->from('kategori');

        // cek apakah terdapat parameter get_by_id
        if (isset($param['get_by_id']) && !is_null($param['get_by_id'])) {
            $this->db->where('id_kategori', $param['get_by_id']); //jika ya maka tambahkan klausa where berdasarkan id_kategori
        }  

        // cek apakah terdapat parameter get_category_by_name
        if (isset($param['get_category_by_name']) && !is_null($param['get_category_by_name'])) {
            $this->db->where('nama_kategori', $param['get_category_by_name']); //jika ya maka tambahkan klausa where berdasarkan nama_kategori
        } 

        $query = $this->db->get();

        return $query;
    }
}
?>
