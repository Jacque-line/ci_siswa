<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa XI RPL</title>

    <!-- CDN CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333333;
        }

        .card {
            border: 1px solid #e3e6eb;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #edf0f2;
            padding: 1rem 1.25rem;
        }

        .table > thead > tr > th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #dee2e6;
            vertical-align: middle;
        }

        .table > tbody > tr > td {
            vertical-align: middle;
            font-size: 14px;
        }

        /* Pagination Bubble Style */
        .pagination-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin-top: 24px;
            user-select: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .pagination-custom .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border: 1px solid #b5b5b5;
            border-radius: 4px;
            background: linear-gradient(to bottom, #ffffff 0%, #e6e6e6 100%);
            color: #0066cc;
            text-decoration: none;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            line-height: 1;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .pagination-custom .page-btn:hover {
            background: linear-gradient(to bottom, #f0f0f0 0%, #dadada 100%);
            border-color: #888888;
            color: #004499;
        }

        .pagination-custom .page-btn.active {
            background: #c2c2c2;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.25);
            border-color: #777777;
            color: #222222;
            font-weight: bold;
            cursor: default;
        }

        .pagination-custom .page-btn-prev,
        .pagination-custom .page-btn-next {
            padding: 0 10px;
        }

        .pagination-custom .page-btn.disabled {
            background: #f5f5f5;
            border-color: #d8d8d8;
            color: #aaaaaa;
            box-shadow: none;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- 1. Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url(); ?>">Data Siswa XI RPL</a>
        </div>
    </nav>

    <!-- 2. Container Utama -->
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="card-title fw-bold m-0 text-dark">Daftar Siswa Terdaftar</h5>
                <!-- Tombol Pemicu Modal Tambah Data -->
                <button type="button" class="btn btn-primary btn-sm px-3 py-2 fw-medium" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    + Tambah Data Siswa
                </button>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="5%">No</th>
                                <th scope="col" width="20%">NIS</th>
                                <th scope="col">
                                    <a href="?sort=<?= ($sort ?? 'ASC') === 'ASC' ? 'desc' : 'asc' ?><?= isset($_GET['page']) ? '&page=' . esc($_GET['page']) : '' ?>" class="text-dark text-decoration-none d-inline-flex align-items-center gap-1" title="Klik untuk mengurutkan A-Z">
                                        <span>Nama</span>
                                        <span class="badge bg-secondary-subtle text-secondary border fw-normal" style="font-size: 11px;">
                                            <?= ($sort ?? 'ASC') === 'ASC' ? '&uarr; (A-Z)' : '&darr; (Z-A)' ?>
                                        </span>
                                    </a>
                                </th>
                                <th scope="col" width="20%">Kelas</th>
                                <th scope="col" class="text-center" width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($siswa)): ?>
                                <?php 
                                    $currentPage = isset($pager) ? (int)$pager->getCurrentPage() : 1;
                                    $no = 1 + (5 * ($currentPage - 1)); 
                                    $opsiKelas = ['X RPL 1', 'X RPL 2', 'X RPL 3', 'X RPL 4'];
                                ?>
                                <?php foreach ($siswa as $row) : ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $no++; ?></td>
                                        <td class="fw-medium font-monospace"><?= esc($row['nis']); ?></td>
                                        <td class="fw-medium"><?= esc($row['nama']); ?></td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                <?= esc($row['kelas']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-warning btn-sm text-white px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id']; ?>">
                                                    Edit
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <a href="<?= base_url('home/hapus/' . $row['id']); ?>" 
                                                   class="btn btn-danger btn-sm px-2 py-1" 
                                                   onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                                                    Hapus
                                                </a>
                                            </div>

                                            <!-- Modal Edit Data Siswa -->
                                            <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $row['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-warning text-white">
                                                            <h5 class="modal-title" id="modalEditLabel<?= $row['id']; ?>">Edit Data Siswa</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- Form Mengarah ke method 'edit' di Controller dengan membawa parameter ID -->
                                                        <form action="<?= base_url('home/edit/' . $row['id']); ?>" method="POST">
                                                            <div class="modal-body text-start">
                                                                <div class="mb-3">
                                                                    <label for="nisEdit<?= $row['id']; ?>" class="form-label fw-medium">NIS</label>
                                                                    <input type="text" name="nis" id="nisEdit<?= $row['id']; ?>" class="form-control" value="<?= esc($row['nis']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="namaEdit<?= $row['id']; ?>" class="form-label fw-medium">Nama Lengkap</label>
                                                                    <input type="text" name="nama" id="namaEdit<?= $row['id']; ?>" class="form-control" value="<?= esc($row['nama']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="kelasEdit<?= $row['id']; ?>" class="form-label fw-medium">Kelas</label>
                                                                    <select name="kelas" id="kelasEdit<?= $row['id']; ?>" class="form-select" required>
                                                                        <option value="" disabled>Pilih Kelas</option>
                                                                        <?php if (!empty($row['kelas']) && !in_array($row['kelas'], $opsiKelas)): ?>
                                                                            <option value="<?= esc($row['kelas']); ?>" selected><?= esc($row['kelas']); ?></option>
                                                                        <?php endif; ?>
                                                                        <?php foreach ($opsiKelas as $k): ?>
                                                                            <option value="<?= $k; ?>" <?= ($row['kelas'] === $k) ? 'selected' : ''; ?>><?= $k; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-warning text-white">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada data siswa.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Navigasi Halaman (Pagination Sesuai Gambar) -->
                <?php if (isset($pager)): ?>
                    <?php
                        $currentPage = (int) $pager->getCurrentPage();
                        $pageCount   = (int) $pager->getPageCount();
                        $sortParam   = (isset($sort) && $sort === 'DESC') ? '&sort=desc' : '';

                        $startPage = max(1, $currentPage - 4);
                        $endPage   = min($pageCount, $startPage + 8);
                        if ($endPage - $startPage < 8) {
                            $startPage = max(1, $endPage - 8);
                        }
                    ?>
                    <div class="pagination-custom">
                        <!-- Previous dengan bubble -->
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= base_url('?page=' . ($currentPage - 1) . $sortParam); ?>" class="page-btn page-btn-prev">
                                &larr; Previous
                            </a>
                        <?php else: ?>
                            <span class="page-btn page-btn-prev disabled">&larr; Previous</span>
                        <?php endif; ?>

                        <!-- Tombol Angka Halaman -->
                        <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
                            <?php if ($p == $currentPage): ?>
                                <span class="page-btn active"><?= $p; ?></span>
                            <?php else: ?>
                                <a href="<?= base_url('?page=' . $p . $sortParam); ?>" class="page-btn"><?= $p; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Ellipsis jika ada banyak halaman -->
                        <?php if ($endPage < $pageCount): ?>
                            <span class="px-1 text-muted">...</span>
                            <a href="<?= base_url('?page=' . $pageCount . $sortParam); ?>" class="page-btn"><?= $pageCount; ?></a>
                        <?php endif; ?>

                        <!-- Next dengan bubble -->
                        <?php if ($currentPage < $pageCount): ?>
                            <a href="<?= base_url('?page=' . ($currentPage + 1) . $sortParam); ?>" class="page-btn page-btn-next">
                                Next &rarr;
                            </a>
                        <?php else: ?>
                            <span class="page-btn page-btn-next disabled">
                                Next &rarr;
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Siswa -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form Mengarah ke method 'tambah' di Controller -->
                <form action="<?= base_url('home/tambah'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nis" class="form-label fw-medium">NIS</label>
                            <input type="text" name="nis" id="nis" class="form-control" placeholder="Masukkan NIS" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label fw-medium">Kelas</label>
                            <select name="kelas" id="kelas" class="form-select" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="X RPL 1">X RPL 1</option>
                                <option value="X RPL 2">X RPL 2</option>
                                <option value="X RPL 3">X RPL 3</option>
                                <option value="X RPL 4">X RPL 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CDN JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
