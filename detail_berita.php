<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$st = db()->prepare('SELECT * FROM berita WHERE slug=?');
$st->execute([$_GET['slug'] ?? '']);
$b = $st->fetch();

if (!$b) {
    http_response_code(404);
    exit('Berita tidak ditemukan.');
}

$page_title = $b['judul'];
require __DIR__ . '/includes/header.php';
?>

<main class="container py-5">
    <div class="col-lg-9 mx-auto">
        <a href="<?= BASE_URL ?>/berita.php">← Kembali</a>
        <h1 class="display-6 fw-bold mt-3"><?= e($b['judul']) ?></h1>
        <p class="text-muted"><?= $b['tanggal_publish'] ?> · <?= e($b['kategori']) ?></p>
        <img class="w-100 rounded-4 mb-4" style="max-height: 480px; object-fit: cover" src="<?= image_url($b['gambar']) ?>">
        <div class="card-clean p-4" style="white-space:pre-line"><?= e($b['isi']) ?></div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
