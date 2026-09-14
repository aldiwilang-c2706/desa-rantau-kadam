<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

$site = db()->query('SELECT * FROM profil_desa ORDER BY id LIMIT 1')->fetch() ?: [];
$f = flash();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title ?? APP_NAME) ?> | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
<a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>/">
    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo Desa Rantau Kadam" height="70">
    <span>
        <strong class="d-block">DESA RANTAU KADAM</strong>
        <small class="text-muted">Kec. Karang Dapo, Kab. Musi Rawas Utara</small>
    </span>
</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li>
                        <a class="nav-link <?= ($active ?? '') === 'home' ? 'active' : '' ?>" href="<?= BASE_URL ?>/">Beranda</a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($active ?? '') === 'profil' ? 'active' : '' ?>" href="<?= BASE_URL ?>/profil.php">Profil Desa</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Informasi</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/berita.php">Berita</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/pengumuman.php">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/dokumen.php">Dokumen Publik</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link <?= ($active ?? '') === 'galeri' ? 'active' : '' ?>" href="<?= BASE_URL ?>/galeri.php">Galeri</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= BASE_URL ?>/aparatur.php">Aparatur Desa</a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($active ?? '') === 'kontak' ? 'active' : '' ?>" href="<?= BASE_URL ?>/kontak.php">Kontak</a>
                    </li>
                    <li>
                        <a class="btn btn-primary btn-sm" href="<?= BASE_URL ?>/login.php">
                            <i class="bi bi-lock"></i> Portal Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if ($f): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
        </div>
    <?php endif; ?>
