<?php
$page_title = 'Profil Desa';
$admin_active = 'profil';
require __DIR__ . '/_header.php';

$pdo = db();
$x = $pdo->query('SELECT * FROM profil_desa ORDER BY id LIMIT 1')->fetch();
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fields = ['sejarah', 'visi', 'misi', 'wilayah', 'alamat', 'telepon', 'email'];
    $v = [];

    foreach ($fields as $f) {
        $v[] = trim($_POST[$f] ?? '');
    }

    $st = $pdo->prepare('UPDATE profil_desa SET sejarah=?, visi=?, misi=?, wilayah=?, alamat=?, telepon=?, email=? WHERE id=?');
    $st->execute([...$v, $x['id']]);

    log_activity('Memperbarui profil desa');
    set_flash('success', 'Profil berhasil diperbarui.');
    redirect(BASE_URL . '/admin/profil.php');
}
?>

<div class="card-clean p-4">
    <h2 class="h5 fw-bold">Profil Desa</h2>

    <form method="post" class="row g-3 mt-1">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <?php foreach (['sejarah', 'visi', 'misi', 'wilayah', 'alamat'] as $f): ?>
            <div class="col-md-6">
                <label class="form-label"><?= ucwords($f) ?></label>
                <textarea class="form-control" name="<?= $f ?>" rows="5"><?= e($x[$f] ?? '') ?></textarea>
            </div>
        <?php endforeach; ?>

        <div class="col-md-6">
            <label class="form-label">Telepon</label>
            <input class="form-control" name="telepon" value="<?= e($x['telepon'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" value="<?= e($x['email'] ?? '') ?>">
        </div>

        <div>
            <button class="btn btn-primary">Simpan Profil</button>
        </div>
    </form>
</div>

<?php require __DIR__ . '/_footer.php'; ?>
