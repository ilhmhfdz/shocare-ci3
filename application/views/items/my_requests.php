<?php $this->load->view('templates/header') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5;
        /* Latar belakang sedikit lebih gelap */
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .order-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .order-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .order-card-header .service-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
    }

    .order-card-header .service-info {
        flex-grow: 1;
    }

    .status-badge {
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.5em 1em;
    }

    .admin-note {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
        /* Warna biru sebagai default */
        padding: 1rem;
        border-radius: 0 8px 8px 0;
    }

    .admin-note.status-completed {
        border-color: #198754;
    }

    .admin-note.status-rejected {
        border-color: #dc3545;
    }
</style>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bolder">Lacak Pesanan Anda</h1>
        <p class="text-muted fs-5">Riwayat dan progres terkini dari semua layanan Anda.</p>
    </div>

    <?php if (empty($requests)): ?>
        <div class="text-center bg-white p-5 rounded-3 shadow-sm">
            <i class="bi bi-box2-heart" style="font-size: 4rem; color: #6c757d;"></i>
            <h5 class="mt-3 fw-bold">Anda Belum Memiliki Pesanan</h5>
            <p class="text-muted">Jelajahi layanan kami dan buat pesanan pertama Anda!</p>
            <a href="<?= site_url('items/view_all') ?>" class="btn btn-primary mt-2 fw-bold">
                <i class="bi bi-compass"></i> Jelajahi Layanan
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($requests as $request): ?>
            <?php
            // Persiapan data status
            $status_list = [
                'pending'   => ['bg' => 'bg-warning-subtle text-warning-emphasis', 'label' => 'Pending'],
                'processed' => ['bg' => 'bg-info-subtle text-info-emphasis', 'label' => 'Diproses'],
                'completed' => ['bg' => 'bg-success-subtle text-success-emphasis', 'label' => 'Selesai'],
                'rejected'  => ['bg' => 'bg-danger-subtle text-danger-emphasis', 'label' => 'Ditolak']
            ];
            $current_status = $request['status'] ?? 'pending';
            $status_info = $status_list[$current_status];
            ?>

            <div class="bg-white p-4 rounded-3 shadow-sm mb-4 order-card">
                <div class="order-card-header">
                    <img src="<?= base_url('uploads/' . ($request['service_image'] ?? 'placeholder.png')) ?>" alt="Service Image" class="service-image">
                    <div class="service-info">
                        <h5 class="mb-1 fw-bold"><?= htmlspecialchars($request['service_name'] ?? 'N/A') ?></h5>
                        <small class="text-muted">
                            Dipesan pada <?= date('d F Y', strtotime($request['created_at'] ?? 'now')) ?>
                        </small>
                    </div>
                    <span class="badge rounded-pill <?= $status_info['bg'] ?> status-badge"><?= $status_info['label'] ?></span>
                </div>

                <hr>

                <div class="row g-3 align-items-center">
                    <div class="col-md-7">
                        <div class="admin-note status-<?= $current_status ?>">
                            <strong class="d-block mb-1">Update dari Admin:</strong>
                            <p class="text-muted mb-0">
                                <?= !empty($request['admin_notes']) ? htmlspecialchars($request['admin_notes']) : 'Belum ada update dari admin.' ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <a class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" href="#detail-<?= $request['id'] ?>" role="button">
                            Lihat Deskripsi Awal Anda <i class="bi bi-chevron-down ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="collapse mt-3" id="detail-<?= $request['id'] ?>">
                    <div class="bg-light p-3 rounded">
                        <strong class="d-block mb-1">Deskripsi Masalah Anda:</strong>
                        <p class="text-muted fst-italic mb-0">
                            "<?= !empty($request['description']) ? nl2br(htmlspecialchars($request['description'])) : '-' ?>"
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php $this->load->view('templates/footer') ?>