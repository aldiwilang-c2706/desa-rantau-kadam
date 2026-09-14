<?php
$page_title = 'Users';
$admin_active = 'users';
require __DIR__ . '/_header.php';
require_admin();

$pdo = db();
$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $a = $_POST['action'];

        if ($a === 'delete') {
            if ((int)$_POST['id'] === (int)current_user()['id']) {
                throw new RuntimeException('Akun aktif tidak boleh dihapus.');
            }
            $pdo->prepare('DELETE FROM users WHERE id=?')->execute([(int)$_POST['id']]);
            set_flash('success', 'User dihapus.');
            redirect(BASE_URL . '/admin/users.php');
        }

        if ($a === 'save') {
            $id = (int)$_POST['id'];
            $u = trim($_POST['username']);
            $n = trim($_POST['nama_lengkap']);
            $r = $_POST['role'];
            $pw = $_POST['password'] ?? '';

            if (!$u || !$n || !in_array($r, ['admin', 'editor'], true)) {
                throw new RuntimeException('Data user tidak valid.');
            }

            if ($id) {
                if ($pw) {
                    if (strlen($pw) < 8) {
                        throw new RuntimeException('Password minimal 8 karakter.');
                    }
                    $st = $pdo->prepare('UPDATE users SET username=?, nama_lengkap=?, password=?, role=? WHERE id=?');
                    $st->execute([$u, $n, password_hash($pw, PASSWORD_DEFAULT), $r, $id]);
                } else {
                    $st = $pdo->prepare('UPDATE users SET username=?, nama_lengkap=?, role=? WHERE id=?');
                    $st->execute([$u, $n, $r, $id]);
                }
            } else {
                if (strlen($pw) < 8) {
                    throw new RuntimeException('Password minimal 8 karakter.');
                }
                $st = $pdo->prepare('INSERT INTO users(username, password, nama_lengkap, role) VALUES(?, ?, ?, ?)');
                $st->execute([$u, password_hash($pw, PASSWORD_DEFAULT), $n, $r]);
            }

            set_flash('success', 'User disimpan.');
            redirect(BASE_URL . '/admin/users.php');
        }
    } catch (Throwable $e) {
        $err = $e->getMessage();
        $action = 'form';
    }
}

if ($action === 'form') {
    $x = ['id' => 0, 'username' => '', 'nama_lengkap' => '', 'role' => 'editor'];
    if ($id) {
        $st = $pdo->prepare('SELECT * FROM users WHERE id=?');
        $st->execute([$id]);
        $x = $st->fetch() ?: $x;
    }
?>
    <div class="card-clean p-4">
        <h2 class="h5 fw-bold"><?= $id ? 'Edit' : 'Tambah' ?> User</h2>

        <?php if ($err): ?>
            <div class="alert alert-danger"><?= e($err) ?></div>
        <?php endif; ?>

        <form method="post" class="row g-3 mt-1">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="col-md-6">
                <label>Username</label>
                <input class="form-control" name="username" value="<?= e($x['username']) ?>" required>
            </div>

            <div class="col-md-6">
                <label>Nama Lengkap</label>
                <input class="form-control" name="nama_lengkap" value="<?= e($x['nama_lengkap']) ?>" required>
            </div>

            <div class="col-md-6">
                <label>Password</label>
                <input class="form-control" type="password" name="password" <?= $id ? '' : 'required' ?>>
            </div>

            <div class="col-md-6">
                <label>Role</label>
                <select class="form-select" name="role">
                    <option value="admin" <?= $x['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="editor" <?= $x['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                </select>
            </div>

            <div>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
<?php } else {
    $items = $pdo->query('SELECT id, username, nama_lengkap, role, created_at FROM users ORDER BY id')->fetchAll();
?>
    <div class="d-flex justify-content-between mb-3">
        <h2 class="h5 fw-bold">Users</h2>
        <a class="btn btn-primary" href="?action=form">+ Tambah</a>
    </div>

    <div class="card-clean p-3">
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $x): ?>
                    <tr>
                        <td><?= e($x['username']) ?></td>
                        <td><?= e($x['nama_lengkap']) ?></td>
                        <td><?= e($x['role']) ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="?action=form&id=<?= $x['id'] ?>">Edit</a>
                            <?php if ($x['id'] !== (int)current_user()['id']): ?>
                                <form class="d-inline" method="post">
                                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $x['id'] ?>">
                                    <button class="btn btn-sm btn-danger" data-confirm="Hapus user ini?">Hapus</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
}

require __DIR__ . '/_footer.php';
?>
