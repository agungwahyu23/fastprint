<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }
    
	public function index()
	{
        // buat parameter get_by_status dengan nilai 1 untuk mengambil data yg statusnya bisa dijual 
        $param['get_by_status'] = '1';

        // array products pada var data akan berisi data produk yang diambil dari fungsi get_products yg statusnya 1
        $data['products'] = $this->product_model->get_products($param)->result_array();

        // bawa data kedalam view untuk diolah
		$this->load->view('list', $data);
	}

    // fungsi untuk menampilkan halaman form tambah
    public function create() 
    {
        // ambil semua data status dan kategori dalam bentuk array
        $status = $this->product_model->get_status()->result_array();
        $kategori = $this->product_model->get_kategori()->result_array();

        // tambahkan array baru pada awal array status dan kategori, ini akan digunakan untuk dropdown
        $data['status'] = array_merge(
            [['id_status' => null, 'nama_status' => 'Pilih status']],
            $status
        );

        $data['kategori'] = array_merge(
            [['id_kategori' => null, 'nama_kategori' => 'Pilih kategori']],
            $kategori
        );

        // kirim data ke halaman add
        $this->load->view('add', $data);    
    }

    // fungsi untuk menyimpan data produk
    public function store() 
    {
        // buat aturan validasi dalam bentuk array lalu proses secara batch dengan fungsi set_rules
        $validation_rules = [
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi.',
                ]
            ],
            [
                'field' => 'harga',
                'label' => 'Harga Produk',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga produk harus diisi.',
                    'numeric'  => 'Harga produk harus berupa angka.',
                ]
            ],
            [
                'field' => 'kategori_id',
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori produk harus diisi.',
                ]
            ],
            [
                'field' => 'status_id',
                'label' => 'status',
                'rules' => 'required',
                'errors' => [
                    'required' => 'status produk harus diisi.',
                ]
            ]
        ];
        $this->form_validation->set_rules($validation_rules);

        // lakukan pengecekan, jika validasi dijalankan ada yg bernilai false maka lempar kembali ke halaman add dengan pesan error pada masing2 inputan
        if ($this->form_validation->run() == FALSE) {
            $status = $this->product_model->get_status()->result_array();
            $kategori = $this->product_model->get_kategori()->result_array();

            $data['status'] = array_merge(
                [['id_status' => null, 'nama_status' => 'Pilih status']],
                $status
            );

            $data['kategori'] = array_merge(
                [['id_kategori' => null, 'nama_kategori' => 'Pilih kategori']],
                $kategori
            );

            $this->load->view('add', $data);  
        }else{ //jika tidak maka lakukan proses input
            $data = [   
                'nama_produk'   => $this->input->post('nama_produk'),   
                'harga'         => $this->input->post('harga'),   
                'kategori_id'  => $this->input->post('kategori_id'),   
                'status_id'     => $this->input->post('status_id')
            ];
    
            // input data menggunakan fungsi insert pada model product_model
            $this->product_model->insert('produk', $data);
            
            // setelah berhasil arahkan pengguna ke fungsi index yang menampilkan list produk
            redirect(base_url('product/index'));
        }

        
    }

    // fungsi untuk menampilkan halaman edit
    public function edit($id) 
    {  
        // buat parameter get_by_id yang berisi id yang dipilih dari view
        $param['get_by_id'] = $id;

        // buat var $data berisi array product yang isinya data 1 produk yang diambil dari fungsi get_products dengan id yang sesuai dengan parameter 
        $data['product'] = $this->product_model->get_products($param)->row();

        // ambil semua data status dan kategori dalam bentuk array
        $status = $this->product_model->get_status()->result_array();
        $kategori = $this->product_model->get_kategori()->result_array();

        // tambahkan array baru pada awal array status dan kategori, ini akan digunakan untuk dropdown
        $data['status'] = array_merge(
            [['id_status' => null, 'nama_status' => 'Pilih status']],
            $status
        );

        $data['kategori'] = array_merge(
            [['id_kategori' => null, 'nama_kategori' => 'Pilih kategori']],
            $kategori
        );

        // kirim data ke halaman edit
        $this->load->view('edit', $data);  
    }

    public function update() 
    {   
        // buat var id untuk menampung inputan id_produk yang dihide pada view.
        $id = $this->input->post('id_produk');

         // buat aturan validasi dalam bentuk array lalu proses secara batch dengan fungsi set_rules
        $validation_rules = [
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi.',
                ]
            ],
            [
                'field' => 'harga',
                'label' => 'Harga Produk',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga produk harus diisi.',
                    'numeric'  => 'Harga produk harus berupa angka.',
                ]
            ],
            [
                'field' => 'kategori_id',
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori produk harus diisi.',
                ]
            ],
            [
                'field' => 'status_id',
                'label' => 'status',
                'rules' => 'required',
                'errors' => [
                    'required' => 'status produk harus diisi.',
                ]
            ]
        ];
        $this->form_validation->set_rules($validation_rules);

         // lakukan pengecekan, jika validasi dijalankan ada yg bernilai false maka lempar kembali ke halaman edit dengan pesan error pada masing2 inputan
        if ($this->form_validation->run() == FALSE) {
            $param['get_by_id'] = $id;
            $data['product'] = $this->product_model->get_products($param)->row();
            $status = $this->product_model->get_status()->result_array();
            $kategori = $this->product_model->get_kategori()->result_array();
    
            $data['status'] = array_merge(
                [['id_status' => null, 'nama_status' => 'Pilih status']],
                $status
            );
    
            $data['kategori'] = array_merge(
                [['id_kategori' => null, 'nama_kategori' => 'Pilih kategori']],
                $kategori
            );
    
            $this->load->view('edit', $data);
        }else{ //jika tidak maka lakukan proses update
            // masukkan data yang diinpur dalam var data dalam bentuk array
            $data = [   
                'nama_produk'   => $this->input->post('nama_produk'),   
                'harga'         => $this->input->post('harga'),   
                'kategori_id'  => $this->input->post('kategori_id'),   
                'status_id'     => $this->input->post('status_id')
            ];
    
            // buat var where untuk menentukan id_produk yang akan diupdate
            $where = [
                'id_produk'     => $this->input->post('id_produk'),
            ];
    
            // lakukan update dengan fungsi update pada model product_model
            $this->product_model->update('produk', $data, $where);
            
            // setelah berhasil arahkan pengguna ke fungsi index yang menampilkan list produk
            redirect(base_url('product/index'));
        }
    }

    // fungsi untuk hapus data berdasarkan id
    public function delete($id) 
    {
        $this->db->where('id_produk', $id);
        $this->db->delete('produk');
        
        redirect(base_url('product/index'));
    }

    // fungsi untuk mengambil data dari api
    public function fetch_api()
    {
        $date_pass = date('d-m-y'); //definisikan tanggal sekarang dg format dd-mm-yy
        $URL = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer'; //url api
        $username = 'tesprogrammer120125C17'; //berubah sesuai server
        $password = md5('bisacoding-'.$date_pass); //password dengan enkripsi md5 yg berubah sesuai tanggal

        $ch=curl_init(); //inisiasi awal
        curl_setopt($ch, CURLOPT_URL, $URL); //arahkan req ke url api
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //kembalikan hasil req berupa string, bukan default
        curl_setopt($ch, CURLOPT_POST, true); //gunakan method post
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'username' => $username,
            'password' => $password
        ])); //kirim data username dan password ke server untuk otentikasi
        
        $result = curl_exec($ch); //jalankan sess curl dan simpan dalam var result
        curl_close($ch); //tutup session curl

        return $result; //kembalikan hasil yang ada dalam var result
    }

    function product_save()
	{
        $data = $this->fetch_api(); //buat var data yang berisi data dari api
        $decodedResult = json_decode($data, true); //lakukan decode sebagai arr asosiatif

        // Simpan data ke database jika valid
        if (!empty($decodedResult)) {
            // insert status
            $this->status_action($decodedResult);

            // insert kategori
            $this->category_action($decodedResult);

            // insert produk
            $products = [];
            foreach ($decodedResult['data'] as $key=>$product) {
                // buat param untuk mengambil status dan kategori yang sesuai
                $param['get_status_by_name'] = $product['status'];
                $param['get_category_by_name'] = $product['kategori'];
                
                $status = $this->product_model->get_status($param)->row(); //ambil data status berdasarkan nama
                $status_id = $status->id_status ?? null; //jika ada maka ambil id_status, jika kosong return null
                
                $category = $this->product_model->get_kategori($param)->row(); //ambil data kategori berdasarkan nama
                $category_id = $category->id_kategori ?? null; //jika ada maka ambil id_kategori, jika kosong return null

                // isikan var product
                $products[] = [
                    'id_produk' => $product['id_produk'],
                    'nama_produk' => $product['nama_produk'],
                    'harga' => $product['harga'],
                    'status_id' => $status_id,
                    'kategori_id' => $category_id
                ];
            }

            // insert data secara masal
            $this->product_model->insert_batch($products, 'produk');

            echo "Data produk berhasil disimpan ke database.";
        } else {
            echo "Gagal mengambil data dari API.";
        }  	
	}

    // fungsi untuk menyimpan data status
    public function status_action($param)
	{
        if (!empty($param)) {
            $status = [];
            foreach ($param['data'] as $product) {
                // filter status untuk mengambil nama2 status masing2 1x agar tidak redudan
                if (!in_array($product['status'], $status)) {
                    $status[] = $product['status'];
                }
            }

            //masukkan data kedalam var data_status dengan key nama_kategori
            $data_status = [];
            foreach ($status as $key => $value) {
                $data_status[] = [
                    'nama_status' => $value
                ];
            }

            // insert secara batch
            $this->product_model->insert_batch($data_status, 'status');
        } else {
            return "failed";
        }	
	}

    public function category_action($param)
	{
        if (!empty($param)) {
            $category = [];
            foreach ($param['data'] as $product) {
                // filter category untuk mengambil nama2 category masing2 1x agar tidak redudan
                if (!in_array($product['kategori'], $category)) {
                    $category[] = $product['kategori'];
                }
            }

            //masukkan data kedalam var data_kategori dengan key nama_kategori
            $data_kategori = [];
            foreach ($category as $key => $value) {
                $data_kategori[] = [
                    'nama_kategori' => $value
                ];
            }

            // insert secara batch
            $this->product_model->insert_batch($data_kategori, 'kategori');
        } else {
            return "Gagal mengambil data dari API.";
        }	
	}
}
