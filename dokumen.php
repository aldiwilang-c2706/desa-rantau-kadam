<?php
$page_title = 'Dokumen Publik';
require __DIR__ . '/includes/header.php';

$items = db()->query('SELECT * FROM dokumen_publik ORDER BY tanggal_upload DESC, id DESC')->fetchAll();
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Dokumen Publik</h1>
    </div>
</div>

<main class="container py-5">
    <div class="card-clean p-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Dokumen</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $x): ?>
                        <tr>
                            <td><?= e($x['judul_dokumen']) ?></td>
                            <td><?= $x['tanggal_upload'] ?></td>
                            <td>
                                <a target="_blank" class="btn btn-sm btn-primary" href="<?= BASE_URL ?>/uploads/<?= e($x['file_path']) ?>">Lihat PDF</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
