<?php
$page_title = 'Berita Desa';
require __DIR__ . '/includes/header.php';

$pdo = db();
$q = trim($_GET['q'] ?? '');
$cat = trim($_GET['kategori'] ?? '');
$pg = max(1, (int)($_GET['page'] ?? 1));
$per = 6;
$w = [];
$p = [];

if ($q) {
    $w[] = '(judul LIKE ? OR isi LIKE ?)';
    $p[] = "%$q%";
    $p[] = "%$q%";
}

if ($cat) {
    $w[] = 'kategori=?';
    $p[] = $cat;
}

$ws = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$st = $pdo->prepare("SELECT COUNT(*) FROM berita $ws");
$st->execute($p);
$total = (int)$st->fetchColumn();

$pages = max(1, (int)ceil($total / $per));
$off = ($pg - 1) * $per;

$st = $pdo->prepare("SELECT * FROM berita $ws ORDER BY tanggal_publish DESC, id DESC LIMIT $per OFFSET $off");
$st->execute($p);
$items = $st->fetchAll();

$cats = $pdo->query('SELECT DISTINCT kategori FROM berita ORDER BY kategori')->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Berita Desa</h1>
        <p class="text-muted">Informasi kegiatan dan perkembangan desa.</p>
    </div>
</div>

<main class="container py-5">
    <form class="row g-2 mb-4">
        <div class="col-md-7">
            <input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Cari berita...">
        </div>
        <div class="col-md-3">
            <select class="form-select" name="kategori">
                <option value="">Semua Kategori</option>
                <?php foreach ($cats as $c): ?>
                    <option value="<?= e($c) ?>" <?= $cat === $c ? 'selected' : '' ?>><?= e($c) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <div class="row g-4">
        <?php foreach ($items as $x): ?>
            <div class="col-md-6">
                <article class="card-clean p-3 h-100">
                    <img class="news-thumb" src="<?= image_url($x['gambar']) ?>">
                    <small class="text-muted d-block mt-3"><?= $x['tanggal_publish'] ?> · <?= e($x['kategori']) ?></small>
                    <h2 class="h5 fw-bold mt-2"><?= e($x['judul']) ?></h2>
                    <p><?= e(mb_substr(strip_tags($x['isi']), 0, 180)) ?>...</p>
                    <a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/detail_berita.php?slug=<?= e($x['slug']) ?>">Baca Selengkapnya</a>
                </article>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!$items): ?>
        <div class="alert alert-info mt-4">Berita tidak ditemukan.</div>
    <?php endif; ?>

    <?php if ($pages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="page-item <?= $i === $pg ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(['q' => $q, 'kategori' => $cat, 'page' => $i]) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
