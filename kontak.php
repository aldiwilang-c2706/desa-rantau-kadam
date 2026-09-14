<?php
$page_title = 'Kontak';
$active = 'kontak';
require __DIR__ . '/includes/header.php';

$err = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $n = trim($_POST['nama'] ?? '');
    $em = trim($_POST['email'] ?? '');
    $s = trim($_POST['subjek'] ?? '');
    $m = trim($_POST['pesan'] ?? '');

    if (!$n || !filter_var($em, FILTER_VALIDATE_EMAIL) || !$s || !$m) {
        $err = 'Semua field wajib diisi dan email harus valid.';
    } else {
        $st = db()->prepare('INSERT INTO pesan_kontak(nama, email, subjek, pesan) VALUES(?, ?, ?, ?)');
        $st->execute([$n, $em, $s, $m]);
        $ok = 'Pesan berhasil dikirim.';
    }
}
?>

<div class="page-header">
    <div class="container py-4">
        <h1 class="fw-bold">Kontak Kami</h1>
    </div>
</div>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-clean p-4 h-100">
                <h2 class="section-title h5">Hubungi Kami</h2>
                <p class="mt-4">
                    <b>Alamat</b><br>
                    <?= e($site['alamat'] ?? '') ?>
                </p>
                <p>
                    <b>Telepon</b><br>
                    <?= e($site['telepon'] ?? '') ?>
                </p>
                <p>
                    <b>Email</b><br>
                    <?= e($site['email'] ?? '') ?>
                </p>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card-clean p-4">
                <h2 class="section-title h5">Kirim Pesan</h2>

                <?php if ($ok): ?>
                    <div class="alert alert-success"><?= $ok ?></div>
                <?php endif; ?>

                <?php if ($err): ?>
                    <div class="alert alert-danger"><?= e($err) ?></div>
                <?php endif; ?>

                <form method="post" class="row g-3 mt-1">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input class="form-control" name="nama" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Subjek</label>
                        <input class="form-control" name="subjek" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pesan</label>
                        <textarea class="form-control" name="pesan" rows="6" required></textarea>
                    </div>

                    <div>
                        <button class="btn btn-primary">Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-clean p-3 mt-4">
        <h2 class="h5 fw-bold">Lokasi Kantor Desa</h2>
        <iframe class="w-100 rounded-3" height="360" loading="lazy" src="https://www.google.com/maps?q=Desa%20Rantau%20Kadam%20Musi%20Rawas%20Utara&output=embed"></iframe>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
