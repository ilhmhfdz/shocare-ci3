<?php $this->load->view('templates/header') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SHOCARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body,
        html {
            height: 100%;
        }

        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            padding: 20px 0;
        }

        .register-card {
            max-width: 500px;
            width: 100%;
            border-radius: 1rem;
            border: none;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="card register-card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <a href="<?= base_url() ?>" class="text-decoration-none text-primary">
                        <h1 class="fw-bolder">SHOCARE</h1>
                    </a>
                    <h3 class="fw-bold">Buat Akun Baru</h3>
                    <p class="text-muted">Daftar untuk mulai menggunakan layanan kami.</p>
                </div>

                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger p-2" role="alert">
                        <small><?= validation_errors() ?></small>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger p-2" role="alert">
                        <small><?= $this->session->flashdata('error') ?></small>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('auth/register') ?>">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?= set_value('username') ?>" required>
                        <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="passconf" class="form-control" id="passconf" placeholder="Konfirmasi Password" required>
                        <label for="passconf"><i class="bi bi-shield-check me-2"></i>Konfirmasi Password</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Daftar</button>
                    </div>
                </form>

                <p class="text-center mt-4 mb-0">
                    Sudah punya akun? <a href="<?= site_url('auth/login') ?>">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $this->load->view('templates/footer') ?>