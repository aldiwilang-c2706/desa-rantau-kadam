<?php
$page_title = 'Pengumuman';
require __DIR__ . '/includes/header.php';

$items = db()->query('SELECT * FROM pengumuman ORDER BY tanggal_publish DESC, id DESC')->fetchAll();
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Pengumuman Desa</h1>
    </div>
</div>

<main class="container py-5">
    <div class="row g-3">
        <?php foreach($items as $x): ?>
            <div class="col-lg-8">
                <div class="card-clean p-4">
                    <small class="text-muted"><?= $x['tanggal_publish'] ?></small>
                    <h2 class="h5 fw-bold"><?= e($x['judul']) ?></h2>
                    <p><?= e(mb_substr(strip_tags($x['isi']), 0, 240)) ?>...</p>

                    <a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/detail_pengumuman.php?id=<?= $x['id'] ?>">Selengkapnya</a>

                    <?php if($x['file_pdf']): ?>
                        <a class="btn btn-sm btn-primary" target="_blank" href="<?= BASE_URL ?>/uploads/<?= e($x['file_pdf']) ?>">Unduh PDF</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
