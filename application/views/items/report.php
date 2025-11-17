<?php $this->load->view('templates/header') ?>

<style>
    /* ... Semua style CSS Anda yang ada di sini tetap sama ... */
    body {
        background-color: #f8f9fa;
    }

    .card-report {
        border: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease-in-out;
    }

    .card-header-gradient {
        background: linear-gradient(45deg, #0d6efd, #6f42c1);
        color: white;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }

    .card-header-gradient .h5 {
        font-weight: 500;
    }

    .card-header-gradient i {
        font-size: 1.5rem;
        opacity: 0.8;
    }

    .no-data-view {
        padding: 4rem 2rem;
    }

    .no-data-view svg {
        width: 120px;
        height: 120px;
        margin-bottom: 1.5rem;
        opacity: 0.6;
    }

    .no-data-view .text-muted {
        font-size: 1.25rem;
    }

    .table thead {
        background-color: #e9ecef;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody {
        border-top: none;
    }

    .table-hover>tbody>tr {
        transition: background-color 0.2s ease-in-out;
    }

    .table-hover>tbody>tr:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }

    .table td,
    .table th {
        vertical-align: middle;
        padding: 1rem;
    }

    .table tfoot {
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }

    .table tfoot .total-label {
        font-weight: 500;
        color: #6c757d;
    }

    .table tfoot .total-value {
        font-weight: 700;
        font-size: 1.2rem;
    }
</style>

<div class="container main-content my-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card card-report shadow-lg">
                <div class="card-header card-header-gradient py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-bar-chart-line-fill me-3"></i>
                        Laporan Rincian Status Pesanan per Layanan
                    </h5>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($report_data)): ?>
                        <div class="text-center no-data-view">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-x" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                            </svg>
                            <p class="text-muted">Data Laporan Belum Tersedia</p>
                            <small class="d-block text-secondary">Saat ada pesanan baru, data akan muncul di sini.</small>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" class="ps-4">No</th>
                                        <th scope="col">Nama Layanan</th>
                                        <th scope="col" class="text-center text-warning">Pending</th>
                                        <th scope="col" class="text-center text-primary">Processed</th>
                                        <th scope="col" class="text-center text-success">Completed</th>
                                        <th scope="col" class="text-center text-danger">Rejected</th>
                                        <th scope="col" class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($report_data as $index => $row): ?>
                                        <tr>
                                            <th scope="row" class="ps-4"><?= $index + 1 ?></th>
                                            <td><?= htmlspecialchars($row['service_name']) ?></td>
                                            <td class="text-center fw-bold"><?= $row['pending_count'] ?></td>
                                            <td class="text-center fw-bold"><?= $row['processed_count'] ?></td>
                                            <td class="text-center fw-bold"><?= $row['completed_count'] ?></td>
                                            <td class="text-center fw-bold"><?= $row['rejected_count'] ?></td>
                                            <td class="text-center fw-bold"><?= $row['total_requests'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end total-label pe-4">Total Keseluruhan:</td>
                                        <td class="text-center total-value text-warning"><?= $total_pending ?? 0 ?></td>
                                        <td class="text-center total-value text-primary"><?= $total_processed ?? 0 ?></td>
                                        <td class="text-center total-value text-success"><?= $total_completed ?? 0 ?></td>
                                        <td class="text-center total-value text-danger"><?= $total_rejected ?? 0 ?></td>
                                        <td class="text-center total-value text-dark"><?= $total_all_requests ?? 0 ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-body-tertiary text-center text-muted small">
                    Laporan ini dibuat pada: <?= date('d F Y, H:i:s') ?>. Total jenis layanan: <?= $total_services ?? 0 ?>.
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer') ?>