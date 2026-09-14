<?php
$page_title = 'Dashboard';
$admin_active = 'dashboard';
require __DIR__ . '/_header.php';

$pdo = db();
$stats = [];

foreach ([
    'Berita' => 'berita',
    'Pengumuman' => 'pengumuman',
    'Galeri' => 'galeri',
    'Potensi' => 'potensi_desa',
    'Perangkat' => 'perangkat_desa',
    'Dokumen' => 'dokumen_publik',
    'Pesan' => 'pesan_kontak'
] as $n => $t) {
    $stats[$n] = $pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn();
}

$logs = $pdo->query('SELECT l.*, u.nama_lengkap FROM activity_logs l LEFT JOIN users u ON u.id = l.user_id ORDER BY l.id DESC LIMIT 10')->fetchAll();
?>

<h1 class="h3 fw-bold mb-4">Dashboard Admin</h1>

<div class="row g-3 mb-4">
    <?php foreach ($stats as $n => $v): ?>
        <div class="col-6 col-xl-2">
            <div class="card stat-card shadow-sm p-3 h-100">
                <small class="text-muted"><?= e($n) ?></small>
                <div class="display-6 fw-bold text-primary"><?= $v ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card-clean p-3">
    <h2 class="h5 fw-bold">Aktivitas Terbaru</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $l): ?>
                    <tr>
                        <td><?= $l['created_at'] ?></td>
                        <td><?= e($l['nama_lengkap'] ?? 'System') ?></td>
                        <td><?= e($l['activity']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/_footer.php'; ?>
