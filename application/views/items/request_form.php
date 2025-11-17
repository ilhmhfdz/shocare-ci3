<?php $this->load->view('templates/header') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .summary-card .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .summary-card .list-group-item {
        border-left: 0;
        border-right: 0;
    }
</style>

<div class="container main-content my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Formulir Request Layanan</h1>
        <p class="lead text-muted">Satu langkah lagi untuk membuat sepatumu kembali seperti baru!</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>
                <?= $this->session->flashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="card shadow-sm sticky-top summary-card" style="top: 2rem;">
                <?php if (!empty($service['image'])): ?>
                    <img src="<?= base_url('uploads/' . $service['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($service['name']) ?>">
                <?php endif; ?>
                <div class="card-header text-center">
                    <h5 class="mb-0">Ringkasan Layanan</h5>
                </div>
                <div class="card-body">
                    <h4 class="card-title"><?= htmlspecialchars($service['name']) ?></h4>
                    <ul class="list-group list-group-flush my-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-tag-fill me-2 text-primary"></i>
                                Harga
                            </span>
                            <strong class="text-primary">Rp <?= number_format($service['harga'], 0, ',', '.') ?></strong>
                        </li>
                        <li class="list-group-item">
                            <p class="mb-1">
                                <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                <strong>Deskripsi Layanan:</strong>
                            </p>
                            <p class="text-muted small mb-0">
                                <?= htmlspecialchars($service['description']) ?>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Isi Detail Kebutuhan Anda
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?= form_open('items/request_service/' . $service['id']) ?>
                    <div class="mb-4">
                        <label for="description" class="form-label fs-5 fw-bold">Deskripsi Kondisi Sepatu Anda</label>
                        <textarea id="description" name="description" class="form-control" rows="6"
                            placeholder="Contoh: Sol bagian depan sedikit menganga, ada noda kopi di sisi kanan, dan tali sepatu perlu diganti."
                            required></textarea>
                        <div class="form-text mt-2">
                            <i class="bi bi-lightbulb"></i> Tips: Jelaskan sedetail mungkin agar kami bisa memberikan penanganan terbaik.
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= site_url('items/view_all') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send-check"></i> Kirim Request
                        </button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer') ?>