<?php $this->load->view('templates/header') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Style untuk baris tabel yang bisa diklik */
    .table-hover .request-row {
        cursor: pointer;
    }

    /* Memberi latar belakang pada area form yang terbuka */
    .collapse-form-container {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-top: 1px solid #dee2e6;
    }
</style>

<div class="container main-content my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 d-flex align-items-center">
                <i class="bi bi-ui-checks-grid me-2"></i>
                Kelola Request Service
            </h5>
        </div>

        <div class="card-body p-0"> <?php if ($this->session->flashdata('message')): ?>
                <div class="m-3">
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>
                            <?= $this->session->flashdata('message') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">User</th>
                            <th>Jasa</th>
                            <th>Status</th>
                            <th>Tanggal Request</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="5">
                                    <div class="text-center p-5">
                                        <i class="bi bi-inbox" style="font-size: 4rem; color: #6c757d;"></i>
                                        <h5 class="mt-3">Tidak Ada Request</h5>
                                        <p class="text-muted">Saat ini belum ada request service yang masuk.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $request): ?>
                                <?php
                                // Persiapan data status untuk tampilan
                                $status_list = [
                                    'pending' => ['class' => 'text-bg-warning', 'icon' => 'bi-hourglass-split', 'label' => 'Pending'],
                                    'processed' => ['class' => 'text-bg-info', 'icon' => 'bi-gear', 'label' => 'Processed'],
                                    'completed' => ['class' => 'text-bg-success', 'icon' => 'bi-check-circle', 'label' => 'Completed'],
                                    'rejected' => ['class' => 'text-bg-danger', 'icon' => 'bi-x-circle', 'label' => 'Rejected']
                                ];
                                $current_status = $request['status'] ?? 'pending';
                                $status_info = $status_list[$current_status];
                                ?>

                                <tr class="request-row" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $request['id'] ?>" aria-expanded="false" aria-controls="collapse-<?= $request['id'] ?>">
                                    <td class="ps-3"><?= htmlspecialchars($request['username'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($request['service_name'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge <?= $status_info['class'] ?>">
                                            <i class="bi <?= $status_info['icon'] ?> me-1"></i>
                                            <?= $status_info['label'] ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($request['created_at'] ?? 'now')) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary toggle-icon">
                                            Kelola <i class="bi bi-chevron-down"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="p-0">
                                        <div class="collapse" id="collapse-<?= $request['id'] ?>">
                                            <div class="collapse-form-container">
                                                <p><strong>Deskripsi Masalah dari User:</strong></p>
                                                <p class="text-muted fst-italic border-start border-4 ps-3">
                                                    <?= !empty($request['description']) ? nl2br(htmlspecialchars($request['description'])) : 'Tidak ada deskripsi.' ?>
                                                </p>
                                                <hr>

                                                <?= form_open('items/update_request/' . $request['id']) ?>
                                                <div class="row align-items-end g-3">
                                                    <div class="col-lg-6">
                                                        <label for="admin_notes-<?= $request['id'] ?>" class="form-label">Catatan Admin:</label>
                                                        <textarea id="admin_notes-<?= $request['id'] ?>" name="admin_notes" class="form-control" rows="3" placeholder="Tambahkan catatan..."><?= htmlspecialchars($request['admin_notes'] ?? '') ?></textarea>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="status-<?= $request['id'] ?>" class="form-label">Ubah Status:</label>
                                                        <select id="status-<?= $request['id'] ?>" name="status" class="form-select">
                                                            <option value="pending" <?= $current_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="processed" <?= $current_status == 'processed' ? 'selected' : '' ?>>Processed</option>
                                                            <option value="completed" <?= $current_status == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                            <option value="rejected" <?= $current_status == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="bi bi-check-lg"></i> Update
                                                        </button>
                                                    </div>
                                                </div>
                                                <?= form_close() ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(function(collapseEl) {
            collapseEl.addEventListener('show.bs.collapse', function() {
                // Cari tombol di dalam baris sebelumnya
                var triggerRow = this.parentElement.parentElement.previousElementSibling;
                var buttonIcon = triggerRow.querySelector('.toggle-icon i');
                if (buttonIcon) {
                    buttonIcon.classList.remove('bi-chevron-down');
                    buttonIcon.classList.add('bi-chevron-up');
                }
            });

            collapseEl.addEventListener('hide.bs.collapse', function() {
                // Cari tombol di dalam baris sebelumnya
                var triggerRow = this.parentElement.parentElement.previousElementSibling;
                var buttonIcon = triggerRow.querySelector('.toggle-icon i');
                if (buttonIcon) {
                    buttonIcon.classList.remove('bi-chevron-up');
                    buttonIcon.classList.add('bi-chevron-down');
                }
            });
        });
    });
</script>