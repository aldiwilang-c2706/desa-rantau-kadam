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
                        <?php
                        $ext = strtolower(pathinfo($x['file_path'], PATHINFO_EXTENSION));
                        $url = BASE_URL . '/uploads/' . e($x['file_path']);
                        ?>
                        <tr>
                            <td><?= e($x['judul_dokumen']) ?></td>
                            <td><?= e($x['tanggal_upload']) ?></td>
                            <td>
                                <?php if ($ext === 'docx'): ?>
                                    <a class="btn btn-sm btn-outline-primary" href="<?= $url ?>" download>Unduh DOCX</a>
                                <?php else: ?>
                                    <a target="_blank" rel="noopener" class="btn btn-sm btn-primary" href="<?= $url ?>">Lihat PDF</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
