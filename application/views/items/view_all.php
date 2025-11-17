<?php $this->load->view('templates/header') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Menghapus semua style lama dan menggantinya dengan yang baru */
    .hero-banner {
        position: relative;
        color: white;
        padding: 8rem 0;
        background-image: url('<?= base_url("assets/images/banner.png") ?>');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(13, 110, 253, 0.7), rgba(13, 202, 240, 0.5));
        z-index: 1;
    }

    .hero-banner .container {
        position: relative;
        z-index: 2;
    }

    /* Section Keunggulan */
    .feature-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 4rem;
        height: 4rem;
        font-size: 2rem;
        color: #fff;
        background: linear-gradient(45deg, #0d6efd, #0dcaf0);
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }

    /* Style BARU untuk Kartu Layanan Interaktif */
    .service-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        /* Penting untuk efek zoom gambar */
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.12);
    }

    .card-img-container {
        overflow: hidden;
        /* Menyembunyikan bagian gambar yang zoom keluar */
        height: 220px;
    }

    .card-img-top {
        transition: transform 0.4s ease;
    }

    .service-card:hover .card-img-top {
        transform: scale(1.05);
        /* Efek zoom pada gambar saat hover */
    }

    .card-title {
        font-weight: 600;
    }

    .card-price {
        font-weight: 600;
        font-size: 1.25rem;
    }

    /* Logika untuk tombol yang muncul saat hover */
    .card-actions {
        transition: opacity 0.3s ease, transform 0.3s ease;
        opacity: 0;
        /* Sembunyi secara default */
        transform: translateY(10px);
    }

    .service-card:hover .card-actions {
        opacity: 1;
        /* Muncul saat kartu di-hover */
        transform: translateY(0);
    }

    /* Animasi Scroll */
    .fade-in-section {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .fade-in-section.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="hero-banner text-center">
    <div class="container">
        <h1 class="display-4 fw-bolder">SHOCARE Adalah Solusi Total Perawatan Sepatu Anda</h1>
        <p class="col-lg-8 mx-auto lead">
            Dari noda membandel hingga warna yang pudar, kami hadir untuk mengembalikan kejayaan sepatu kesayangan Anda dengan sentuhan profesional.
        </p>
        <a href="#layanan" class="btn btn-light btn-lg fw-bold mt-3">
            <i class="bi bi-arrow-down-circle me-2"></i> Jelajahi Layanan Kami
        </a>
    </div>
</div>
<section class="py-5 fade-in-section">
    <div class="container px-4">
        <div class="row gx-5 text-center">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                <h3 class="fw-bold">Profesional</h3>
                <p class="text-muted">Dikerjakan oleh tim yang berpengalaman dan terlatih khusus di bidang perawatan sepatu.</p>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                <h3 class="fw-bold">Kualitas Terjamin</h3>
                <p class="text-muted">Kami menggunakan bahan pembersih premium yang aman dan efektif untuk semua jenis material.</p>
            </div>
            <div class="col-lg-4">
                <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
                <h3 class="fw-bold">Proses Cepat</h3>
                <p class="text-muted">Layanan cepat dan tepat waktu tanpa mengurangi kualitas hasil akhir pekerjaan kami.</p>
            </div>
        </div>
    </div>
</section>


<div class="py-5 bg-light" id="layanan">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5 fade-in-section">
                <h2 class="fw-bolder display-5">Layanan Unggulan Kami</h2>
                <p class="lead text-muted">Temukan solusi yang tepat untuk setiap masalah sepatu Anda.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php if (empty($items)): ?>
                <div class="col text-center py-5 fade-in-section">
                    <i class="bi bi-box2-heart fs-1 text-muted mb-3"></i>
                    <p>Saat ini belum ada layanan yang tersedia.</p>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-lg-4 col-md-6 fade-in-section">
                        <div class="card h-100 service-card">
                            <div class="card-img-container">
                                <img src="<?= $item['image'] ? base_url('uploads/' . $item['image']) : base_url('assets/images/placeholder.png') ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($item['name']) ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                                <p class="card-text text-muted small">
                                    <?= htmlspecialchars($item['description']) ?>
                                </p>

                                <div class="mt-auto pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-primary card-price mb-0">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>

                                        <div class="card-actions">
                                            <?php if ($this->session->userdata('logged_in') && $this->session->userdata('role') === 'user'): ?>
                                                <a href="<?= site_url('items/request_service/' . $item['id']) ?>" class="btn btn-primary">Pesan</a>
                                            <?php elseif ($this->session->userdata('logged_in') && $this->session->userdata('role') === 'admin'): ?>
                                                <a href="<?= site_url('items/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                                <a href="<?= site_url('items/delete/' . $item['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin?')"><i class="bi bi-trash"></i></a>
                                            <?php else: ?>
                                                <a href="<?= site_url('auth/login') ?>" class="btn btn-outline-primary">Login</a>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer') ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sections = document.querySelectorAll('.fade-in-section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>