<footer class="footer mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h5 class="text-white fw-bold">Desa Rantau Kadam</h5>
                <p>Website informasi dan pelayanan Pemerintah Desa Rantau Kadam.</p>
            </div>

            <div class="col-lg-3">
                <h6 class="text-white">Navigasi</h6>
                <div class="d-grid gap-1">
                    <a href="<?= BASE_URL ?>/profil.php">Profil</a>
                    <a href="<?= BASE_URL ?>/berita.php">Berita</a>
                    <a href="<?= BASE_URL ?>/galeri.php">Galeri</a>
                    <a href="<?= BASE_URL ?>/kontak.php">Kontak</a>
                </div>
            </div>

            <div class="col-lg-4">
                <h6 class="text-white">Kontak</h6>
                <p><?= e($site['alamat'] ?? '') ?></p>
                <p class="mb-1"><?= e($site['telepon'] ?? '') ?></p>
                <p><?= e($site['email'] ?? '') ?></p>
            </div>
        </div>

        <hr class="border-secondary">
        <small>© <?= date('Y') ?> Pemerintah Desa Rantau Kadam.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
