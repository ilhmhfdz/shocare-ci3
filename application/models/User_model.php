<?php
// Mendefinisikan class model bernama User_model yang mewarisi (extends) fungsionalitas dari CI_Model dasar CodeIgniter.
class User_model extends CI_Model
{

    // __construct() adalah fungsi spesial (constructor) yang otomatis dijalankan setiap kali model ini dibuat (di-load).
    public function __construct()
    {
        // Memanggil constructor dari parent class (CI_Model).
        parent::__construct();
        // Memuat library database CodeIgniter agar kita bisa melakukan operasi database (seperti query) di dalam model ini.
        $this->load->database();
    }

    /**
     * Fungsi untuk memproses login user.
     * @param string $username Username yang diinput oleh pengguna.
     * @param string $password Password mentah (plain text) yang diinput oleh pengguna.
     * @return array|false Mengembalikan data user dalam bentuk array jika login berhasil, atau false jika gagal.
     */
    public function login($username, $password)
    {
        // Menyiapkan query: "WHERE username = '$username'"
        // Ini adalah cara aman untuk membuat query untuk mencegah SQL Injection.
        $this->db->where('username', $username);

        // Menjalankan query SELECT pada tabel 'users' dan mengambil satu baris pertama yang cocok.
        // Hasilnya dikembalikan sebagai associative array (misal: ['id' => 1, 'username' => 'admin']).
        $user = $this->db->get('users')->row_array();

        // Memeriksa dua kondisi:
        // 1. Apakah user dengan username tersebut ditemukan (apakah $user tidak null)?
        // 2. Jika user ditemukan, verifikasi password yang diinput ($password) dengan hash password yang ada di database ($user['password']).
        //    password_verify() adalah fungsi PHP yang aman untuk memeriksa hash password.
        if ($user && password_verify($password, $user['password'])) {
            // Jika kedua kondisi terpenuhi (user ada dan password cocok), kembalikan semua data user.
            return $user;
        }

        // Jika salah satu kondisi tidak terpenuhi (user tidak ada atau password salah), kembalikan false.
        return false;
    }

    /**
     * Fungsi untuk mengambil data satu user berdasarkan ID-nya.
     * @param int $id ID unik dari user yang ingin dicari.
     * @return array|null Mengembalikan data user dalam bentuk array jika ditemukan, atau null jika tidak ditemukan.
     */
    public function get_user($id)
    {
        // get_where() adalah shortcut CodeIgniter untuk melakukan SELECT dengan klausa WHERE.
        // Query ini setara dengan: "SELECT * FROM users WHERE id = '$id'".
        // row_array() memastikan hanya satu baris hasil yang diambil.
        return $this->db->get_where('users', array('id' => $id))->row_array();
    }
}
