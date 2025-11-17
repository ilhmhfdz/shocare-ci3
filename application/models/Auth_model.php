<?php
class Auth_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Menyimpan data user baru ke dalam tabel 'users'
     * @param array $data Data user (username, password)
     * @return bool
     */
    public function register_user($data)
    {
        // 'role' akan otomatis terisi 'user' karena sudah diatur sebagai DEFAULT di database
        return $this->db->insert('users', $data);
    }

    /**
     * Mengambil data user berdasarkan username untuk proses login
     * @param string $username
     * @return array
     */
    public function get_user($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row_array();
    }
}
