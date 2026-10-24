<?php
require_once __DIR__ . '/../config/auth.php';
require_login();

$pdo = db();
$module = $_GET['module'] ?? '';
$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$error = '';

$config = [
    'berita' => [
        'table'  => 'berita',
        'title'  => 'Berita',
        'fields' => ['judul', 'isi', 'kategori', 'tanggal_publish'],
        'image'  => 'gambar'
    ],
    'pengumuman' => [
        'table'  => 'pengumuman',
        'title'  => 'Pengumuman',
        'fields' => ['judul', 'isi', 'tanggal_publish'],
        'pdf'    => 'file_pdf'
    ],
    'galeri' => [
        'table'  => 'galeri',
        'title'  => 'Galeri',
        'fields' => ['judul', 'kategori', 'tanggal_upload'],
        'image'  => 'file_gambar'
    ],
    'potensi' => [
        'table'  => 'potensi_desa',
        'title'  => 'Potensi Desa',
        'fields' => ['kategori', 'judul', 'deskripsi'],
        'image'  => 'gambar'
    ],
    'perangkat' => [
        'table'  => 'perangkat_desa',
        'title'  => 'Perangkat Desa',
        'fields' => ['nama', 'jabatan', 'urutan_hirarki'],
        'image'  => 'foto'
    ],
    'dokumen' => [
        'table'  => 'dokumen_publik',
        'title'  => 'Dokumen Publik',
        'fields' => ['judul_dokumen', 'tanggal_upload'],
        'pdf'    => 'file_path',
    ]
];

if (!isset($config[$module])) {
    exit('Modul tidak tersedia.');
}

$c = $config[$module];
$page_title = 'Kelola ' . $c['title'];
$admin_active = $module;
require __DIR__ . '/_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $a = $_POST['action'] ?? '';

        if ($a === 'delete') {
            $st = $pdo->prepare("SELECT * FROM {$c['table']} WHERE id=?");
            $st->execute([(int)$_POST['id']]);
            $old = $st->fetch();

            $pdo->prepare("DELETE FROM {$c['table']} WHERE id=?")->execute([(int)$_POST['id']]);
            delete_upload($old[$c['image'] ?? $c['pdf'] ?? ''] ?? null);
            log_activity('Menghapus ' . $c['title']);
            set_flash('success', $c['title'] . ' berhasil dihapus.');
            redirect(BASE_URL . '/admin/' . $module . '.php');
        }

        if ($a === 'save') {
            $id = (int)$_POST['id'];
            $vals = [];
            foreach ($c['fields'] as $f) {
                $vals[] = trim($_POST[$f] ?? '');
            }

            $file = null;
            if (isset($c['image'])) {
                $file = upload_file($_FILES[$c['image']] ?? [], 'image');
            }
            if (isset($c['pdf'])) {
                $file = upload_file($_FILES[$c['pdf']] ?? [], $c['filetype'] ?? 'pdf');
            }

            if ($id) {
                $st = $pdo->prepare("SELECT * FROM {$c['table']} WHERE id=?");
                $st->execute([$id]);
                $old = $st->fetch();

                if (isset($c['image']) || isset($c['pdf'])) {
                    $file = $file ?? ($old[$c['image'] ?? $c['pdf']] ?? null);
                }

                $set = [];
                foreach ($c['fields'] as $f) {
                    $set[] = "$f=?";
                }
                $set[] = (isset($c['image']) ? $c['image'] : $c['pdf']) . '=?';

                $vals[] = $file;
                $vals[] = $id;

                $pdo->prepare("UPDATE {$c['table']} SET " . implode(',', $set) . " WHERE id=?")
                    ->execute(array_merge(array_slice($vals, 0, -2), [$file, $id]));

                if (!empty($old[$c['image'] ?? $c['pdf'] ?? '']) && $file !== $old[$c['image'] ?? $c['pdf']]) {
                    delete_upload($old[$c['image'] ?? $c['pdf']]);
                }
            } else {
                if ($module === 'berita') {
                    $slug = unique_slug($_POST['judul']);
                    $pdo->prepare('INSERT INTO berita(judul, slug, isi, kategori, gambar, tanggal_publish, id_user) VALUES(?, ?, ?, ?, ?, ?, ?)')
                        ->execute([$vals[0], $slug, $vals[1], $vals[2], $file, $vals[3], current_user()['id']]);
                } else {
                    $cols = $c['fields'];
                    if (isset($c['image']) || isset($c['pdf'])) {
                        $cols[] = $c['image'] ?? $c['pdf'];
                        $vals[] = $file;
                    }
                    $pdo->prepare("INSERT INTO {$c['table']}(" . implode(',', $cols) . ") VALUES(" . rtrim(str_repeat('?,', count($cols)), ',') . ")")
                        ->execute($vals);
                }
            }

            log_activity(($id ? 'Mengubah ' : 'Menambah ') . $c['title']);
            set_flash('success', $c['title'] . ' berhasil disimpan.');
            redirect(BASE_URL . '/admin/' . $module . '.php');
        }
    } catch (Throwable $e) {
        $error = $e->getMessage();
        $action = 'form';
    }
}

if ($action === 'form') {
    $item = array_fill_keys($c['fields'], '');
    $item['id'] = $id;
    if ($id) {
        $st = $pdo->prepare("SELECT * FROM {$c['table']} WHERE id=?");
        $st->execute([$id]);
        $item = $st->fetch() ?: $item;
    }
?>
    <div class="card-clean p-4">
        <div class="d-flex justify-content-between">
            <h2 class="h5 fw-bold"><?= $id ? 'Edit ' : 'Tambah ' ?><?= e($c['title']) ?></h2>
            <a class="btn btn-light" href="<?= BASE_URL ?>/admin/<?= $module ?>.php">Kembali</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="row g-3 mt-1">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $id ?>">

            <?php foreach ($c['fields'] as $f): ?>
                <div class="<?= in_array($f, ['isi', 'deskripsi']) ? 'col-12' : 'col-md-6' ?>">
                    <label class="form-label"><?= e(ucwords(str_replace('_', ' ', $f))) ?></label>

                    <?php if (in_array($f, ['isi', 'deskripsi'])): ?>
                        <textarea class="form-control" rows="8" name="<?= $f ?>" required><?= e($item[$f] ?? '') ?></textarea>
                    <?php elseif ($f === 'tanggal_publish' || $f === 'tanggal_upload'): ?>
                        <input class="form-control" type="date" name="<?= $f ?>" value="<?= e($item[$f] ?? date('Y-m-d')) ?>" required>
                    <?php elseif ($f === 'urutan_hirarki'): ?>
                        <input class="form-control" type="number" name="<?= $f ?>" value="<?= e((string)($item[$f] ?? 0)) ?>">
                    <?php else: ?>
                        <input class="form-control" name="<?= $f ?>" value="<?= e($item[$f] ?? '') ?>" required>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if (isset($c['image'])): ?>
                <div class="col-md-6">
                    <label class="form-label">Gambar JPG/PNG (maks. 2 MB)</label>
                    <input class="form-control" type="file" name="<?= $c['image'] ?>" accept=".jpg,.jpeg,.png">
                </div>
            <?php endif; ?>

            <?php if (isset($c['pdf'])): $isDoc = ($c['filetype'] ?? 'pdf') === 'doc'; ?>
                <div class="col-md-6">
                    <label class="form-label"><?= $isDoc ? 'PDF atau DOCX (maks. 5 MB)' : 'PDF (maks. 5 MB)' ?></label>
                    <input class="form-control" type="file" name="<?= $c['pdf'] ?>" accept="<?= $isDoc ? '.pdf,.docx' : '.pdf' ?>">
                </div>
            <?php endif; ?>

            <div>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
<?php
} else {
    $items = $pdo->query("SELECT * FROM {$c['table']} ORDER BY id DESC")->fetchAll();
?>
    <div class="d-flex justify-content-between mb-3">
        <h2 class="h5 fw-bold"><?= e($c['title']) ?></h2>
        <a class="btn btn-primary" href="?action=form">+ Tambah</a>
    </div>

    <div class="card-clean p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <?php foreach ($c['fields'] as $f): ?>
                            <th><?= e(ucwords(str_replace('_', ' ', $f))) ?></th>
                        <?php endforeach; ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $x): ?>
                        <tr>
                            <?php foreach ($c['fields'] as $f): ?>
                                <td><?= e(mb_substr((string)$x[$f], 0, 90)) ?></td>
                            <?php endforeach; ?>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-primary" href="?action=form&id=<?= $x['id'] ?>">Edit</a>
                                <form class="d-inline" method="post">
                                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $x['id'] ?>">
                                    <button class="btn btn-sm btn-danger" data-confirm="Hapus data ini?">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}

require __DIR__ . '/_footer.php';
?>
