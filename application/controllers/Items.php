<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller
{
    // FUNGSI BARU - Untuk menampilkan halaman laporan
    public function report()
    {
        // Pastikan hanya admin yang bisa akses
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }

        // 1. Panggil fungsi BARU di model untuk mendapatkan data laporan
        $report_data = $this->item_model->get_service_status_report();

        // 2. Siapkan variabel $data untuk dikirim ke View
        $data['report_data'] = $report_data;
        $data['title'] = "Laporan Status Pesanan"; // Judul halaman

        // 3. Hitung SEMUA total untuk ditampilkan di footer view
        $data['total_all_requests'] = array_sum(array_column($report_data, 'total_requests'));
        $data['total_pending']      = array_sum(array_column($report_data, 'pending_count'));
        $data['total_processed']    = array_sum(array_column($report_data, 'processed_count'));
        $data['total_completed']    = array_sum(array_column($report_data, 'completed_count'));
        $data['total_rejected']     = array_sum(array_column($report_data, 'rejected_count'));
        $data['total_services']     = count($report_data);

        // 4. Muat file view, yang sekarang akan menerima semua data yang sudah dihitung
        $this->load->view('items/report', $data);
    }


    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('item_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function view_all()
    {

        $data['items'] = $this->item_model->get_items();

        $data['title'] = "Layanan Kami";
        $this->load->view('items/view_all', $data);
    }

    // Fungsi ini HANYA untuk admin.
    public function index()
    {
        // Jika yang mengakses bukan admin, langsung arahkan ke halaman utama yang publik.
        // Menggunakan base_url() lebih aman untuk mencegah loop.
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }

        $data['items'] = $this->item_model->get_items();
        $this->load->view('items/index', $data);
    }

    public function create()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }

        // ... sisa kode fungsi create() 
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('harga', 'harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('items/create');
        } else {
            $image = NULL;
            if (!empty($_FILES['image']['name'])) {
                $image = $this->do_upload();
            }

            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'harga' => $this->input->post('harga'),
                'kategori' => $this->input->post('kategori')
            );
            $this->item_model->create_item($data, $image);
            $this->session->set_flashdata('message', 'Item created successfully');
            redirect('items');
        }
    }

    public function edit($id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }

        // ... sisa kode fungsi edit()
        $data['item'] = $this->item_model->get_item($id);

        if (!$data['item']) {
            show_404();
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('harga', 'harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('items/edit', $data);
        } else {
            $image = NULL;
            if (!empty($_FILES['image']['name'])) {
                $image = $this->do_upload();
                if ($image && $data['item']['image']) {
                    unlink('./uploads/' . $data['item']['image']);
                }
            }

            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'harga' => $this->input->post('harga'),
                'kategori' => $this->input->post('kategori')
            );
            $this->item_model->update_item($id, $update_data, $image);
            $this->session->set_flashdata('message', 'Item updated successfully');
            redirect('items');
        }
    }

    private function do_upload()
    {
        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect($this->uri->uri_string());
        } else {
            return $this->upload->data('file_name');
        }
    }

    public function delete($id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }
        $this->item_model->delete_item($id);
        $this->session->set_flashdata('message', 'Item deleted successfully');
        redirect('items');
    }

    public function request_service($service_id)
    {
        // Pengecekan login diperlukan di sini
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Anda harus login untuk memesan layanan.');
            redirect('auth/login');
        }
        if ($this->session->userdata('role') !== 'user') {
            redirect(base_url());
        }

        // ... sisa kode fungsi request_service()
        $data['service'] = $this->item_model->get_item($service_id);
        if (!$data['service']) {
            show_404();
        }
        $this->form_validation->set_rules('description', 'Problem Description', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('items/request_form', $data);
        } else {
            $request_data = [
                'user_id' => $this->session->userdata('user_id'),
                'service_id' => $service_id,
                'description' => $this->input->post('description'),
                'status' => 'pending'
            ];

            $this->item_model->create_service_request($request_data);
            $this->session->set_flashdata('message', 'Service request submitted successfully');
            redirect('items/my_requests');
        }
    }


    public function my_requests()
    {
        // Pengecekan untuk memastikan hanya user yang login yang bisa akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'user') {
            redirect(base_url());
        }

        // Query untuk mengambil data pesanan, sekaligus data layanan (termasuk gambar)
        $this->db->select('service_requests.*, items.name as service_name, items.image as service_image');
        $this->db->from('service_requests');
        $this->db->join('items', 'items.id = service_requests.service_id');

        $this->db->where('service_requests.user_id', $this->session->userdata('user_id'));

        $this->db->order_by('service_requests.created_at', 'DESC');
        $data['requests'] = $this->db->get()->result_array();

        // Menambahkan judul dinamis untuk halaman
        $data['title'] = "Lacak Pesanan Saya";

        $this->load->view('items/my_requests', $data);
    }

    public function manage_requests()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }

        $data['requests'] = $this->item_model->get_service_requests();
        $this->load->view('items/manage_requests', $data);
    }

    public function update_request($request_id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect(base_url());
        }

        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === TRUE) {
            $status = $this->input->post('status');
            $admin_notes = $this->input->post('admin_notes');

            $this->item_model->update_request_status($request_id, $status, $admin_notes);
            $this->session->set_flashdata('message', 'Request updated successfully');
        }

        redirect('items/manage_requests');
    }
}
