<?php
// Kode ini sebaiknya ada di file footer.php atau file template yang relevan
?>

<style>
    /* Style kustom untuk footer yang lebih modern */
    .footer-modern {
        background-color: #212529;
        /* Warna dark yang sedikit lebih lembut dari bg-dark */
        color: #adb5bd;
        /* Warna teks yang tidak terlalu kontras */
        font-size: 0.9rem;
    }

    .footer-modern h5 {
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 1.25rem;
    }

    .footer-modern .footer-links a {
        color: #adb5bd;
        text-decoration: none;
        transition: color 0.2s ease-in-out, padding-left 0.2s ease-in-out;
        display: block;
        padding: 5px 0;
    }

    .footer-modern .footer-links a:hover {
        color: #ffffff;
        padding-left: 5px;
        /* Efek geser saat hover */
    }

    .footer-modern .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        text-decoration: none;
        margin-right: 10px;
        transition: background-color 0.2s ease-in-out;
    }

    .footer-modern .social-icons a:hover {
        background-color: #0d6efd;
        /* Warna primer Bootstrap */
    }

    .footer-copyright {
        background-color: #1a1e21;
        padding: 1rem 0;
        font-size: 0.8rem;
    }
</style>

<footer class="footer-modern mt-auto">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5>Tentang SHOCARE</h5>
                <p>
                    SHOCARE adalah solusi profesional untuk perawatan dan pembersihan sepatu Anda. Kami berkomitmen memberikan layanan terbaik dengan hasil yang memuaskan.
                </p>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5>Link Cepat</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= site_url('items/view_all') ?>">Layanan</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5>Hubungi Kami</h5>
                <ul class="list-unstyled">
                    <li class="d-flex mb-2">
                        <i class="bi bi-geo-alt-fill me-2 mt-1" style="color: #0d6efd;"></i>
                        <span>Jl. Atang Senjaya, Kemang, Bogor, Jawa Barat</span>
                    </li>
                    <li class="d-flex mb-2">
                        <i class="bi bi-telephone-fill me-2 mt-1" style="color: #0d6efd;"></i>
                        <span>(0251) 123-456</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Ikuti Kami</h5>
                <p>Dapatkan info terbaru dan promo menarik di sosial media kami.</p>
                <div class="social-icons">
                    <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" title="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copyright text-center">
        <div class="container">
            &copy; <?= date('Y') ?> <strong>SHOCARE</strong>. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>