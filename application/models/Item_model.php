<?php
class Item_model extends CI_Model
{
    // FUNGSI BARU - Untuk membuat laporan jumlah pesanan per layanan
    public function get_report_requests_per_service()
    {
        $this->db->select('items.name as service_name, COUNT(service_requests.id) as total_requests');
        $this->db->from('service_requests');
        $this->db->join('items', 'items.id = service_requests.service_id', 'right'); // Gunakan RIGHT JOIN untuk menampilkan layanan yg belum dipesan
        $this->db->group_by('items.id, items.name');
        $this->db->order_by('total_requests', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_request_details($service_id, $status)
    {
        $this->db->select('r.id, r.description, r.created_at, u.name as user_name'); // Ambil nama dari tabel users
        $this->db->from('service_requests r');
        $this->db->join('users u', 'r.user_id = u.id', 'left'); // Join ke tabel users
        $this->db->where('r.service_id', $service_id);
        $this->db->where('r.status', $status);
        $this->db->order_by('r.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_service_status_report()
    {
        // Query ini menggunakan CodeIgniter Query Builder, lebih aman dan rapi
        $this->db->select(
            "s.name AS service_name, " .
                "COUNT(r.id) AS total_requests, " .
                "SUM(CASE WHEN r.status = 'pending' THEN 1 ELSE 0 END) AS pending_count, " .
                "SUM(CASE WHEN r.status = 'processed' THEN 1 ELSE 0 END) AS processed_count, " .
                "SUM(CASE WHEN r.status = 'completed' THEN 1 ELSE 0 END) AS completed_count, " .
                "SUM(CASE WHEN r.status = 'rejected' THEN 1 ELSE 0 END) AS rejected_count"
        );
        $this->db->from('service_requests r');
        $this->db->join('items s', 'r.service_id = s.id', 'left'); // Menggunakan 'items' sebagai tabel layanan
        $this->db->group_by('s.name');
        $this->db->order_by('s.name', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function __construct()
    {
        $this->load->database();
    }

    public function get_items()
    {
        return $this->db->get('items')->result_array();
    }

    public function get_item($id)
    {
        return $this->db->get_where('items', array('id' => $id))->row_array();
    }

    // ==================================================================
    // FUNGSI BARU - Untuk mengambil item berdasarkan kategori
    // ==================================================================
    public function get_by_category($kategori)
    {
        $this->db->where('kategori', $kategori);
        $query = $this->db->get('items');
        return $query->result_array();
    }

    public function create_item($data, $image = null)
    {
        if ($image) $data['image'] = $image;
        return $this->db->insert('items', $data);
    }

    public function update_item($id, $data, $image = null)
    {
        if ($image) $data['image'] = $image;
        $this->db->where('id', $id);
        return $this->db->update('items', $data);
    }

    public function delete_item($id)
    {
        $item = $this->get_item($id);
        if ($item['image']) {
            unlink('./uploads/' . $item['image']);
        }
        return $this->db->delete('items', array('id' => $id));
    }

    public function create_service_request($data)
    {
        return $this->db->insert('service_requests', $data);
    }

    public function get_service_requests($user_id = null)
    {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->select('service_requests.*, items.name as service_name, users.username');
        $this->db->join('items', 'items.id = service_requests.service_id');
        $this->db->join('users', 'users.id = service_requests.user_id');
        $this->db->order_by('service_requests.created_at', 'DESC'); // Ditambahkan agar request terbaru di atas
        return $this->db->get('service_requests')->result_array();
    }

    public function update_request_status($id, $status, $admin_notes = null)
    {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        // Hanya update admin_notes jika nilainya tidak kosong
        if ($admin_notes !== null) {
            $data['admin_notes'] = $admin_notes;
        }
        $this->db->where('id', $id);
        return $this->db->update('service_requests', $data);
    }
}
