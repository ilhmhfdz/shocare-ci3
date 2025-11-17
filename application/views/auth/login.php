<?php $this->load->view('templates/header') ?>

<div class="login-wrapper">
    <div class="card login-card">
        <div class="row g-0">
            <div class="col-lg-6 login-visual-panel">
                <h1 class="fw-bolder mb-3">SHOCARE</h1>
                <p class="lead">Solusi Profesional Perawatan Sepatu Anda.</p>
                <i class="bi bi-shield-lock-fill" style="font-size: 5rem; margin-top: 2rem; opacity: 0.5;"></i>
            </div>

            <div class="col-lg-6 login-form-panel d-flex align-items-center">
                <div>
                    <div class="text-center text-lg-start mb-4">
                        <h2 class="fw-bold">Selamat Datang!</h2>
                        <p class="text-muted">Silakan masuk untuk melanjutkan.</p>
                    </div>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('auth/login') ?>">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <div class="form-floating">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                                <label for="username">Username</label>
                            </div>
                        </div>

                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p>Belum punya akun? <a href="<?= site_url('auth/register') ?>">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('templates/footer') ?>