<?php
$page_title = 'Aparatur Desa';
require __DIR__ . '/includes/header.php';

$items = db()->query('SELECT * FROM perangkat_desa ORDER BY urutan_hirarki, id')->fetchAll();
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Aparatur Desa</h1>
        <p class="text-muted">Struktur organisasi Pemerintah Desa Rantau Kadam.</p>
    </div>
</div>

<main class="container py-5">
    <div class="row g-4 justify-content-center">
        <?php foreach ($items as $x): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card-clean p-4 text-center h-100">
                    <img src="<?= image_url($x['foto']) ?>" class="rounded-circle mx-auto mb-3" style="width: 120px; height: 120px; object-fit: cover">
                    <h2 class="h5 fw-bold"><?= e($x['nama']) ?></h2>
                    <span class="badge bg-primary"><?= e($x['jabatan']) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
