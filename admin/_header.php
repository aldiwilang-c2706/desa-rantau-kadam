<?php
require_once __DIR__ . '/../config/auth.php';
require_login();

$f = flash();
$admin_active = $admin_active ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title ?? 'Admin') ?> | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark" style="background: var(--primary)">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/admin/">DESA RANTAU KADAM — ADMIN</a>
            <div class="text-white">
                <?= e(current_user()['nama_lengkap']) ?>
                <a class="btn btn-sm btn-light ms-2" href="<?= BASE_URL ?>/logout.php">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-2 p-3 admin-sidebar">
                <nav class="nav flex-column gap-1">
                    <?php foreach ([
                        ['index.php', 'Dashboard', 'dashboard'],
                        ['berita.php', 'Berita', 'berita'],
                        ['pengumuman.php', 'Pengumuman', 'pengumuman'],
                        ['galeri.php', 'Galeri', 'galeri'],
                        ['potensi.php', 'Potensi Desa', 'potensi'],
                        ['perangkat.php', 'Perangkat Desa', 'perangkat'],
                        ['dokumen.php', 'Dokumen Publik', 'dokumen'],
                        ['profil.php', 'Profil Desa', 'profil'],
                        ['pesan.php', 'Pesan Masuk', 'pesan'],
                        ['users.php', 'Users', 'users']
                    ] as $m): ?>
                        <a class="nav-link <?= $admin_active === $m[2] ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/<?= $m[0] ?>">
                            <?= $m[1] ?>
                        </a>
                    <?php endforeach; ?>

                    <a class="nav-link mt-3" target="_blank" href="<?= BASE_URL ?>/">Lihat Website ↗</a>
                </nav>
            </aside>

            <main class="col-lg-10 p-3 p-lg-4">
                <?php if ($f): ?>
                    <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
                <?php endif; ?>
