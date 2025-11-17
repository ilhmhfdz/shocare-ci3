<?php $this->load->view('templates/header') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Style untuk komponen upload gambar kustom */
    .image-upload-container {
        border: 2px dashed #ced4da;
        border-radius: .375rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s ease-in-out, background-color .15s ease-in-out;
        position: relative;
    }

    .image-upload-container:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }

    .image-upload-container .upload-icon {
        font-size: 3rem;
        color: #6c757d;
    }

    .image-upload-container p {
        margin-top: 1rem;
        color: #6c757d;
    }

    #image-input {
        display: none;
        /* Sembunyikan input file asli */
    }

    #image-preview {
        max-width: 100%;
        max-height: 250px;
        /* Batasi tinggi preview */
        margin-top: 1rem;
        border-radius: .375rem;
    }

    .image-preview-wrapper {
        position: relative;
    }
</style>

<div class="container main-content my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-plus-circle-dotted me-2"></i>
                        Layanan Baru
                    </h5>
                </div>

                <div class="card-body p-4">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <?php echo validation_errors(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data" action="<?= site_url('items/create') ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Layanan</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Judul layanan disini" value="<?= set_value('name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Jelaskan secara rinci tentang service yang ditawarkan..." required><?= set_value('description') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori</label>
                            <select id="kategori" name="kategori" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="cuci" <?= set_select('kategori', 'cuci') ?>>Jasa Cuci</option>
                                <option value="perawatan" <?= set_select('kategori', 'perawatan') ?>>Jasa Perawatan</option>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="harga" class="form-label fw-bold">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="harga" name="harga" class="form-control" placeholder="Contoh: 150000" value="<?= set_value('harga') ?>" required min="0">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Service</label>
                            <div class="image-preview-wrapper">
                                <div id="image-upload-box" class="image-upload-container">
                                    <i class="bi bi-cloud-arrow-up upload-icon"></i>
                                    <p><b>Pilih gambar</b> atau seret ke sini</p>
                                </div>
                                <img id="image-preview" src="#" alt="Image Preview" class="d-none" />
                            </div>
                            <input type="file" id="image-input" name="image" class="form-control" accept="image/*">
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('items') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>
                                Simpan Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ... (kode JavaScript untuk preview gambar tetap sama, tidak perlu diubah) ...
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploadBox = document.getElementById('image-upload-box');
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');

        const triggerFileInput = () => {
            imageInput.click();
        };
        imageUploadBox.addEventListener('click', triggerFileInput);

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    imageUploadBox.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        imageUploadBox.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation();
            imageUploadBox.style.borderColor = '#0d6efd';
        });
        imageUploadBox.addEventListener('dragleave', (e) => {
            e.preventDefault();
            e.stopPropagation();
            imageUploadBox.style.borderColor = '#ced4da';
        });
        imageUploadBox.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation();
            imageUploadBox.style.borderColor = '#ced4da';
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                const changeEvent = new Event('change');
                imageInput.dispatchEvent(changeEvent);
            }
        });
    });
</script>


<?php $this->load->view('templates/footer') ?>