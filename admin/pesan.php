<?php
$page_title = 'Pesan Masuk';
$admin_active = 'pesan';
require __DIR__ . '/_header.php';

$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $pdo->prepare('DELETE FROM pesan_kontak WHERE id=?')->execute([(int)$_POST['id']]);
    set_flash('success', 'Pesan dihapus.');
    redirect(BASE_URL . '/admin/pesan.php');
}

$items = $pdo->query('SELECT * FROM pesan_kontak ORDER BY id DESC')->fetchAll();
?>

<h2 class="h5 fw-bold mb-3">Pesan Masuk</h2>

<div class="card-clean p-3">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $x): ?>
                    <tr>
                        <td><?= e($x['nama']) ?></td>
                        <td><?= e($x['email']) ?></td>
                        <td><?= e($x['subjek']) ?></td>
                        <td><?= $x['created_at'] ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="id" value="<?= $x['id'] ?>">
                                <button class="btn btn-sm btn-danger" data-confirm="Hapus pesan ini?">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/_footer.php'; ?>
