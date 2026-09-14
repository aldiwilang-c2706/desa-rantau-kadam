<?php
$page_title = 'Galeri';
$active = 'galeri';
require __DIR__ . '/includes/header.php';

$pdo = db();
$cat = trim($_GET['kategori'] ?? '');
$cats = $pdo->query('SELECT DISTINCT kategori FROM galeri ORDER BY kategori')->fetchAll(PDO::FETCH_COLUMN);

if ($cat) {
    $st = $pdo->prepare('SELECT * FROM galeri WHERE kategori=? ORDER BY tanggal_upload DESC, id DESC');
    $st->execute([$cat]);
    $items = $st->fetchAll();
} else {
    $items = $pdo->query('SELECT * FROM galeri ORDER BY tanggal_upload DESC, id DESC')->fetchAll();
}
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Galeri Desa</h1>
    </div>
</div>

<main class="container py-5">
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a class="btn btn-sm <?= !$cat ? 'btn-primary' : 'btn-outline-primary' ?>" href="?">Semua</a>
        <?php foreach ($cats as $c): ?>
            <a class="btn btn-sm <?= $cat === $c ? 'btn-primary' : 'btn-outline-primary' ?>" href="?kategori=<?= urlencode($c) ?>"><?= e($c) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php foreach ($items as $x): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card-clean p-2 h-100">
                    <img class="gallery-thumb" src="<?= image_url($x['file_gambar']) ?>">
                    <div class="p-2">
                        <small class="text-muted"><?= e($x['kategori']) ?></small>
                        <div class="fw-semibold"><?= e($x['judul']) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
