<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SHOCARE' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        .navbar {
            transition: box-shadow 0.2s ease-in-out;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* Style untuk link navigasi yang aktif */
        .navbar-nav .nav-link.active {
            font-weight: 600;
            color: #0d6efd;
            /* Warna primer Bootstrap */
        }

        .dropdown-menu {
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .user-dropdown-toggle::after {
            display: none;
            /* Menghilangkan panah default dropdown */
        }
    </style>

    <style>
        /* Style untuk halaman login dua panel */
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Dihapus: min-height: 100vh; agar tidak bentrok dengan footer */
            padding: 4rem 0;
            /* Memberi padding atas & bawah */
        }

        .login-card {
            width: 100%;
            max-width: 900px;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-visual-panel {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .login-form-panel {
            padding: 3rem;
        }

        @media (max-width: 991.98px) {
            .login-visual-panel {
                display: none;
            }

            .login-form-panel {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <?php
    // Mengambil segmen URL untuk menentukan halaman aktif
    $uri_segment_1 = $this->uri->segment(1);
    $uri_segment_2 = $this->uri->segment(2);
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
        <div class="container">
            <a class="navbar-brand text-primary" href="<?= base_url() ?>">SHOCARE</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($this->session->userdata('logged_in') && $this->session->userdata('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri_segment_2 == 'create') ? 'active' : '' ?>" href="<?= site_url('items/create') ?>">
                                Tambah Service
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri_segment_2 == 'manage_requests') ? 'active' : '' ?>" href="<?= site_url('items/manage_requests') ?>">
                                Kelola Request
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($this->uri->segment(2) == 'report') ? 'active' : '' ?>" href="<?= site_url('items/report') ?>">
                                Laporan
                            </a>
                        </li>
                    <?php elseif ($this->session->userdata('logged_in') && $this->session->userdata('role') === 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri_segment_2 == 'my_requests') ? 'active' : '' ?>" href="<?= site_url('items/my_requests') ?>">
                                Pesanan Saya
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-4 me-2"></i>
                                <?= $this->session->userdata('username') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: // Tombol jika user belum login 
                    ?>
                        <li class="nav-item">
                            <a href="<?= site_url('auth/login') ?>" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>