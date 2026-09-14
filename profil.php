<?php 
$page_title = 'Profil Desa';
$active = 'profil';
require __DIR__ . '/includes/header.php';

$p = db()->query('SELECT * FROM profil_desa ORDER BY id LIMIT 1')->fetch();
$pot = db()->query('SELECT * FROM potensi_desa ORDER BY id DESC')->fetchAll();
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Profil Desa</h1>
        <p class="text-muted">Informasi umum Desa Rantau Kadam.</p>
    </div>
</div>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-clean p-4 h-100">
                <h2 class="section-title h4">Sejarah Desa</h2>
                <p class="mt-4" style="white-space:pre-line"><?= e($p['sejarah'] ?? '') ?></p>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card-clean p-4 mb-4">
                <h2 class="section-title h4">Visi</h2>
                <p class="mt-4"><?= e($p['visi'] ?? '') ?></p>
            </div>
            
            <div class="card-clean p-4">
                <h2 class="section-title h4">Misi</h2>
                <p class="mt-4" style="white-space:pre-line"><?= e($p['misi'] ?? '') ?></p>
            </div>
        </div>
    </div>
    
    <div class="card-clean p-4 mt-4">
        <h2 class="section-title h4">Wilayah</h2>
        <p class="mt-4"><?= e($p['wilayah'] ?? '') ?></p>
        <p><b>Alamat:</b> <?= e($p['alamat'] ?? '') ?></p>
    </div>
    
    <h2 class="section-title h4 mt-5 mb-4">Potensi Desa</h2>
    
    <div class="row g-4">
        <?php foreach($pot as $x): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card-clean p-3 h-100">
                    <img class="gallery-thumb" src="<?= image_url($x['gambar']) ?>">
                    <span class="badge bg-success mt-3"><?= e($x['kategori']) ?></span>
                    <h3 class="h5 fw-bold mt-2"><?= e($x['judul']) ?></h3>
                    <p><?= e($x['deskripsi']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>