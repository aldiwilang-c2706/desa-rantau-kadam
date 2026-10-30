<?php
$page_title = 'Beranda';
$active = 'home';
require __DIR__ . '/includes/header.php';

$pdo = db();
$b = $pdo->query('SELECT * FROM berita ORDER BY tanggal_publish DESC, id DESC LIMIT 3')->fetchAll();
$p = $pdo->query('SELECT * FROM pengumuman ORDER BY tanggal_publish DESC, id DESC LIMIT 4')->fetchAll();
$g = $pdo->query('SELECT * FROM galeri ORDER BY tanggal_upload DESC, id DESC LIMIT 4')->fetchAll();
?>

<main class="container py-4">
  <section class="hero p-4 p-lg-5 mb-5">
      <div class="hero-content row align-items-center">
          <div class="col-lg-5 ms-lg-auto">
              <div class="hero-glass">
                  <span class="badge bg-primary mb-3">WEBSITE RESMI DESA</span>
                  <h1 class="display-6 fw-bold">Selamat Datang di Desa Rantau Kadam</h1>
                  <p class="opacity-75">Pusat informasi, pelayanan, dan transparansi Pemerintah Desa Rantau Kadam.</p>
                  <a href="<?= BASE_URL ?>/profil.php" class="btn btn-primary fw-semibold">Jelajahi Profil Desa →</a>
              </div>
          </div>
      </div>
  </section>

    <h2 class="section-title h4 mb-4">Layanan Cepat</h2>
    <div class="row g-3 mb-5">
        <?php foreach ([
            ['bi-person-vcard', 'Profil Desa', 'profil.php'],
            ['bi-people', 'Aparatur', 'aparatur.php'],
            ['bi-newspaper', 'Berita', 'berita.php'],
            ['bi-megaphone', 'Pengumuman', 'pengumuman.php'],
            ['bi-images', 'Galeri', 'galeri.php'],
            ['bi-envelope', 'Kontak', 'kontak.php']
        ] as $x): ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?= BASE_URL . '/' . $x[2] ?>" class="card-clean quick-card p-3 text-center text-dark d-block h-100">
                    <div class="icon-box mx-auto mb-2">
                        <i class="bi <?= $x[0] ?>"></i>
                    </div>
                    <strong><?= $x[1] ?></strong>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="section-title h4">Berita Terbaru</h2>
                <a href="<?= BASE_URL ?>/berita.php">Lihat semua</a>
            </div>

            <?php foreach ($b as $x): ?>
                <article class="card-clean p-3 mb-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <img class="news-thumb" src="<?= image_url($x['gambar']) ?>">
                        </div>
                        <div class="col-md-8">
                            <small class="text-muted"><?= $x['tanggal_publish'] ?> · <?= e($x['kategori']) ?></small>
                            <h3 class="h5 fw-bold mt-1"><?= e($x['judul']) ?></h3>
                            <p class="text-muted"><?= e(mb_substr(strip_tags($x['isi']), 0, 150)) ?>...</p>
                            <a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/detail_berita.php?slug=<?= e($x['slug']) ?>">Baca selengkapnya</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-5">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="section-title h4">Pengumuman</h2>
                <a href="<?= BASE_URL ?>/pengumuman.php">Semua</a>
            </div>
            <div class="card-clean p-3">
                <?php foreach ($p as $x): ?>
                    <div class="py-3 border-bottom">
                        <small class="text-muted"><?= $x['tanggal_publish'] ?></small>
                        <div class="fw-semibold"><?= e($x['judul']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <h2 class="section-title h4 mb-4">Galeri Kegiatan</h2>
            <div class="row g-3">
                <?php foreach ($g as $x): ?>
                    <div class="col-6 col-md-3">
                        <img class="gallery-thumb" src="<?= image_url($x['file_gambar']) ?>">
                        <small class="d-block mt-2 fw-semibold"><?= e($x['judul']) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-clean p-4 h-100">
                <h2 class="section-title h4">Informasi Kontak</h2>
                <p><?= e($site['alamat'] ?? '') ?></p>
                <p><?= e($site['telepon'] ?? '') ?></p>
                <p><?= e($site['email'] ?? '') ?></p>
                <a class="btn btn-primary" href="<?= BASE_URL ?>/kontak.php">Hubungi Kami</a>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
