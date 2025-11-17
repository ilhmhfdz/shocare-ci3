<?php $this->load->view('templates/header') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Style untuk memastikan gambar di kartu terlihat bagus */
    .card-img-top {
        width: 100%;
        height: 200px;
        /* Tinggi gambar yang konsisten */
        object-fit: cover;
        /* Mencegah gambar penyok */
    }
</style>

<div class="container main-content my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-card-list me-2"></i>
                Daftar Layanan
            </h5>
            <a href="<?= site_url('items/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Layanan Baru
            </a>
        </div>

        <div class="card-body">
            <?php if ($this->session->flashdata('message')): ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>
                        <?= $this->session->flashdata('message') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (empty($items)): ?>
                <div class="text-center p-5">
                    <i class="bi bi-box-seam" style="font-size: 4rem; color: #6c757d;"></i>
                    <h5 class="mt-3">Belum Ada Layanan</h5>
                    <p class="text-muted">Silakan tambahkan layanan baru dengan menekan tombol di kanan atas.</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border">
                                <?php if ($item['image']): ?>
                                    <img src="<?= base_url('uploads/' . $item['image']) ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($item['name']) ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        <?= htmlspecialchars($item['description']) ?>
                                    </p>

                                    <div class="mt-auto">
                                        <p class="card-text fw-bold h5 text-primary mb-3">
                                            Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                        </p>

                                        <div class="d-flex justify-content-end">
                                            <a href="<?= site_url('items/edit/' . $item['id']) ?>"
                                                class="btn btn-outline-warning btn-sm me-2"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="<?= site_url('items/delete/' . $item['id']) ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Hapus">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>