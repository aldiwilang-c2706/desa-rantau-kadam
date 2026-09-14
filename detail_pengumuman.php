<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$st = db()->prepare('SELECT * FROM pengumuman WHERE id=?');
$st->execute([(int)($_GET['id'] ?? 0)]);
$p = $st->fetch();

if (!$p) {
    http_response_code(404);
    exit('Pengumuman tidak ditemukan.');
}

$page_title = $p['judul'];
require __DIR__ . '/includes/header.php';
?>

<main class="container py-5">
    <div class="col-lg-9 mx-auto">
        <a href="<?= BASE_URL ?>/pengumuman.php">← Kembali</a>
        <h1 class="fw-bold mt-3"><?= e($p['judul']) ?></h1>
        <p class="text-muted"><?= $p['tanggal_publish'] ?></p>
        <div class="card-clean p-4" style="white-space:pre-line"><?= e($p['isi']) ?></div>

        <?php if ($p['file_pdf']): ?>
            <a class="btn btn-primary mt-3" target="_blank" href="<?= BASE_URL ?>/uploads/<?= e($p['file_pdf']) ?>">Unduh PDF</a>
        <?php endif; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
