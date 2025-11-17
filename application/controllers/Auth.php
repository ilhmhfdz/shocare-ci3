<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function register()
    {
        // Jika user sudah login, arahkan ke halaman utama
        if ($this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        // Load model, library, dan helper yang dibutuhkan
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
        $this->load->helper('form');

        // Aturan validasi untuk setiap input pada form
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|is_unique[users.username]', [
            'is_unique' => 'Username ini sudah digunakan. Silakan pilih yang lain.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal atau halaman pertama kali dibuka, tampilkan form registrasi
            $this->load->view('auth/register');
        } else {
            // Jika validasi berhasil, proses data

            // 1. Enkripsi/Hash password sebelum disimpan (SANGAT PENTING UNTUK KEAMANAN)
            $hashed_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

            // 2. Siapkan data untuk dimasukkan ke database
            $data = [
                'username' => $this->input->post('username'),
                'password' => $hashed_password
            ];

            // 3. Panggil model untuk menyimpan data
            if ($this->Auth_model->register_user($data)) {
                // Jika berhasil, beri notifikasi dan arahkan ke halaman login
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
                redirect('auth/login');
            } else {
                // Jika gagal menyimpan ke database
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index()
    {
        redirect('auth/login');
    }

    public function login()
    {
        // Jika sudah login, redirect ke halaman sesuai role
        if ($this->session->userdata('logged_in')) {
            $this->redirect_by_role();
        }

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->login($username, $password);

            if ($user) {
                $user_data = array(
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true
                );

                $this->session->set_userdata($user_data);
                $this->redirect_by_role();
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'username', 'role', 'logged_in']);
        $this->session->set_flashdata('message', 'You have been logged out');
        redirect('auth/login');
    }

    private function redirect_by_role()
    {
        if ($this->session->userdata('role') === 'admin') {
            redirect('items');
        } else {
            redirect('items/view_all');
        }
    }
}
