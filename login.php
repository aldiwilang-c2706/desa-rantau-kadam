<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/config/auth.php';

if(current_user()) {
    redirect(BASE_URL . '/admin/');
}

$err = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    verify_csrf();
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';

    $st = db()->prepare('SELECT * FROM users WHERE username=? LIMIT 1');
    $st->execute([$u]);
    $x = $st->fetch();

    if($x && password_verify($p, $x['password'])){
        login_user($x);
        log_activity('Login admin');
        redirect(BASE_URL . '/admin/');
    }

    $err = 'Username atau password salah.';
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-box row g-0">
        <div class="col-lg-6 login-visual p-5 d-flex flex-column justify-content-between">
            <div>
                <span class="badge bg-light text-primary">PORTAL ADMIN</span>
                <h1 class="display-6 fw-bold mt-4">Desa Rantau Kadam</h1>
                <p class="opacity-75">Kelola seluruh informasi administrasi desa dari satu dashboard.</p>
            </div>
            <small>Administrasi desa yang transparan dan aman.</small>
        </div>

        <div class="col-lg-6 p-4 p-lg-5">
            <div class="text-center mb-4">
                <div class="navbar-brand-mark mx-auto mb-3">
    <img src="<?= BASE_URL ?>/assets/img/logo.png"
         alt="Logo Desa"
         style="width: 116%; height: 110%; object-fit: contain;">
</div>
                <h2 class="h3 fw-bold">Login Admin</h2>
                <p class="text-muted">Masuk ke sistem administrasi.</p>
            </div>

            <?php if($err): ?>
                <div class="alert alert-danger"><?= e($err) ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control form-control-lg" name="username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control form-control-lg" type="password" name="password" required>
                </div>
                <button class="btn btn-primary btn-lg w-100">LOGIN</button>
            </form>

            <div class="text-center mt-4">
                <a href="<?= BASE_URL ?>/">← Kembali ke website</a>
            </div>
        </div>
    </div>
</body>
</html>
