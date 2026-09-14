<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$err = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    try {
        $u = trim($_POST['username'] ?? 'admin');
        $n = trim($_POST['nama_lengkap'] ?? 'Administrator Desa');
        $p = $_POST['password'] ?? '';

        if (!$u || strlen($p) < 8) {
            throw new RuntimeException('Username wajib dan password minimal 8 karakter.');
        }

        $st = db()->prepare('SELECT COUNT(*) FROM users WHERE username=?');
        $st->execute([$u]);

        if ((int)$st->fetchColumn()) {
            throw new RuntimeException('Username sudah ada.');
        }

        $st = db()->prepare('INSERT INTO users(username, password, nama_lengkap, role) VALUES(?, ?, ?, ?)');
        $st->execute([$u, password_hash($p, PASSWORD_DEFAULT), $n, 'admin']);

        $ok = 'Admin berhasil dibuat. Hapus install.php setelah selesai.';
    } catch (Throwable $e) {
        $err = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="card-clean p-4" style="width: min(560px, 94vw)">
        <h1 class="h3 fw-bold">Buat Admin Pertama</h1>

        <?php if ($err): ?>
            <div class="alert alert-danger"><?= e($err) ?></div>
        <?php endif; ?>

        <?php if ($ok): ?>
            <div class="alert alert-success"><?= e($ok) ?></div>
            <a class="btn btn-primary" href="<?= BASE_URL ?>/login.php">Ke Login</a>
        <?php else: ?>
            <form method="post" class="row g-3">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

                <div class="col-12">
                    <label>Username</label>
                    <input class="form-control" name="username" value="admin" required>
                </div>

                <div class="col-12">
                    <label>Nama Lengkap</label>
                    <input class="form-control" name="nama_lengkap" value="Administrator Desa" required>
                </div>

                <div class="col-12">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" minlength="8" required>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary w-100">Buat Admin</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
